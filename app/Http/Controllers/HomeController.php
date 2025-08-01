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
            // Initialize admin-specific keys with defaults
            'total_books' => Book::count(),
            'pending_book_approvals' => Book::where('is_approved', false)->count(),
            'active_categories' => BookCategory::where('is_active', true)->count(),
            'total_loan_requests' => LoanRequest::count(),
            'total_swap_requests' => SwapRequest::count(),
            'approval_rate' => 0,
            'category_stats' => collect(),
            'top_category' => null,
            'user_activity_stats' => [
                'active_users_last_30_days' => 0,
                'users_with_books' => 0,
                'users_with_loan_requests' => 0,
                'users_with_swap_requests' => 0,
            ],
            'loan_request_stats' => [
                'pending_loan_requests' => 0,
                'approved_loan_requests' => 0,
                'rejected_loan_requests' => 0,
                'completed_loan_requests' => 0,
            ],
            'swap_request_stats' => [
                'pending_swap_requests' => 0,
                'approved_swap_requests' => 0,
                'rejected_swap_requests' => 0,
                'completed_swap_requests' => 0,
            ],
            'monthly_trends' => [],
        ];

        // Additional stats for admins
        if ($isAdmin) {
            // Get category-wise book distribution
            $categoryStats = BookCategory::withCount(['books' => function($query) {
                $query->where('is_approved', true);
            }])
            ->where('is_active', true)
            ->orderBy('books_count', 'desc')
            ->get();

            // Get user activity insights
            $userActivityStats = [
                'active_users_last_30_days' => User::where('updated_at', '>=', now()->subDays(30))->count(),
                'users_with_books' => User::has('books')->count(),
                'users_with_loan_requests' => User::has('loanRequestsAsBorrower')->count(),
                'users_with_swap_requests' => User::has('swapRequestsAsRequester')->count(),
            ];

            // Get request status distribution
            $loanRequestStats = [
                'pending_loan_requests' => LoanRequest::where('status', 'pending')->count(),
                'approved_loan_requests' => LoanRequest::where('status', 'accepted')->count(),
                'rejected_loan_requests' => LoanRequest::where('status', 'rejected')->count(),
                'completed_loan_requests' => LoanRequest::where('status', 'returned')->count(),
            ];

            $swapRequestStats = [
                'pending_swap_requests' => SwapRequest::where('status', 'pending')->count(),
                'approved_swap_requests' => SwapRequest::where('status', 'approved')->count(),
                'rejected_swap_requests' => SwapRequest::where('status', 'rejected')->count(),
                'completed_swap_requests' => SwapRequest::where('status', 'completed')->count(),
            ];

            // Get monthly trends (last 12 months)
            $monthlyTrends = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthKey = $date->format('M Y');

                $monthlyTrends[$monthKey] = [
                    'users' => User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count(),
                    'books' => Book::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count(),
                    'loan_requests' => LoanRequest::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count(),
                    'swap_requests' => SwapRequest::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count(),
                ];
            }

            // Calculate approval rate
            $totalBooks = Book::count();
            $approvalRate = $totalBooks > 0 ?
                round((Book::where('is_approved', true)->count() / $totalBooks) * 100, 1) : 0;

            // Update stats array with admin data
            $stats['category_stats'] = $categoryStats;
            $stats['user_activity_stats'] = $userActivityStats;
            $stats['loan_request_stats'] = $loanRequestStats;
            $stats['swap_request_stats'] = $swapRequestStats;
            $stats['monthly_trends'] = $monthlyTrends;
            $stats['top_category'] = $categoryStats->first();
            $stats['approval_rate'] = $approvalRate;
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
