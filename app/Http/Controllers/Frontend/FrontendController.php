<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        // Get featured categories for the discover section
        $categories = BookCategory::where('is_active', true)
            ->withCount('books')
            ->orderBy('sort_order', 'asc')
            ->take(5)
            ->get();

        // Get all available books for the properties section
        $allBooks = Book::with(['category', 'user'])
            ->where('is_approved', true)
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.home', compact('categories', 'allBooks'));
    }

    public function browseBooks(Request $request)
    {
        $query = Book::with(['category', 'user'])
            ->where('is_approved', true)
            ->where('status', 'available');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $category = BookCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by search term
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('author', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }

        // Filter by availability type
        if ($request->has('availability_type') && $request->availability_type) {
            $query->where('availability_type', $request->availability_type);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'author_asc':
                $query->orderBy('author', 'asc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $books = $query->paginate(6);
        $categories = BookCategory::where('is_active', true)->orderBy('name')->get();

        return view('frontend.browse-books', compact('books', 'categories'));
    }

    public function category()
    {
        $categories = BookCategory::where('is_active', true)
            ->withCount('books')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('frontend.category', compact('categories'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function blog()
    {
        return view('frontend.blog');
    }
}
