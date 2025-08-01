<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanRequest;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LoanRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Temporarily commented out for debugging
        // $this->middleware('permission:create-loan-request')->only(['create', 'store']);
        // $this->middleware('permission:approve-loan-request')->only(['approve', 'reject']);
    }

    public function index()
    {
        $user = Auth::user();

        // Requests I made to borrow books
        $myRequests = LoanRequest::with(['book.user', 'book.category', 'invoice'])
            ->where('borrower_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'my_requests_page');

        // Requests from others to borrow my books
        $requestsForMyBooks = LoanRequest::with(['borrower', 'book.category', 'invoice'])
            ->whereHas('book', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'requests_for_my_books_page');

        return view('loan-requests.index', compact('myRequests', 'requestsForMyBooks'));
    }

    public function store(Request $request)
    {
        // Debug logging
        Log::info('Loan request store method called', [
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'duration_days' => $request->duration_days,
            'all_data' => $request->all()
        ]);

        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'duration_days' => 'required|integer|min:1|max:90',
                'message' => 'nullable|string|max:500'
            ]);

            $book = Book::findOrFail($request->book_id);

            // Validation checks
            if ($book->user_id === Auth::id()) {
                Log::warning('User tried to request own book', ['user_id' => Auth::id(), 'book_id' => $book->id]);
                return back()->with('error', 'You cannot request your own book.');
            }

            if (!$book->is_approved || $book->status !== 'available') {
                Log::warning('Book not available', ['book_id' => $book->id, 'approved' => $book->is_approved, 'status' => $book->status]);
                return back()->with('error', 'This book is not available for loan.');
            }

            if (!in_array($book->availability_type, ['loan', 'both'])) {
                Log::warning('Book not available for loan', ['book_id' => $book->id, 'availability_type' => $book->availability_type]);
                return back()->with('error', 'This book is not available for loan.');
            }

            // Check if user already has a pending request for this book
            $existingRequest = LoanRequest::where('borrower_id', Auth::id())
                ->where('book_id', $book->id)
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            if ($existingRequest) {
                Log::warning('Duplicate loan request', ['user_id' => Auth::id(), 'book_id' => $book->id]);
                return back()->with('error', 'You already have a pending request for this book.');
            }

            // Calculate start and end dates based on duration
            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays($request->duration_days);

            $loanRequest = LoanRequest::create([
                'borrower_id' => Auth::id(),
                'lender_id' => $book->user_id,
                'book_id' => $book->id,
                'message' => $request->message,
                'status' => 'pending',
                'duration_days' => $request->duration_days,
                'requested_start_date' => $startDate,
                'requested_end_date' => $endDate,
            ]);

            Log::info('Loan request created successfully', [
                'loan_request_id' => $loanRequest->id,
                'borrower_id' => $loanRequest->borrower_id,
                'lender_id' => $loanRequest->lender_id,
                'book_id' => $loanRequest->book_id
            ]);

            return redirect()->route('books.show', $book)->with('success', 'Loan request sent successfully! The book owner will be notified.');

        } catch (\Exception $e) {
            Log::error('Error creating loan request', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'book_id' => $request->book_id
            ]);

            return back()->with('error', 'An error occurred while sending your request. Please try again.');
        }
    }

    public function approve(LoanRequest $loanRequest)
    {
        // Only lender can approve
        if ($loanRequest->lender_id !== Auth::id()) {
            abort(403);
        }

        if ($loanRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // Check if book is still available
        if ($loanRequest->book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        $loanRequest->update([
            'status' => 'accepted',
            'responded_at' => now(),
            'actual_start_date' => $loanRequest->requested_start_date,
            'actual_end_date' => $loanRequest->requested_end_date,
        ]);

        // Update book status
        $loanRequest->book->update(['status' => 'loaned']);

        // Generate invoice
        $invoice = InvoiceController::generateInvoice($loanRequest);

        return back()->with([
            'success' => 'Loan request approved! The book has been marked as loaned.',
            'invoice_generated' => true,
            'invoice_id' => $invoice->id
        ]);
    }

    public function reject(Request $request, LoanRequest $loanRequest)
    {
        // Only lender can reject
        if ($loanRequest->lender_id !== Auth::id()) {
            abort(403);
        }

        if ($loanRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        $loanRequest->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'lender_response' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Loan request rejected.');
    }

    public function markReturned(LoanRequest $loanRequest)
    {
        // Only lender can mark as returned
        if ($loanRequest->lender_id !== Auth::id()) {
            abort(403);
        }

        if ($loanRequest->status !== 'accepted') {
            return back()->with('error', 'This loan is not active.');
        }

        $loanRequest->update([
            'status' => 'returned',
            'returned_date' => now(),
        ]);

        // Update book status back to available
        $loanRequest->book->update(['status' => 'available']);

        // Update invoice status if exists
        if ($loanRequest->invoice) {
            $loanRequest->invoice->update(['status' => 'completed']);
        }

        return back()->with('success', 'Book marked as returned and is now available again.');
    }

    public function cancel(LoanRequest $loanRequest)
    {
        // Only borrower can cancel their own request
        if ($loanRequest->borrower_id !== Auth::id()) {
            abort(403);
        }

        if ($loanRequest->status !== 'pending') {
            return back()->with('error', 'This request cannot be cancelled.');
        }

        $loanRequest->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Loan request cancelled.');
    }

    public function show(LoanRequest $loanRequest)
    {
        // Only involved parties can view
        if (!in_array(Auth::id(), [$loanRequest->borrower_id, $loanRequest->lender_id])) {
            abort(403);
        }

        $loanRequest->load(['borrower', 'lender', 'book.category', 'invoice']);

        return view('loan-requests.show', compact('loanRequest'));
    }

    public function destroy(LoanRequest $loanRequest)
    {
        // Only the borrower can delete their own requests
        if ($loanRequest->borrower_id !== Auth::id()) {
            abort(403, 'You can only delete your own loan requests.');
        }

        // Only allow deletion of completed, cancelled, or rejected requests
        if (!in_array($loanRequest->status, ['completed', 'cancelled', 'rejected'])) {
            return back()->with('error', 'You can only delete completed, cancelled, or rejected loan requests.');
        }

        // Delete associated invoice if exists
        if ($loanRequest->invoice) {
            $loanRequest->invoice->delete();
        }

        $loanRequest->delete();

        return back()->with('success', 'Loan request deleted successfully.');
    }

    public function clearHistory()
    {
        // Delete all completed, cancelled, or rejected requests for the current user
        $deletedCount = LoanRequest::where('borrower_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled', 'rejected'])
            ->count();

        if ($deletedCount > 0) {
            // Delete associated invoices first
            $requestsToDelete = LoanRequest::where('borrower_id', Auth::id())
                ->whereIn('status', ['completed', 'cancelled', 'rejected'])
                ->with('invoice')
                ->get();

            foreach ($requestsToDelete as $request) {
                if ($request->invoice) {
                    $request->invoice->delete();
                }
                $request->delete();
            }

            return back()->with('success', "Successfully cleared {$deletedCount} loan requests from your history.");
        } else {
            return back()->with('info', 'No completed, cancelled, or rejected loan requests found to clear.');
        }
    }
}
