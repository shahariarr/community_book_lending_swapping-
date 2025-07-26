<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:approve-book')->only(['approve', 'reject']);
        $this->middleware('permission:manage-books')->only(['destroy']);
    }

    public function index()
    {
        $books = Book::with(['user', 'category'])
            ->approved()
            ->available()
            ->paginate(12);

        $categories = BookCategory::where('is_active', true)->get();

        return view('books.index', compact('books', 'categories'));
    }

    public function myBooks()
    {
        $books = Book::where('user_id', Auth::id())
            ->with(['category', 'loanRequests', 'swapRequestsAsRequested'])
            ->paginate(10);

        return view('books.my-books', compact('books'));
    }

    public function show(Book $book)
    {
        $book->load(['user', 'category', 'reviews.user']);

        // Check if current user can request this book
        $canRequest = Auth::check() &&
                     $book->user_id !== Auth::id() &&
                     $book->is_approved &&
                     $book->status === 'available';

        return view('books.show', compact('book', 'canRequest'));
    }

    public function create()
    {
        $categories = BookCategory::where('is_active', true)->get();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'required|string',
            'category_id' => 'required|exists:book_categories,id',
            'condition' => 'required|in:new,like_new,good,fair,poor',
            'availability_type' => 'required|in:loan,swap,both',
            'published_date' => 'nullable|date',
            'language' => 'nullable|string|max:10',
            'page_count' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Check if auto-approval is enabled
        $autoApprove = config('app.auto_approve_books', false);

        if ($autoApprove) {
            $data['is_approved'] = true;
            $data['approved_at'] = now();
            $data['approved_by'] = Auth::id();
            $data['status'] = 'available';
        } else {
            $data['is_approved'] = false; // Requires admin approval
            $data['status'] = 'unavailable'; // Will be available after approval
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book = Book::create($data);

        return redirect()->route('books.my-books')
            ->with('success', 'Book upload request submitted! It will be visible after admin approval.');
    }

    public function edit(Book $book)
    {
        // Only owner can edit
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = BookCategory::where('is_active', true)->get();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        // Only owner can edit
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'description' => 'required|string',
            'category_id' => 'required|exists:book_categories,id',
            'condition' => 'required|in:new,like_new,good,fair,poor',
            'availability_type' => 'required|in:loan,swap,both',
            'published_date' => 'nullable|date',
            'language' => 'nullable|string|max:10',
            'page_count' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        // If book was approved and content changed significantly, require re-approval
        if ($book->is_approved && ($book->title !== $data['title'] || $book->description !== $data['description'])) {
            $data['is_approved'] = false;
            $data['status'] = 'unavailable';
            $message = 'Book updated! Since major changes were made, it requires admin re-approval.';
        } else {
            $message = 'Book updated successfully!';
        }

        $book->update($data);

        return redirect()->route('books.my-books')->with('success', $message);
    }

    public function destroy(Book $book)
    {
        // Only owner can delete
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        // Can't delete if book is currently loaned or in active requests
        if ($book->status === 'loaned' || $book->loanRequests()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'Cannot delete book with active loan requests or while loaned.');
        }

        // Delete image
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('books.my-books')->with('success', 'Book deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = Book::with(['user', 'category'])
            ->approved()
            ->available();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('availability_type')) {
            $query->where('availability_type', $request->availability_type);
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = BookCategory::where('is_active', true)->get();

        return view('books.index', compact('books', 'categories'));
    }
}
