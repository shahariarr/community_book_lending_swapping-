<?php

use App\Http\Controllers as Con;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\FeedbackController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'home'])->name('frontend.home');

Route::get('/browse-books', [App\Http\Controllers\Frontend\FrontendController::class, 'browseBooks'])->name('frontend.browse-books');

Route::get('/categories', [App\Http\Controllers\Frontend\FrontendController::class, 'category'])->name('frontend.category');

Route::get('/about-us', [App\Http\Controllers\Frontend\FrontendController::class, 'about'])->name('frontend.about');

Route::get('/contact-us', [App\Http\Controllers\Frontend\FrontendController::class, 'contact'])->name('frontend.contact');

Route::get('/blog', [App\Http\Controllers\Frontend\FrontendController::class, 'blog'])->name('frontend.blog');



Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

// Google OAuth Routes
Route::get('auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

//dahsboard
Route::get('/home', function () {
    return redirect()->route('dashboard');
});


//clear cache
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');

    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('clear');

//route cache
Route::get('/route', function () {
    Artisan::call('permission:create-permission-routes');
    return redirect()->back()->withSuccess('Cache cleared successfully.');
})->name('route');


Auth::routes();




Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [Con\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [Con\HomeController::class, 'profile'])->name('users.profile');

    // Books Management
    Route::get('/books', [Con\BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [Con\BookController::class, 'search'])->name('books.search');
    Route::get('/books/my-books', [Con\BookController::class, 'myBooks'])->name('books.my-books');
    Route::get('/books/create', [Con\BookController::class, 'create'])->name('books.create');
    Route::post('/books', [Con\BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}', [Con\BookController::class, 'show'])->name('books.show');
    Route::get('/books/{book}/edit', [Con\BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [Con\BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [Con\BookController::class, 'destroy'])->name('books.destroy');

    // Loan Requests
    Route::get('/loan-requests', [Con\LoanRequestController::class, 'index'])->name('loan-requests.index');
    Route::post('/loan-requests', [Con\LoanRequestController::class, 'store'])->name('loan-requests.store');
    Route::get('/loan-requests/{loanRequest}', [Con\LoanRequestController::class, 'show'])->name('loan-requests.show');
    Route::post('/loan-requests/{loanRequest}/approve', [Con\LoanRequestController::class, 'approve'])->name('loan-requests.approve');
    Route::post('/loan-requests/{loanRequest}/reject', [Con\LoanRequestController::class, 'reject'])->name('loan-requests.reject');
    Route::post('/loan-requests/{loanRequest}/cancel', [Con\LoanRequestController::class, 'cancel'])->name('loan-requests.cancel');
    Route::post('/loan-requests/{loanRequest}/return', [Con\LoanRequestController::class, 'markReturned'])->name('loan-requests.return');
    Route::delete('/loan-requests/{loanRequest}', [Con\LoanRequestController::class, 'destroy'])->name('loan-requests.destroy');
    Route::post('/loan-requests/clear-history', [Con\LoanRequestController::class, 'clearHistory'])->name('loan-requests.clear-history');

    // Invoices
    Route::get('/invoices/{invoice}', [Con\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [Con\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/invoices/{invoice}/print', [Con\InvoiceController::class, 'print'])->name('invoices.print');

    // Swap Requests
    Route::get('/swap-requests', [Con\SwapRequestController::class, 'index'])->name('swap-requests.index');
    Route::get('/swap-requests/create/{book}', [Con\SwapRequestController::class, 'create'])->name('swap-requests.create');
    Route::post('/swap-requests', [Con\SwapRequestController::class, 'store'])->name('swap-requests.store');
    Route::get('/swap-requests/{swapRequest}', [Con\SwapRequestController::class, 'show'])->name('swap-requests.show');
    Route::post('/swap-requests/{swapRequest}/approve', [Con\SwapRequestController::class, 'approve'])->name('swap-requests.approve');
    Route::post('/swap-requests/{swapRequest}/reject', [Con\SwapRequestController::class, 'reject'])->name('swap-requests.reject');
    Route::post('/swap-requests/{swapRequest}/cancel', [Con\SwapRequestController::class, 'cancel'])->name('swap-requests.cancel');
    Route::post('/swap-requests/{swapRequest}/return', [Con\SwapRequestController::class, 'returnBooks'])->name('swap-requests.return');
    Route::delete('/swap-requests/{swapRequest}', [Con\SwapRequestController::class, 'destroy'])->name('swap-requests.destroy');
    Route::post('/swap-requests/clear-history', [Con\SwapRequestController::class, 'clearHistory'])->name('swap-requests.clear-history');

    // Admin Routes
    Route::group(['middleware' => 'role:Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/dashboard', [Con\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/books', [Con\Admin\AdminController::class, 'allBooks'])->name('books.index');
        Route::get('/books/pending', [Con\Admin\AdminController::class, 'pendingBooks'])->name('books.pending');
        Route::get('/books/all', [Con\Admin\AdminController::class, 'allBooks'])->name('books.all');
        Route::get('/books/{book}', [Con\Admin\AdminController::class, 'bookDetails'])->name('books.show');
        Route::patch('/books/{book}/approve', [Con\Admin\AdminController::class, 'approveBook'])->name('books.approve');
        Route::delete('/books/{book}/reject', [Con\Admin\AdminController::class, 'rejectBook'])->name('books.reject');
        Route::delete('/books/{book}', [Con\Admin\AdminController::class, 'quickReject'])->name('books.quick-reject');
        Route::get('/users', [Con\Admin\AdminController::class, 'allUsers'])->name('users.index');
        Route::get('/users/{user}', [Con\Admin\AdminController::class, 'userDetails'])->name('users.show');
        Route::post('/users/{user}/toggle-status', [Con\Admin\AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::get('/loan-requests', [Con\Admin\AdminController::class, 'loanRequests'])->name('loan-requests.index');
        Route::get('/swap-requests', [Con\Admin\AdminController::class, 'swapRequests'])->name('swap-requests.index');
        Route::get('/reports', [Con\Admin\AdminController::class, 'reports'])->name('reports.index');
        Route::get('/categories', [Con\BookCategoryController::class, 'index'])->name('categories.index');
    });

    Route::resources([
        'roles' => Con\RoleController::class,
        'users' => Con\UserController::class,
        'permissions' => Con\PermissionController::class,
        'book-categories' => Con\BookCategoryController::class,
    ]);
});




