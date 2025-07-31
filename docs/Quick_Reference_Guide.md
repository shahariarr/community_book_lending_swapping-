# Authentication & Authorization Quick Reference Guide

## Quick Start Commands

### Setup Commands
```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan permission:cache-reset
```

### Default Login Credentials
```
Super Admin:
Email: super@admin.com
Password: 123456

Admin:
Email: admin@admin.com  
Password: 123456
```

---

## Code Snippets

### 1. Permission Checking

#### In Controllers
```php
// Method 1: Middleware
public function __construct()
{
    $this->middleware('permission:create-book');
}

// Method 2: Authorize method
public function store(Request $request)
{
    $this->authorize('create-book');
    // ... logic
}

// Method 3: Manual check
public function edit(Book $book)
{
    if (!auth()->user()->can('edit-book')) {
        abort(403);
    }
    // ... logic
}
```

#### In Blade Views
```blade
{{-- Single permission --}}
@can('create-book')
    <button>Create Book</button>
@endcan

{{-- Multiple permissions (any) --}}
@canany(['edit-book', 'delete-book'])
    <div class="actions">...</div>
@endcanany

{{-- Role check --}}
@role('Admin')
    <div class="admin-panel">...</div>
@endrole

{{-- Inverse check --}}
@cannot('delete-book')
    <p>You cannot delete books</p>
@endcannot
```

### 2. Role Management

#### Assign Roles
```php
// Single role
$user->assignRole('Admin');

// Multiple roles
$user->assignRole(['Admin', 'User']);

// Using role object
$role = Role::findByName('Admin');
$user->assignRole($role);
```

#### Check Roles
```php
// Single role
if ($user->hasRole('Admin')) { }

// Multiple roles (any)
if ($user->hasAnyRole(['Admin', 'Super Admin'])) { }

// Multiple roles (all)
if ($user->hasAllRoles(['Admin', 'User'])) { }

// Get all user roles
$roleNames = $user->getRoleNames(); // Collection
```

#### Remove Roles
```php
// Remove specific role
$user->removeRole('Admin');

// Remove all roles
$user->syncRoles([]);
```

### 3. Permission Management

#### Direct Permission Assignment
```php
// Assign permission to user
$user->givePermissionTo('create-book');

// Assign multiple permissions
$user->givePermissionTo(['create-book', 'edit-book']);

// Remove permission
$user->revokePermissionTo('create-book');

// Sync permissions
$user->syncPermissions(['create-book', 'edit-book']);
```

#### Role-Permission Management
```php
// Assign permission to role
$role = Role::findByName('Admin');
$role->givePermissionTo('approve-book');

// Sync role permissions
$role->syncPermissions(['create-book', 'edit-book', 'approve-book']);

// Get role permissions
$permissions = $role->permissions; // Collection
```

### 4. Custom Middleware Usage

#### Route-Level Middleware
```php
// Single permission
Route::get('/books/create', [BookController::class, 'create'])
    ->middleware('permission:create-book');

// Multiple permissions (any)
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('permission:admin-access|view-dashboard');

// Role middleware
Route::group(['middleware' => 'role:Admin'], function () {
    // Admin routes
});

// Combined middleware
Route::group(['middleware' => ['auth', 'role:Admin']], function () {
    // Protected admin routes
});
```

#### Controller Groups
```php
Route::group([
    'middleware' => ['auth', 'role:Admin'],
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'App\Http\Controllers\Admin'
], function () {
    Route::get('dashboard', 'AdminController@dashboard');
    Route::get('users', 'AdminController@users');
});
```

---

## Common Patterns

### 1. User Registration with Auto-Role Assignment
```php
public function register(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    
    // Auto-assign default role
    $user->assignRole('User');
    
    Auth::login($user);
    
    return redirect()->route('dashboard');
}
```

### 2. Dynamic Permission-Based Navigation
```php
// In a view composer or controller
$navigationItems = collect([
    [
        'title' => 'Users',
        'route' => 'users.index',
        'permission' => 'index-user',
        'icon' => 'fas fa-users'
    ],
    [
        'title' => 'Books',
        'route' => 'books.index',
        'permission' => 'index-book',
        'icon' => 'fas fa-book'
    ],
])->filter(function ($item) {
    return auth()->user()->can($item['permission']);
});
```

### 3. Resource Controller with Automatic Permissions
```php
class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-book')->only(['create', 'store']);
        $this->middleware('permission:edit-book')->only(['edit', 'update']);
        $this->middleware('permission:delete-book')->only(['destroy']);
        $this->middleware('permission:show-book')->only(['show']);
    }
}
```

