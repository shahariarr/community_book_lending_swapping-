<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\SwapRequest;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SwapRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Temporarily commented out for debugging
        // $this->middleware('permission:create-swap-request')->only(['create', 'store']);
        // $this->middleware('permission:approve-swap-request')->only(['approve', 'reject']);
    }

    public function index()
    {
        $user = Auth::user();

        // Requests I made to swap books
        $myRequests = SwapRequest::with(['requestedBook.user', 'offeredBook.user', 'requestedBook.category', 'offeredBook.category', 'invoice'])
            ->where('requester_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'my_requests_page');

        // Requests from others to swap with my books
        $requestsForMyBooks = SwapRequest::with(['requester', 'requestedBook.category', 'offeredBook.category', 'invoice'])
            ->whereHas('requestedBook', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'requests_for_my_books_page');

        return view('swap-requests.index', compact('myRequests', 'requestsForMyBooks'));
    }

    public function create(Book $book)
    {
        // Check if book is available for swap
        if (!$book->is_approved || $book->status !== 'available') {
            return back()->with('error', 'This book is not available for swap.');
        }

        if (!in_array($book->availability_type, ['swap', 'both'])) {
            return back()->with('error', 'This book is not available for swap.');
        }

        if ($book->user_id === Auth::id()) {
            return back()->with('error', 'You cannot swap with your own book.');
        }

        // Get user's available books for swapping
        $myBooks = Book::where('user_id', Auth::id())
            ->approved()
            ->available()
            ->whereIn('availability_type', ['swap', 'both'])
            ->get();

        if ($myBooks->isEmpty()) {
            return back()->with('error', 'You need to have approved books available for swap to make this request.');
        }

        return view('swap-requests.create', compact('book', 'myBooks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'requested_book_id' => 'required|exists:books,id',
            'offered_book_id' => 'required|exists:books,id',
            'swap_duration_days' => 'required|integer|min:7|max:90',
            'message' => 'nullable|string|max:500'
        ]);

        $requestedBook = Book::findOrFail($request->requested_book_id);
        $offeredBook = Book::findOrFail($request->offered_book_id);

        // Validation checks
        if ($requestedBook->user_id === Auth::id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        if ($offeredBook->user_id !== Auth::id()) {
            return back()->with('error', 'You can only offer your own books.');
        }

        if (!$requestedBook->is_approved || $requestedBook->status !== 'available') {
            return back()->with('error', 'The requested book is not available for swap.');
        }

        if (!$offeredBook->is_approved || $offeredBook->status !== 'available') {
            return back()->with('error', 'Your offered book is not available for swap.');
        }

        if (!in_array($requestedBook->availability_type, ['swap', 'both'])) {
            return back()->with('error', 'The requested book is not available for swap.');
        }

        if (!in_array($offeredBook->availability_type, ['swap', 'both'])) {
            return back()->with('error', 'Your offered book is not available for swap.');
        }

        // Check if user already has a pending request for this book combination
        $existingRequest = SwapRequest::where('requester_id', Auth::id())
            ->where('requested_book_id', $requestedBook->id)
            ->where('offered_book_id', $offeredBook->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending swap request with these books.');
        }

        SwapRequest::create([
            'requester_id' => Auth::id(),
            'owner_id' => $requestedBook->user_id,
            'requested_book_id' => $requestedBook->id,
            'offered_book_id' => $offeredBook->id,
            'message' => $request->message,
            'duration_days' => $request->swap_duration_days,
            'duration_type' => 'day',
            'status' => 'pending',
        ]);

        return redirect()->route('swap-requests.index')
            ->with('success', 'Swap request sent successfully!');
    }

    public function approve(SwapRequest $swapRequest)
    {
        // Only owner can approve
        if ($swapRequest->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($swapRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // Check if both books are still available
        if ($swapRequest->requestedBook->status !== 'available' ||
            $swapRequest->offeredBook->status !== 'available') {
            return back()->with('error', 'One or both books are no longer available.');
        }

        // Set swap dates
        $startDate = now()->toDateString();
        $endDate = now()->addDays($swapRequest->swap_duration_days)->toDateString();

        DB::transaction(function() use ($swapRequest, $startDate, $endDate) {
            // Update swap request
            $swapRequest->update([
                'status' => 'accepted',
                'responded_at' => now(),
                'swap_start_date' => $startDate,
                'swap_end_date' => $endDate,
                'swap_status' => 'active',
            ]);

            // Update book statuses
            $swapRequest->requestedBook->update(['status' => 'swapped']);
            $swapRequest->offeredBook->update(['status' => 'swapped']);

            // Actually swap the book ownership
            $requestedBookUserId = $swapRequest->requestedBook->user_id;
            $offeredBookUserId = $swapRequest->offeredBook->user_id;

            $swapRequest->requestedBook->update(['user_id' => $offeredBookUserId, 'status' => 'available']);
            $swapRequest->offeredBook->update(['user_id' => $requestedBookUserId, 'status' => 'available']);

            // Generate invoice
            $invoice = InvoiceController::generateSwapInvoice($swapRequest);
        });

        return back()->with([
            'success' => 'Swap request approved! Books have been exchanged and invoice generated.',
            'invoice_generated' => true,
            'swap_approved' => true
        ]);
    }

    public function reject(Request $request, SwapRequest $swapRequest)
    {
        // Only owner can reject
        if ($swapRequest->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($swapRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        $swapRequest->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Swap request rejected.');
    }

    public function cancel(SwapRequest $swapRequest)
    {
        // Only requester can cancel their own request
        if ($swapRequest->requester_id !== Auth::id()) {
            abort(403);
        }

        if ($swapRequest->status !== 'pending') {
            return back()->with('error', 'This request cannot be cancelled.');
        }

        $swapRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Swap request cancelled.');
    }

    public function returnBooks(SwapRequest $swapRequest)
    {
        // Both parties can initiate return
        if (!in_array(Auth::id(), [$swapRequest->requester_id, $swapRequest->owner_id])) {
            abort(403);
        }

        if ($swapRequest->status !== 'accepted' || $swapRequest->swap_status !== 'active') {
            return back()->with('error', 'This swap is not active.');
        }

        DB::transaction(function() use ($swapRequest) {
            // Update swap request
            $swapRequest->update([
                'status' => 'completed',
                'swap_status' => 'returned',
                'actual_return_date' => now(),
                'completed_at' => now(),
            ]);

            // Return books to original owners
            $originalRequestedBookOwner = $swapRequest->owner_id;
            $originalOfferedBookOwner = $swapRequest->requester_id;

            $swapRequest->requestedBook->update([
                'user_id' => $originalRequestedBookOwner,
                'status' => 'available'
            ]);
            $swapRequest->offeredBook->update([
                'user_id' => $originalOfferedBookOwner,
                'status' => 'available'
            ]);

            // Update invoice status if exists
            if ($swapRequest->invoice) {
                $swapRequest->invoice->update(['status' => 'completed']);
            }
        });

        return back()->with('success', 'Books have been successfully returned to their original owners.');
    }

    public function show(SwapRequest $swapRequest)
    {
        // Only involved parties can view
        if (!in_array(Auth::id(), [$swapRequest->requester_id, $swapRequest->owner_id])) {
            abort(403);
        }

        $swapRequest->load(['requester', 'owner', 'requestedBook.category', 'offeredBook.category', 'invoice']);

        return view('swap-requests.show', compact('swapRequest'));
    }

    public function destroy(SwapRequest $swapRequest)
    {
        // Only the requester can delete their own swap requests
        if ($swapRequest->requester_id !== Auth::id()) {
            abort(403, 'You can only delete your own swap requests.');
        }

        // Only allow deletion of completed, cancelled, or rejected requests
        if (!in_array($swapRequest->status, ['completed', 'cancelled', 'rejected'])) {
            return back()->with('error', 'You can only delete completed, cancelled, or rejected swap requests.');
        }

        // Delete associated invoice if exists
        if ($swapRequest->invoice) {
            $swapRequest->invoice->delete();
        }

        $swapRequest->delete();

        return back()->with('success', 'Swap request deleted successfully.');
    }

    public function clearHistory()
    {
        // Delete all completed, cancelled, or rejected requests for the current user
        $deletedCount = SwapRequest::where('requester_id', Auth::id())
            ->whereIn('status', ['completed', 'cancelled', 'rejected'])
            ->count();

        if ($deletedCount > 0) {
            // Delete associated invoices first
            $requestsToDelete = SwapRequest::where('requester_id', Auth::id())
                ->whereIn('status', ['completed', 'cancelled', 'rejected'])
                ->with('invoice')
                ->get();

            foreach ($requestsToDelete as $request) {
                if ($request->invoice) {
                    $request->invoice->delete();
                }
                $request->delete();
            }

            return back()->with('success', "Successfully cleared {$deletedCount} swap requests from your history.");
        } else {
            return back()->with('info', 'No completed, cancelled, or rejected swap requests found to clear.');
        }
    }
}
