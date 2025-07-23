<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = BookCategory::with('books')->orderBy('sort_order')->orderBy('name')->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
                            $btn = '<div class="d-flex">';
                            $btn .= '<a href="'.route("book-categories.show", $row->id).'" class="btn btn-warning btn-sm mr-2"><i class="bi bi-eye"></i> Show</a>';
                            $btn .= '<a href="'.route("book-categories.edit", $row->id).'" class="btn btn-primary btn-sm mr-2"><i class="bi bi-pencil-square"></i> Edit</a>';
                            $btn .= '<form action="'.route("book-categories.destroy", $row->id).'" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this category?\')"><i class="bi bi-trash"></i> Delete</button>
                            </form>';
                            $btn .= '</div>';
                            return $btn;
                        })
                        ->addColumn('status', function($row){
                            return $row->is_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                        })
                        ->addColumn('color_preview', function($row){
                            return '<div style="width: 20px; height: 20px; background-color: '.$row->color.'; border-radius: 3px; display: inline-block;"></div>';
                        })
                        ->addColumn('image_preview', function($row){
                            if ($row->image) {
                                return '<img src="'.asset('storage/category-images/'.$row->image).'" alt="'.$row->name.'" style="width: 40px; height: 40px; object-fit: cover; border-radius: 3px;">';
                            }
                            return '<span class="text-muted">No image</span>';
                        })
                        ->addColumn('books_count', function($row){
                            return $row->books->count();
                        })
                        ->rawColumns(['action', 'status', 'color_preview', 'image_preview'])
                        ->make(true);
            }

            return view('book-categories.index');
        } catch (Exception $e) {
            Log::error('BookCategoryController@index: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An error occurred while loading categories: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while loading categories: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('book-categories.create');
        } catch (Exception $e) {
            Log::error('BookCategoryController@create: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return redirect()->route('book-categories.index')
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
                'name' => 'required|string|max:255|unique:book_categories,name',
                'description' => 'nullable|string|max:1000',
                'color' => 'required|string|max:7',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            $data = $request->only(['name', 'description', 'color', 'icon', 'sort_order']);
            $data['slug'] = Str::slug($request->input('name'));
            $data['sort_order'] = $request->input('sort_order', 0);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->input('name')) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/category-images', $imageName);
                $data['image'] = $imageName;
            }

            BookCategory::create($data);

            return redirect()->route('book-categories.index')
                            ->with('success', 'Book category created successfully.');
        } catch (Exception $e) {
            Log::error('BookCategoryController@store: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->only(['name', 'description', 'color', 'icon', 'sort_order'])
            ]);

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'An error occurred while creating the category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookCategory $bookCategory)
    {
        try {
            $bookCategory->load(['books' => function($query) {
                $query->with('owner')->latest();
            }]);

            return view('book-categories.show', compact('bookCategory'));
        } catch (Exception $e) {
            Log::error('BookCategoryController@show: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $bookCategory->id ?? null
            ]);

            return redirect()->route('book-categories.index')
                           ->with('error', 'An error occurred while loading the category: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCategory $bookCategory)
    {
        try {
            return view('book-categories.edit', compact('bookCategory'));
        } catch (Exception $e) {
            Log::error('BookCategoryController@edit: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $bookCategory->id ?? null
            ]);

            return redirect()->route('book-categories.index')
                           ->with('error', 'An error occurred while loading the edit form: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCategory $bookCategory): RedirectResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:book_categories,name,' . $bookCategory->getKey(),
                'description' => 'nullable|string|max:1000',
                'color' => 'required|string|max:7',
                'icon' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            $data = $request->only(['name', 'description', 'color', 'icon', 'sort_order']);
            if ($request->input('name') != $bookCategory->getAttribute('name')) {
                $data['slug'] = Str::slug($request->input('name'));
            }
            $data['sort_order'] = $request->input('sort_order', 0);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($bookCategory->getAttribute('image')) {
                    Storage::delete('public/category-images/' . $bookCategory->getAttribute('image'));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->input('name')) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/category-images', $imageName);
                $data['image'] = $imageName;
            }

            $bookCategory->update($data);

            return redirect()->route('book-categories.index')
                            ->with('success', 'Book category updated successfully.');
        } catch (Exception $e) {
            Log::error('BookCategoryController@update: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $bookCategory->getKey() ?? null,
                'request_data' => $request->only(['name', 'description', 'color', 'icon', 'sort_order'])
            ]);

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'An error occurred while updating the category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCategory $bookCategory): RedirectResponse
    {
        try {
            // Check if category has books
            if ($bookCategory->books()->count() > 0) {
                return redirect()->route('book-categories.index')
                               ->with('error', 'Cannot delete category with existing books. Please move or delete the books first.');
            }

            // Delete associated image if exists
            if ($bookCategory->getAttribute('image')) {
                Storage::delete('public/category-images/' . $bookCategory->getAttribute('image'));
            }

            $bookCategory->delete();

            return redirect()->route('book-categories.index')
                            ->with('success', 'Book category deleted successfully.');
        } catch (Exception $e) {
            Log::error('BookCategoryController@destroy: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $bookCategory->getKey() ?? null
            ]);

            return redirect()->route('book-categories.index')
                           ->with('error', 'An error occurred while deleting the category: ' . $e->getMessage());
        }
    }
}
