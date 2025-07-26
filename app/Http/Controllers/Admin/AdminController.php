<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\LoanRequest;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin|Super Admin');
        $this->middleware('permission:view-book-requests')->only(['bookRequests']);
        $this->middleware('permission:approve-book')->only(['approveBook']);
        $this->middleware('permission:reject-book')->only(['rejectBook']);
    }

    public function dashboard()
    {
        // Enhanced statistics with trends
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'pending_books' => Book::where('is_approved', false)->count(),
            'approved_books' => Book::where('is_approved', true)->count(),
            'active_loans' => LoanRequest::where('status', 'approved')->count(),
            'pending_loan_requests' => LoanRequest::where('status', 'pending')->count(),
            'active_swaps' => SwapRequest::where('status', 'approved')->count(),
            'pending_swap_requests' => SwapRequest::where('status', 'pending')->count(),
        ];

        // Add trend data (comparing with last month)
        $lastMonth = now()->subMonth();
        $stats['trends'] = [
            'users_growth' => User::where('created_at', '>=', $lastMonth)->count(),
            'books_growth' => Book::where('created_at', '>=', $lastMonth)->count(),
            'loans_growth' => LoanRequest::where('created_at', '>=', $lastMonth)->count(),
            'swaps_growth' => SwapRequest::where('created_at', '>=', $lastMonth)->count(),
        ];

        // Recent activities with enhanced data
        $recentBooks = Book::with(['user', 'category'])
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // System health metrics
        $systemHealth = [
            'server_status' => 'online',
            'database_status' => 'connected',
            'storage_status' => 'available',
            'last_backup' => now()->subHours(6),
        ];

        // Today's tasks summary
        $todaysTasks = [
            'pending_approvals' => $stats['pending_books'],
            'pending_loans' => $stats['pending_loan_requests'],
            'pending_swaps' => $stats['pending_swap_requests'],
            'system_maintenance' => false,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentBooks',
            'recentUsers',
            'systemHealth',
            'todaysTasks'
        ));
    }

    public function pendingBooks()
    {
        $books = Book::with(['user', 'category'])
            ->where('is_approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.books.pending', compact('books'));
    }

    public function approveBook(Book $book)
    {
        if ($book->is_approved) {
            return back()->with('error', 'Book is already approved.');
        }

        $book->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'status' => 'available'
        ]);

        return back()->with('success', 'Book approved successfully!');
    }

    public function rejectBook(Request $request, Book $book)
    {
        $request->validate([
            'rejection_reason' => 'sometimes|string|max:500'
        ]);

        $rejectionReason = $request->input('rejection_reason', 'Book rejected by administrator');

        // Store rejection information before deletion (optional)
        Log::info("Book rejected: {$book->title} by user {$book->user->name}. Reason: {$rejectionReason}");

        // You might want to store rejection reason in a separate table or add a field
        // For now, we'll delete the book but you could modify this behavior
        $book->delete();

        return back()->with('success', 'Book rejected and removed successfully.');
    }

    public function quickReject(Book $book)
    {
        if ($book->is_approved) {
            return back()->with('error', 'Cannot reject an already approved book.');
        }

        // Quick rejection with default reason
        Log::info("Book quick-rejected: {$book->title} by user {$book->user->name}");
        $book->delete();

        return back()->with('success', 'Book rejected successfully.');
    }

    public function allBooks()
    {
        $books = Book::with(['user', 'category', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.books.all', compact('books'));
    }

    public function allUsers()
    {
        $users = User::with('roles')
            ->withCount(['books', 'loanRequestsAsBorrower', 'swapRequestsAsRequester'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function loanRequests()
    {
        $loanRequests = LoanRequest::with(['borrower', 'lender', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.loan-requests.index', compact('loanRequests'));
    }

    public function swapRequests()
    {
        $swapRequests = SwapRequest::with(['requester', 'owner', 'requestedBook', 'offeredBook'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.swap-requests.index', compact('swapRequests'));
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->hasRole('Admin')) {
            return back()->with('error', 'Cannot deactivate admin users.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully!");
    }

    public function bookDetails(Book $book)
    {
        $book->load(['user', 'category', 'approvedBy', 'loanRequests.borrower', 'swapRequestsAsRequested.requester']);

        return view('admin.books.show', compact('book'));
    }

    public function userDetails(User $user)
    {
        $user->load(['roles', 'books.category', 'loanRequestsAsBorrower.book', 'swapRequestsAsRequester.requestedBook']);

        $stats = [
            'total_books' => $user->books()->count(),
            'approved_books' => $user->books()->where('is_approved', true)->count(),
            'pending_books' => $user->books()->where('is_approved', false)->count(),
            'active_loans' => $user->loanRequestsAsBorrower()->where('status', 'approved')->count(),
            'completed_loans' => $user->loanRequestsAsBorrower()->where('status', 'completed')->count(),
            'active_swaps' => $user->swapRequestsAsRequester()->where('status', 'approved')->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }
}
