<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BookCategory;
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
            'total_categories' => BookCategory::count(),
            'total_users' => User::count(),
        ];

        // Additional stats for admins
        if ($isAdmin) {
            $stats = array_merge($stats, [
                'total_members' => User::count(),
                'active_categories' => BookCategory::where('is_active', true)->count(),
            ]);
        }

        return view('home', compact('user', 'stats', 'isAdmin'));
    }

    public function profile()
    {
        return view('users.profile');
    }
}
