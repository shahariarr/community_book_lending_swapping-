<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        
        // Check if user is admin (Super Admin or Admin)
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Admin']);
        
        // Base stats for all users
        $stats = [
            'available_books' => 850,
            'total_categories' => 15,
        ];
        
        // Additional stats only for admins
        if ($isAdmin) {
            $stats = array_merge($stats, [
                'total_books' => 1250,
                'books_on_loan' => 320,
                'total_members' => 156,
                'active_loans' => 89,
                'book_swaps' => 45,
                'new_requests' => 23,
                'overdue_books' => 12,
                'popular_books' => 25,
                'total_users' => User::count(),
            ]);
        } else {
            // Limited stats for regular users
            $stats = array_merge($stats, [
                'my_borrowed_books' => 3,
                'my_requests' => 2,
            ]);
        }
        
        return view('home', compact('user', 'stats', 'isAdmin'));
    }
    
    public function profile()
    {
        return view('users.profile');
    }
}
