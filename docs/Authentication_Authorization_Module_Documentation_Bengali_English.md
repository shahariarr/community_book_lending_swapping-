# Authentication and Authorization Module Documentation

## Table of Contents
- [Overview](#overview)
- [Architecture](#architecture)
- [Authentication System](#authentication-system)
- [Authorization System](#authorization-system)
- [Database Schema](#database-schema)
- [Implementation Details](#implementation-details)
- [Security Features](#security-features)
- [Usage Examples](#usage-examples)
- [Troubleshooting](#troubleshooting)

---

## Overview

The Authentication and Authorization module is a comprehensive security system built for the Community Book Lending & Swapping Platform. It provides multi-layered access control using Laravel's built-in authentication combined with the Spatie Laravel Permission package for role-based access control (RBAC).

### Key Features
- **Dual Authentication**: Traditional email/password and Google OAuth
- **Role-Based Access Control**: Super Admin, Admin, and User roles
- **Granular Permissions**: Fine-grained permission system
- **Secure Middleware**: Multiple layers of route protection
- **Dynamic UI**: Permission-based interface rendering
- **Social Integration**: Google OAuth with account linking

---

## Architecture

### System Components

```
Authentication & Authorization Module
├── Authentication Layer
│   ├── Traditional Login/Register
│   ├── Google OAuth Integration
│   └── Session Management
├── Authorization Layer
│   ├── Role-Based Access Control (RBAC)
│   ├── Permission System
│   └── Gate-Based Authorization
├── Middleware Layer
│   ├── Authentication Middleware
│   ├── Role Middleware
│   └── Permission Middleware
└── Database Layer
    ├── Users Table
    ├── Roles & Permissions Tables
    └── Pivot Tables
```

### Technology Stack
- **Laravel Framework**: Core authentication system
- **Spatie Laravel Permission**: RBAC implementation
- **Laravel Socialite**: Google OAuth integration
- **MySQL**: Database storage
- **Blade Templates**: Frontend integration

---

## Authentication System

### 1. Traditional Authentication

#### Implementation Location
- **Routes**: `routes/web.php`
- **Views**: `resources/views/auth/`
- **Controllers**: Laravel's built-in Auth controllers

#### Login Process Flow

```php
// Route Definition
Auth::routes();

// Login Form (resources/views/auth/login.blade.php)
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
```

**Code Explanation:**
- Uses Laravel's built-in `Auth::routes()` to register authentication routes
- CSRF protection is enabled via `@csrf` directive
- Form data is validated and processed by Laravel's AuthenticateUsers trait

#### Registration Process

```php
// Registration form includes role assignment
// After successful registration, users are assigned default 'User' role
$user = User::create($validatedData);
$user->assignRole('User'); // Automatic role assignment
```

### 2. Google OAuth Authentication

#### Implementation Files
- **Controller**: `app/Http/Controllers/Auth/SocialAuthController.php`
- **Routes**: Google OAuth specific routes

#### OAuth Flow Implementation

```php
<?php
namespace App\Http\Controllers\Auth;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle OAuth callback and user creation/login
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check for existing user with Google ID
            $existingUser = User::where('google_id', $googleUser->id)->first();
            
            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('dashboard');
            }
            
            // Check for user with same email (account linking)
            $userWithEmail = User::where('email', $googleUser->email)->first();
            
            if ($userWithEmail) {
                $userWithEmail->update(['google_id' => $googleUser->id]);
                Auth::login($userWithEmail);
                return redirect()->route('dashboard');
            }
            
            // Create new user
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make('password'), // Default password
                'email_verified_at' => now(),
            ]);
            
            $newUser->assignRole('User'); // Auto-assign User role
            Auth::login($newUser);
            
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'OAuth failed');
        }
    }
}
```

**Code Explanation:**
1. **redirectToGoogle()**: Initiates OAuth flow by redirecting to Google
2. **handleGoogleCallback()**: Processes OAuth response with three scenarios:
   - Existing Google user: Direct login
   - Email match: Link Google account to existing user
   - New user: Create account with auto-role assignment
3. **Error Handling**: Graceful fallback to login page on OAuth failure

#### OAuth Routes

```php
// Google OAuth Routes (routes/web.php)
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])
    ->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');
```

### 3. User Model Configuration

#### Enhanced User Model

```php
<?php
namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'google_id',
        'phone', 'location', 'bio', 'reading_interests',
        'unique_id', 'is_active', 'last_active_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'reading_interests' => 'array', // JSON field for user preferences
        'last_active_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Unique ID generation for user identification
    protected function generateUniqueId()
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $uniqueId = '';
        
        for ($i = 0; $i < 10; $i++) {
            $uniqueId .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Prevent duplicates
        if (self::where('unique_id', $uniqueId)->exists()) {
            return $this->generateUniqueId();
        }
        
        return $uniqueId;
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            $user->unique_id = $user->generateUniqueId();
        });
    }
}
```

**Code Explanation:**
- **HasRoles Trait**: Enables Spatie permission functionality
- **Enhanced Fillable**: Additional fields for user profiles and OAuth
- **Casts**: Automatic type conversion for JSON and datetime fields
- **Unique ID Generation**: Custom 10-character identifier for each user
- **Boot Method**: Automatically generates unique ID on user creation

---

## Authorization System

### 1. Role-Based Access Control (RBAC)

#### Role Hierarchy

```php
// Three-tier role system
1. Super Admin - Complete system access
2. Admin - Administrative functions, book moderation 
3. User - Standard user permissions
```

#### Role Configuration (database/seeders/RoleSeeder.php)

```php
<?php
namespace Database\Seeders;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin - Inherits all permissions via Gate
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        
        // Admin - Specific permissions for management tasks
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions([
            'create-user', 'edit-user', 'delete-user', 'show-user',
            'create-book-category', 'edit-book-category', 'delete-book-category',
            'approve-book', 'reject-book', 'view-book-requests',
            'manage-books', 'view-pending-books', 'view-all-books',
        ]);
        
        // User - Basic permissions for platform usage
        $user = Role::firstOrCreate(['name' => 'User']);
        $user->syncPermissions([
            'show-book-category', 'show-book',
            'borrow-book', 'return-book',
        ]);
    }
}
```

**Code Explanation:**
- **Role::firstOrCreate()**: Creates role if it doesn't exist
- **syncPermissions()**: Assigns specific permissions to roles
- **Hierarchical Design**: Each role has appropriate permission levels

### 2. Permission System

#### Permission Categories (database/seeders/PermissionSeeder.php)

```php
<?php
namespace Database\Seeders;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            'create-user', 'edit-user', 'delete-user', 'show-user', 'destroy-user',
            
            // Role & Permission Management
            'create-role', 'edit-role', 'delete-role',
            'create-permission', 'edit-permission', 'delete-permission',
            
            // Book Category Permissions
            'create-book-category', 'edit-book-category', 'delete-book-category', 'show-book-category',
            
            // Book Management
            'create-book', 'edit-book', 'delete-book', 'show-book',
            'borrow-book', 'return-book', 'manage-books',
            'approve-book', 'reject-book', 'view-book-requests',
            'view-pending-books', 'view-all-books',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
```

**Code Explanation:**
- **Granular Permissions**: Each action has specific permission
- **Categorized Structure**: Logical grouping for management
- **Extensible Design**: Easy to add new permissions

### 3. Middleware Implementation

#### Custom Permission Middleware

```php
<?php
namespace App\Http\Middleware;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission = null, $guard = null)
    {
        $authGuard = app('auth')->guard($guard);
        
        // Check if user is authenticated
        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        
        // Dynamic permission resolution from route name
        if (is_null($permission)) {
            $permission = $this->routeName($request->route()->getName());
            $permissions = array($permission);
        } else {
            $permissions = is_array($permission) ? $permission : explode('|', $permission);
        }
        
        // Check user permissions
        foreach ($permissions as $permission) {
            if ($authGuard->user()->can($permission)) {
                return $next($request);
            }
        }
        
        throw UnauthorizedException::forPermissions($permissions);
    }
    
    /**
     * Convert route name to permission name
     * Example: users.index -> index-user
     */
    private function routeName($string)
    {
        if (Str::contains($string, '.')) {
            $arr = explode('.', $string);
            $route = $arr[1] . '-' . str_split($arr[0], strlen($arr[0]) - 1)[0];
            return $route;
        }
        return $string;
    }
}
```

**Code Explanation:**
- **Dynamic Permission Resolution**: Converts route names to permission names
- **Flexible Permission Checking**: Supports multiple permission formats
- **Exception Handling**: Throws appropriate unauthorized exceptions

#### Middleware Registration (app/Http/Kernel.php)

```php
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    'permission' => \App\Http\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
];
```

### 4. Gate-Based Authorization

#### Super Admin Gate (app/Providers/AuthServiceProvider.php)

```php
<?php
namespace App\Providers;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Super Admin bypass - grants all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
```

**Code Explanation:**
- **Gate::before()**: Executes before any authorization check
- **Super Admin Bypass**: Automatically grants all permissions to Super Admin
- **Return null**: Allows normal permission checking for other roles

### 5. Route Protection

#### Protected Route Groups

```php
// All authenticated routes
Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => ['auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Book management routes
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    
    // Admin-only routes
    Route::group(['middleware' => 'role:Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/books/{book}/approve', [AdminController::class, 'approveBook'])->name('books.approve');
    });
    
    // Resource routes with automatic permission checking
    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
    ]);
});
```

**Code Explanation:**
- **Nested Middleware Groups**: Layered protection (auth → role → permission)
- **Route Prefixes**: Organized admin routes with prefix
- **Resource Routes**: Automatic CRUD route generation with permission checking

#### Controller-Level Protection | কন্ট্রোলার-স্তরের সুরক্ষা

```php
<?php
namespace App\Http\Controllers\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Must be authenticated | অবশ্যই প্রমাণিত হতে হবে
        $this->middleware('role:Admin|Super Admin'); // Admin or Super Admin role | অ্যাডমিন বা সুপার অ্যাডমিন ভূমিকা
        $this->middleware('permission:view-book-requests')->only(['bookRequests']);
        $this->middleware('permission:approve-book')->only(['approveBook']);
        $this->middleware('permission:reject-book')->only(['rejectBook']);
    }
    
    public function approveBook(Book $book)
    {
        // Additional permission check if needed | প্রয়োজনে অতিরিক্ত অনুমতি পরীক্ষা
        $this->authorize('approve-book');
        
        $book->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Book approved successfully | বই সফলভাবে অনুমোদিত হয়েছে');
    }
}
```

**Code Explanation | কোড ব্যাখ্যা:**
- **Constructor Middleware | কনস্ট্রাক্টর মিডলওয়্যার**: Applied to all controller methods | সব কন্ট্রোলার মেথডে প্রয়োগ করা হয়
- **Method-Specific Middleware | মেথড-নির্দিষ্ট মিডলওয়্যার**: Applied only to specific methods | শুধুমাত্র নির্দিষ্ট মেথডে প্রয়োগ করা হয়
- **authorize() Helper**: Additional inline permission checking | অতিরিক্ত ইনলাইন অনুমতি পরীক্ষা

---

## Database Schema | ডাটাবেস স্কিমা

### 1. Core Tables | মূল টেবিল

#### Users Table Migration | ব্যবহারকারী টেবিল মাইগ্রেশন

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->string('google_id')->nullable(); // OAuth integration | OAuth একীকরণ
    $table->string('phone')->nullable();
    $table->text('location')->nullable();
    $table->text('bio')->nullable();
    $table->json('reading_interests')->nullable(); // User preferences | ব্যবহারকারীর পছন্দ
    $table->string('unique_id', 10)->unique(); // Custom identifier | কাস্টম শনাক্তকারী
    $table->string('image')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamp('last_active_at')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
```

### 2. Spatie Permission Tables | Spatie অনুমতি টেবিল

#### Permission System Tables (auto-generated by Spatie package) | অনুমতি সিস্টেম টেবিল (Spatie প্যাকেজ দ্বারা স্বয়ংক্রিয়ভাবে উৎপন্ন)

```php
// permissions table | অনুমতি টেবিল
Schema::create('permissions', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name');
    $table->string('guard_name');
    $table->timestamps();
    $table->unique(['name', 'guard_name']);
});

// roles table | ভূমিকা টেবিল
Schema::create('roles', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('name');
    $table->string('guard_name');
    $table->timestamps();
    $table->unique(['name', 'guard_name']);
});

// model_has_permissions (user-permission direct assignments)
// model_has_permissions (ব্যবহারকারী-অনুমতি সরাসরি নির্ধারণ)
Schema::create('model_has_permissions', function (Blueprint $table) {
    $table->unsignedBigInteger('permission_id');
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    // Foreign key constraints and indexes | ফরেন কী সীমাবদ্ধতা এবং ইনডেক্স
});

// model_has_roles (user-role assignments)
// model_has_roles (ব্যবহারকারী-ভূমিকা নির্ধারণ)
Schema::create('model_has_roles', function (Blueprint $table) {
    $table->unsignedBigInteger('role_id');
    $table->string('model_type');
    $table->unsignedBigInteger('model_id');
    // Foreign key constraints and indexes | ফরেন কী সীমাবদ্ধতা এবং ইনডেক্স
});

// role_has_permissions (role-permission assignments)
// role_has_permissions (ভূমিকা-অনুমতি নির্ধারণ)
Schema::create('role_has_permissions', function (Blueprint $table) {
    $table->unsignedBigInteger('permission_id');
    $table->unsignedBigInteger('role_id');
    // Foreign key constraints and primary key | ফরেন কী সীমাবদ্ধতা এবং প্রাথমিক কী
});
```

**Database Relationships | ডাটাবেস সম্পর্ক:**
- **Users ↔ Roles | ব্যবহারকারী ↔ ভূমিকা**: Many-to-Many via `model_has_roles` | `model_has_roles` এর মাধ্যমে বহু-থেকে-বহু
- **Users ↔ Permissions | ব্যবহারকারী ↔ অনুমতি**: Many-to-Many via `model_has_permissions` | `model_has_permissions` এর মাধ্যমে বহু-থেকে-বহু
- **Roles ↔ Permissions | ভূমিকা ↔ অনুমতি**: Many-to-Many via `role_has_permissions` | `role_has_permissions` এর মাধ্যমে বহু-থেকে-বহু

### 3. Data Seeding | ডেটা সিডিং

#### Default Admin Accounts (database/seeders/SuperAdminSeeder.php) | ডিফল্ট অ্যাডমিন অ্যাকাউন্ট

```php
<?php
namespace Database\Seeders;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin | সুপার অ্যাডমিন তৈরি করুন
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('123456')
        ]);
        $superAdmin->assignRole('Super Admin');
        
        // Create Admin | অ্যাডমিন তৈরি করুন
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456')
        ]);
        $admin->assignRole('Admin');
    }
}
```

---

## Implementation Details | বাস্তবায়নের বিস্তারিত

### 1. User Management System | ব্যবহারকারী ব্যবস্থাপনা সিস্টেম

#### User Controller with DataTables | DataTables সহ ব্যবহারকারী কন্ট্রোলার

```php
<?php
namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="d-flex">';
                    
                    // Show button - permission check | শো বোতাম - অনুমতি পরীক্ষা
                    if (auth()->user()->can('show-user')) {
                        $btn .= '<a href="'.route("users.show", $row['id']).'" class="btn btn-warning btn-sm mr-2">Show | দেখান</a>';
                    }
                    
                    // Edit button - role and permission checks | সম্পাদনা বোতাম - ভূমিকা এবং অনুমতি পরীক্ষা
                    if (in_array('Super Admin', $row->getRoleNames()->toArray() ?? [])) {
                        // Only Super Admin can edit Super Admin | শুধুমাত্র সুপার অ্যাডমিন সুপার অ্যাডমিন সম্পাদনা করতে পারে
                        if (auth()->user()->hasRole('Super Admin')) {
                            $btn .= '<a href="'.route("users.edit", $row['id']).'" class="btn btn-primary btn-sm mr-2">Edit | সম্পাদনা</a>';
                        }
                    } else {
                        // Regular permission check for non-Super Admin users
                        // নন-সুপার অ্যাডমিন ব্যবহারকারীদের জন্য নিয়মিত অনুমতি পরীক্ষা
                        if (auth()->user()->can('edit-user')) {
                            $btn .= '<a href="'.route("users.edit", $row['id']).'" class="btn btn-primary btn-sm mr-2">Edit | সম্পাদনা</a>';
                        }
                    }
                    
                    // Delete button - prevent self-deletion | মুছে ফেলা বোতাম - স্ব-মুছে ফেলা প্রতিরোধ
                    if (auth()->user()->can('destroy-user') && auth()->user()->id != $row['id']) {
                        $btn .= '<form action="'.route("users.destroy", $row['id']).'" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm mr-2" onclick="return confirm(\'Delete this user? | এই ব্যবহারকারী মুছে ফেলুন?\');">Delete | মুছুন</button>
                        </form>';
                    }
                    
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return view('users.index');
    }
}
```

**Code Explanation | কোড ব্যাখ্যা:**
- **DataTables Integration | DataTables একীকরণ**: AJAX-powered user listing | AJAX-চালিত ব্যবহারকারী তালিকা
- **Permission-Based Actions | অনুমতি-ভিত্তিক ক্রিয়া**: Buttons appear based on user permissions | ব্যবহারকারীর অনুমতির ভিত্তিতে বোতাম প্রদর্শিত হয়
- **Super Admin Protection | সুপার অ্যাডমিন সুরক্ষা**: Special handling for Super Admin users | সুপার অ্যাডমিন ব্যবহারকারীদের জন্য বিশেষ পরিচালনা
- **Self-Protection | স্ব-সুরক্ষা**: Users cannot delete themselves | ব্যবহারকারীরা নিজেদের মুছে ফেলতে পারে না

### 2. Role Management System | ভূমিকা ব্যবস্থাপনা সিস্টেম

#### Role Controller with Protection | সুরক্ষা সহ ভূমিকা কন্ট্রোলার

```php
<?php
namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function edit(Role $role): View
    {
        // Protect Super Admin role from editing | সুপার অ্যাডমিন ভূমিকাকে সম্পাদনা থেকে রক্ষা করুন
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED | সুপার অ্যাডমিন ভূমিকা সম্পাদনা করা যাবে না');
        }
        
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();
            
        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }
    
    public function destroy(Role $role): RedirectResponse
    {
        // Multiple protection layers | একাধিক সুরক্ষা স্তর
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED | সুপার অ্যাডমিন ভূমিকা মুছে ফেলা যাবে না');
        }
        
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE | স্ব-নির্ধারিত ভূমিকা মুছে ফেলা যাবে না');
        }
        
        $role->delete();
        return redirect()->route('roles.index')->withSuccess('Role deleted successfully. | ভূমিকা সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
```

**Code Explanation | কোড ব্যাখ্যা:**
- **Super Admin Protection | সুপার অ্যাডমিন সুরক্ষা**: Prevents editing/deletion of Super Admin role | সুপার অ্যাডমিন ভূমিকার সম্পাদনা/মুছে ফেলা প্রতিরোধ করে
- **Self-Protection | স্ব-সুরক্ষা**: Users cannot delete their own assigned role | ব্যবহারকারীরা তাদের নিজস্ব নির্ধারিত ভূমিকা মুছে ফেলতে পারে না
- **Permission Retrieval | অনুমতি পুনরুদ্ধার**: Gets current role permissions for editing | সম্পাদনার জন্য বর্তমান ভূমিকার অনুমতি পায়

---

## Security Features | নিরাপত্তা বৈশিষ্ট্য

### 1. Authentication Security | প্রমাণীকরণ নিরাপত্তা

#### CSRF Protection | CSRF সুরক্ষা
```php
// All forms include CSRF tokens | সব ফর্মে CSRF টোকেন অন্তর্ভুক্ত
<form method="POST" action="{{ route('login') }}">
    @csrf
    <!-- form fields | ফর্ম ক্ষেত্র -->
</form>
```

#### Password Security | পাসওয়ার্ড নিরাপত্তা
```php
// Automatic password hashing in User model | ব্যবহারকারী মডেলে স্বয়ংক্রিয় পাসওয়ার্ড হ্যাশিং
protected $casts = [
    'password' => 'hashed',
];

// OAuth users get secure default password | OAuth ব্যবহারকারীরা নিরাপদ ডিফল্ট পাসওয়ার্ড পায়
'password' => Hash::make('password'),
```

#### Session Management | সেশন ব্যবস্থাপনা
```php
// Middleware stack includes session handling | মিডলওয়্যার স্ট্যাকে সেশন হ্যান্ডলিং অন্তর্ভুক্ত
'web' => [
    \Illuminate\Session\Middleware\StartSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    // ... other middleware | ... অন্যান্য মিডলওয়্যার
],
```

### 2. Authorization Security

#### Multiple Protection Layers
```php
// Route level
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Controller level
    public function __construct() {
        $this->middleware('permission:approve-book');
    }
    
    // Method level
    public function approveBook() {
        $this->authorize('approve-book');
        // ... method logic
    }
});
```

#### Input Validation
```php
// Form request validation
class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
        ];
    }
}
```

### 3. Data Protection

#### Mass Assignment Protection
```php
// Only specified fields can be mass assigned
protected $fillable = [
    'name', 'email', 'password', 'google_id',
    // ... other safe fields
];