### 4. Admin Panel with Book Approval
```php
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin|Super Admin']);
    }
    
    public function approveBook(Book $book)
    {
        $this->authorize('approve-book');
        
        $book->update(['is_approved' => true, 'approved_at' => now()]);
        
        return redirect()->back()->with('success', 'Book approved successfully');
    }
}
```

---

## Configuration Quick Reference

### Permission Configuration (config/permission.php)
```php
return [
    'models' => [
        'permission' => Spatie\Permission\Models\Permission::class,
        'role' => Spatie\Permission\Models\Role::class,
    ],
    
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permissions',
        'model_has_permissions' => 'model_has_permissions',
        'model_has_roles' => 'model_has_roles',
        'role_has_permissions' => 'role_has_permissions',
    ],
    
    'cache' => [
        'expiration_time' => \DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
```

### OAuth Configuration (config/services.php)
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

### Middleware Registration (app/Http/Kernel.php)
```php
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
    'permission' => \App\Http\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
];
```

---

## Troubleshooting

### Common Issues

#### 1. Permission Cache Issues
```bash
# Clear permission cache
php artisan permission:cache-reset

# Or programmatically
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
```

#### 2. Role Assignment Not Working
```php
// Make sure role exists
$role = Role::firstOrCreate(['name' => 'User']);
$user->assignRole($role);

// Check if user has role
if (!$user->hasRole('User')) {
    $user->assignRole('User');
}
```

#### 3. Middleware Not Working
```php
// Check middleware order in Kernel.php
protected $middlewareGroups = [
    'web' => [
        // Auth middleware should come before permission middleware
        \App\Http\Middleware\Authenticate::class,
        // ... other middleware
    ],
];
```

#### 4. OAuth Issues
```bash
# Check environment variables
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback

# Clear config cache
php artisan config:clear
```

### Debug Commands
```bash
# List all permissions
php artisan permission:show

# List all roles
php artisan tinker
>>> Role::with('permissions')->get()

# Check user permissions
php artisan tinker
>>> $user = User::find(1)
>>> $user->getAllPermissions()
>>> $user->getRoleNames()
```

---

## Testing Snippets

### Feature Tests
```php
public function test_admin_can_approve_books()
{
    $admin = User::factory()->create();
    $admin->assignRole('Admin');
    
    $book = Book::factory()->create(['is_approved' => false]);
    
    $this->actingAs($admin)
        ->patch(route('admin.books.approve', $book))
        ->assertRedirect()
        ->assertSessionHas('success');
        
    $this->assertTrue($book->fresh()->is_approved);
}

public function test_user_cannot_access_admin_panel()
{
    $user = User::factory()->create();
    $user->assignRole('User');
    
    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertStatus(403);
}
```

### Unit Tests
```php
public function test_user_can_be_assigned_role()
{
    $user = User::factory()->create();
    $role = Role::create(['name' => 'Test Role']);
    
    $user->assignRole($role);
    
    $this->assertTrue($user->hasRole('Test Role'));
}

public function test_super_admin_has_all_permissions()
{
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole('Super Admin');
    
    $this->assertTrue($superAdmin->can('any-permission'));
}
```

---

## Performance Tips

### 1. Eager Loading
```php
// Load roles and permissions with users
$users = User::with(['roles', 'permissions'])->get();

// For API responses
$user = User::with(['roles.permissions'])->find(1);
```

### 2. Permission Caching
```php
// Enable in config/permission.php
'cache' => [
    'expiration_time' => \DateInterval::createFromDateString('24 hours'),
    'key' => 'spatie.permission.cache',
    'store' => 'redis', // Use Redis for better performance
],
```

### 3. Database Indexing
```php
// Add indexes for better performance
Schema::table('users', function (Blueprint $table) {
    $table->index('google_id');
    $table->index('is_active');
});
```

---

## Security Checklist

- [ ] CSRF protection enabled on all forms
- [ ] Input validation on all user inputs
- [ ] Mass assignment protection configured
- [ ] Sensitive data hidden from JSON responses
- [ ] OAuth state verification enabled
- [ ] Super Admin role protected from deletion/modification
- [ ] Users cannot delete their own assigned roles
- [ ] Permission cache properly configured
- [ ] HTTPS enabled in production
- [ ] Rate limiting on authentication routes

---

## Useful Artisan Commands

```bash
# Permission Management
php artisan permission:create-role "Role Name"
php artisan permission:create-permission "permission-name"
php artisan permission:cache-reset

# User Management
php artisan make:seeder UserSeeder
php artisan make:request StoreUserRequest

# OAuth Setup
php artisan vendor:publish --provider="Laravel\Socialite\SocialiteServiceProvider"

# General
php artisan route:list --name=auth
php artisan route:list --middleware=permission
```
