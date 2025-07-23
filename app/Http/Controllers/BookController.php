<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Book::with(['category', 'owner'])->latest()->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<div class="d-flex">';
                            $btn .= '<a href="'.route("books.show", $row->id).'" class="btn btn-warning btn-sm mr-2"><i class="bi bi-eye"></i> Show</a>';
                            $btn .= '<a href="'.route("books.edit", $row->id).'" class="btn btn-primary btn-sm mr-2"><i class="bi bi-pencil-square"></i> Edit</a>';
                            $btn .= '<form action="'.route("books.destroy", $row->id).'" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this book?\')"><i class="bi bi-trash"></i> Delete</button>
                            </form>';
                            $btn .= '</div>';
                            return $btn;
                        })
                        ->addColumn('cover_preview', function($row){
                            if ($row->cover_image) {
                                return '<img src="'.asset('storage/book-covers/'.$row->cover_image).'" alt="'.$row->title.'" style="width: 40px; height: 40px; object-fit: cover; border-radius: 3px;">';
                            }
                            return '<span class="text-muted">No cover</span>';
                        })
                        ->addColumn('category_name', function($row){
                            return $row->category ? $row->category->name : '<span class="text-muted">No category</span>';
                        })
                        ->addColumn('owner_name', function($row){
                            return $row->owner ? $row->owner->name : '<span class="text-muted">Unknown</span>';
                        })
                        ->addColumn('status', function($row){
                            return '<span class="badge '.$row->status_badge.'">'.$row->availability_status.'</span>';
                        })
                        ->addColumn('condition_badge', function($row){
                            return '<span class="badge '.$row->condition_badge.'">'.$row->condition.'</span>';
                        })
                        ->rawColumns(['action', 'cover_preview', 'category_name', 'owner_name', 'status', 'condition_badge'])
                        ->make(true);
            }

            return view('books.index');
        } catch (Exception $e) {
            Log::error('BookController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An error occurred while loading books: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while loading books: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $categories = BookCategory::active()->orderBy('name')->get();
            $selectedCategory = $request->get('category');

            return view('books.create', compact('categories', 'selectedCategory'));
        } catch (Exception $e) {
            Log::error('BookController@create: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return redirect()->route('books.index')
                           ->with('error', 'An error occurred while loading the create form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'nullable|string|max:50|unique:books,isbn',
                'description' => 'nullable|string|max:2000',
                'publisher' => 'nullable|string|max:255',
                'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
                'pages' => 'nullable|integer|min:1',
                'language' => 'nullable|string|max:50',
                'condition' => 'required|in:New,Good,Fair,Poor',
                'availability_status' => 'required|in:Available,Borrowed,Reserved,Maintenance',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string|max:1000',
                'book_category_id' => 'required|exists:book_categories,id'
            ]);

            $data = $request->only([
                'title', 'author', 'isbn', 'description', 'publisher',
                'publication_year', 'pages', 'language', 'condition',
                'availability_status', 'price', 'notes', 'book_category_id'
            ]);

            $data['owner_id'] = Auth::id();
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '_' . str_replace(' ', '_', $request->input('title')) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/book-covers', $imageName);
                $data['cover_image'] = $imageName;
            }

            Book::create($data);

            return redirect()->route('books.index')
                            ->with('success', 'Book added successfully.');
        } catch (Exception $e) {
            Log::error('BookController@store: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->only(['title', 'author', 'isbn', 'book_category_id'])
            ]);

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'An error occurred while creating the book: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        try {
            $book->load(['category', 'owner']);

            return view('books.show', compact('book'));
        } catch (Exception $e) {
            Log::error('BookController@show: ' . $e->getMessage(), [
                'exception' => $e,
                'book_id' => $book->id ?? null
            ]);

            return redirect()->route('books.index')
                           ->with('error', 'An error occurred while loading the book: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        try {
            $categories = BookCategory::active()->orderBy('name')->get();

            return view('books.edit', compact('book', 'categories'));
        } catch (Exception $e) {
            Log::error('BookController@edit: ' . $e->getMessage(), [
                'exception' => $e,
                'book_id' => $book->id ?? null
            ]);

            return redirect()->route('books.index')
                           ->with('error', 'An error occurred while loading the edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'nullable|string|max:50|unique:books,isbn,' . $book->getKey(),
                'description' => 'nullable|string|max:2000',
                'publisher' => 'nullable|string|max:255',
                'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
                'pages' => 'nullable|integer|min:1',
                'language' => 'nullable|string|max:50',
                'condition' => 'required|in:New,Good,Fair,Poor',
                'availability_status' => 'required|in:Available,Borrowed,Reserved,Maintenance',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string|max:1000',
                'book_category_id' => 'required|exists:book_categories,id'
            ]);

            $data = $request->only([
                'title', 'author', 'isbn', 'description', 'publisher',
                'publication_year', 'pages', 'language', 'condition',
                'availability_status', 'price', 'notes', 'book_category_id'
            ]);

            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                // Delete old image if exists
                if ($book->getAttribute('cover_image')) {
                    Storage::delete('public/book-covers/' . $book->getAttribute('cover_image'));
                }

                $image = $request->file('cover_image');
                $imageName = time() . '_' . str_replace(' ', '_', $request->input('title')) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/book-covers', $imageName);
                $data['cover_image'] = $imageName;
            }

            $book->update($data);

            return redirect()->route('books.index')
                            ->with('success', 'Book updated successfully.');
        } catch (Exception $e) {
            Log::error('BookController@update: ' . $e->getMessage(), [
                'exception' => $e,
                'book_id' => $book->getKey() ?? null,
                'request_data' => $request->only(['title', 'author', 'isbn', 'book_category_id'])
            ]);

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'An error occurred while updating the book: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        try {
            // Delete associated cover image if exists
            if ($book->getAttribute('cover_image')) {
                Storage::delete('public/book-covers/' . $book->getAttribute('cover_image'));
            }

            $book->delete();

            return redirect()->route('books.index')
                            ->with('success', 'Book deleted successfully.');
        } catch (Exception $e) {
            Log::error('BookController@destroy: ' . $e->getMessage(), [
                'exception' => $e,
                'book_id' => $book->getKey() ?? null
            ]);

            return redirect()->route('books.index')
                           ->with('error', 'An error occurred while deleting the book: ' . $e->getMessage());
        }
    }
}