// Sensitive fields are hidden from JSON
protected $hidden = [
    'password', 'remember_token',
];
```

---

## Usage Examples

### 1. Frontend Permission Checking

#### Blade Directives
```php
{{-- Permission-based content --}}
@can('create-book')
    <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
@endcan

{{-- Role-based content --}}
@role('Admin')
    <div class="admin-panel">
        <!-- Admin-only content -->
    </div>
@endrole

{{-- Multiple permission check --}}
@canany(['edit-user', 'delete-user'])
    <div class="user-actions">
        <!-- User management actions -->
    </div>
@endcanany

{{-- Inverse permission check --}}
@cannot('approve-book')
    <p>You don't have permission to approve books.</p>
@endcannot
```

#### Dynamic Navigation
```php
{{-- Sidebar navigation with permission checks --}}
@canany(['index-user', 'index-role', 'index-permission'])
    <li class="menu-header">System Management</li>
    <li class="dropdown">
        <a href="#" class="nav-link has-dropdown">
            <i class="fas fa-users-cog"></i> <span>User Management</span>
        </a>
        <ul class="dropdown-menu">
            @can('index-user')
                <li><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
            @endcan
            @can('index-role')
                <li><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
            @endcan
            @can('index-permission')
                <li><a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a></li>
            @endcan
        </ul>
    </li>
