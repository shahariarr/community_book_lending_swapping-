<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\LoanRequest;
use App\Models\SwapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Load user with roles relationship
        $user = User::with('roles')->find(Auth::id());

        // Check if user is admin (simplified check for now)
        $isAdmin = $user->hasRole('Admin');

        // Base stats for all users
        $stats = [
            'my_books' => Book::where('user_id', Auth::id())->count(),
            'my_approved_books' => Book::where('user_id', Auth::id())->where('is_approved', true)->count(),
            'my_pending_books' => Book::where('user_id', Auth::id())->where('is_approved', false)->count(),
            'my_loan_requests' => LoanRequest::where('borrower_id', Auth::id())->count(),
            'loan_requests_for_my_books' => LoanRequest::whereHas('book', function($query) {
                $query->where('user_id', Auth::id());
            })->count(),
            'my_swap_requests' => SwapRequest::where('requester_id', Auth::id())->count(),
            'swap_requests_for_my_books' => SwapRequest::whereHas('requestedBook', function($query) {
                $query->where('user_id', Auth::id());
            })->count(),
            'available_books' => Book::approved()->available()->where('user_id', '!=', Auth::id())->count(),
            'total_categories' => BookCategory::count(),
            'total_users' => User::count(),
        ];

        // Additional stats for admins
        if ($isAdmin) {
            $adminStats = [
                'total_books' => Book::count(),
                'pending_book_approvals' => Book::where('is_approved', false)->count(),
                'active_categories' => BookCategory::where('is_active', true)->count(),
                'total_loan_requests' => LoanRequest::count(),
                'total_swap_requests' => SwapRequest::count(),
            ];
            $stats = array_merge($stats, $adminStats);
        }

        // Recent activity for user
        $recentLoanRequests = LoanRequest::with(['book', 'borrower', 'lender'])
            ->where(function($query) {
                $query->where('borrower_id', Auth::id())
                      ->orWhere('lender_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentSwapRequests = SwapRequest::with(['requestedBook', 'offeredBook', 'requester', 'owner'])
            ->where(function($query) {
                $query->where('requester_id', Auth::id())
                      ->orWhere('owner_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Latest available books for browsing
        $latestBooks = Book::with(['user', 'category'])
            ->approved()
            ->available()
            ->where('user_id', '!=', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('user', 'stats', 'isAdmin', 'recentLoanRequests', 'recentSwapRequests', 'latestBooks'));
    }

    public function profile()
    {
        return view('users.profile');
    }
}