@endcanany
```

### 2. Backend Authorization

#### Controller Authorization
```php
<?php
namespace App\Http\Controllers;

class BookController extends Controller
{
    public function store(Request $request)
    {
        // Check permission before processing
        $this->authorize('create-book');
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            // ... other validation rules
        ]);
        
        $book = auth()->user()->books()->create($validatedData);
        
        return redirect()->route('books.show', $book)
            ->with('success', 'Book created successfully');
    }
    
    public function destroy(Book $book)
    {
        // Check if user can delete books AND owns this book
        $this->authorize('delete-book');
        
        if ($book->user_id !== auth()->id() && !auth()->user()->hasRole(['Admin', 'Super Admin'])) {
            abort(403, 'You can only delete your own books');
        }
        
        $book->delete();
        
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
```

### 3. API Authorization (if applicable)

#### API Route Protection
```php
// API routes with Sanctum authentication
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::middleware(['permission:create-book'])->post('/books', [BookController::class, 'store']);
    Route::middleware(['permission:approve-book'])->patch('/books/{book}/approve', [BookController::class, 'approve']);
});
```

### 4. Custom Permission Checks

#### Service Layer Authorization
```php
<?php
namespace App\Services;

class BookService
{
    public function approveBook(Book $book, User $user)
    {
        // Service-level permission check
        if (!$user->can('approve-book')) {
            throw new UnauthorizedException('You cannot approve books');
        }
        
        // Additional business logic checks
        if ($book->is_approved) {
            throw new InvalidStateException('Book is already approved');
        }
        
        $book->update([
            'is_approved' => true,
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);
        
        return $book;
    }
}
```

---

## Troubleshooting

### Common Issues and Solutions

#### 1. Permission Not Working

**Problem**: User has permission but still gets unauthorized error.

**Solution**:
```php
// Clear permission cache
php artisan permission:cache-reset

// Or in code
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

#### 2. Role Assignment Issues

**Problem**: Role assignment not working after user creation.

**Solution**:
```php
// Ensure role exists before assignment
$role = Role::firstOrCreate(['name' => 'User']);
$user->assignRole($role);

// Or assign by name
$user->assignRole('User');
```

#### 3. Middleware Order Issues

**Problem**: Permission middleware running before authentication.

**Solution**:
```php
// Ensure correct middleware order in Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ... other middleware
        \Illuminate\Session\Middleware\StartSession::class,
        \App\Http\Middleware\Authenticate::class, // Auth first
        // Then permission middleware
    ],
];
```

#### 4. Super Admin Not Getting All Permissions

**Problem**: Super Admin getting permission denied errors.

**Solution**:
```php
// Ensure Gate::before is properly configured in AuthServiceProvider
Gate::before(function ($user, $ability) {
    return $user->hasRole('Super Admin') ? true : null;
});

// Register in boot method
public function boot()
{
    $this->registerPolicies();
    
    Gate::before(function ($user, $ability) {
        return $user->hasRole('Super Admin') ? true : null;
    });
}
```

#### 5. OAuth Configuration Issues

**Problem**: Google OAuth not working.

**Solution**:
```php
// Check .env configuration
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URL="${APP_URL}/auth/google/callback"

// Ensure config/services.php is correct
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

### Performance Optimization

#### 1. Permission Caching
```php
// Enable permission caching in config/permission.php
'cache' => [
    'expiration_time' => \DateInterval::createFromDateString('24 hours'),
    'key' => 'spatie.permission.cache',
    'store' => 'default',
],
```

#### 2. Eager Loading
```php
// Load roles and permissions with users
$users = User::with(['roles', 'permissions'])->get();

// In controllers
public function index()
{
    $users = User::with('roles')->paginate(10);
    return view('users.index', compact('users'));
}
```

#### 3. Database Indexing
```php
// Add indexes for better performance
Schema::table('users', function (Blueprint $table) {
    $table->index('google_id');
    $table->index('is_active');
    $table->index('last_active_at');
});
```

---

## Conclusion

This Authentication and Authorization module provides a robust, scalable, and secure foundation for the Community Book Lending & Swapping Platform. The implementation combines Laravel's built-in authentication with Spatie's permission system to create a flexible, multi-layered security system that can easily be extended as the application grows.

### Key Benefits | মূল সুবিধা:
- **Security | নিরাপত্তা**: Multiple layers of protection | সুরক্ষার একাধিক স্তর
- **Flexibility | নমনীয়তা**: Easy to add new roles and permissions | নতুন ভূমিকা এবং অনুমতি যোগ করা সহজ
- **Scalability | মাপযোগ্যতা**: Can handle growing user base and features | ক্রমবর্ধমান ব্যবহারকারী ভিত্তি এবং বৈশিষ্ট্য পরিচালনা করতে পারে
- **Maintainability | রক্ষণাবেক্ষণযোগ্যতা**: Well-organized, documented code | সুসংগঠিত, নথিভুক্ত কোড
- **User Experience | ব্যবহারকারীর অভিজ্ঞতা**: Seamless authentication with social login options | সামাজিক লগইন বিকল্প সহ নিরবচ্ছিন্ন প্রমাণীকরণ

### Future Enhancements | ভবিষ্যৎ উন্নতি:
- Two-factor authentication (2FA) | দ্বি-ফ্যাক্টর প্রমাণীকরণ (2FA)
- Social login with additional providers | অতিরিক্ত প্রদানকারীর সাথে সামাজিক লগইন
- Advanced permission policies | উন্নত অনুমতি নীতি
- Audit logging for security events | নিরাপত্তা ইভেন্টের জন্য অডিট লগিং
- API token management for mobile apps | মোবাইল অ্যাপের জন্য API টোকেন ব্যবস্থাপনা
