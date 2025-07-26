# 📚 Community Book Lending & Swapping Platform

A comprehensive Laravel-based platform that enables users to lend, borrow, and swap books within their community. Built with modern web technologies and featuring role-based access control, social authentication, and comprehensive book management.

## ✨ Features

### 🔐 Authentication & User Management
- **Multi-Authentication System** with traditional email/password login
- **Google OAuth Integration** with Laravel Socialite
- **Role-Based Access Control** using Spatie Laravel Permission
- **User Profiles** with reading interests and activity tracking
- **Admin Dashboard** with comprehensive user management

### 📖 Book Management
- **Complete Book CRUD Operations** with detailed book information
- **Book Categories** with organized classification system
- **Image Upload** support for book covers
- **Book Approval System** with admin moderation
- **Advanced Search & Filtering** capabilities
- **My Books** section for personal library management

### 🤝 Lending System
- **Loan Requests** with customizable duration (1-4 weeks)
- **Request Management** with approve/reject functionality
- **Status Tracking** (pending, approved, active, returned)
- **Automated Book Status Updates** during loan lifecycle
- **Return Management** system

### 🔄 Book Swapping
- **Swap Request System** for book exchanges
- **Book-to-Book Trading** with mutual agreement
- **Swap History** and transaction tracking
- **Automated Ownership Transfer** upon swap completion

### 📊 Analytics & Reporting
- **User Dashboard** with personalized statistics
- **Admin Analytics** with comprehensive insights
- **Activity Tracking** and user engagement metrics
- **Monthly Trends** and growth analytics
- **Category-wise Book Distribution**

### 🎨 User Interface
- **Responsive Design** with Bootstrap integration
- **Modern UI/UX** with intuitive navigation
- **DataTables Integration** for advanced data management
- **Real-time Notifications** for requests and updates
- **Mobile-Friendly** interface

## 🛠️ Technology Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Blade Templates, Bootstrap 5, Vite
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum, Laravel Socialite
- **Permissions**: Spatie Laravel Permission
- **File Storage**: Local/Cloud storage support
- **Development Tools**: Laravel Telescope for debugging

## 📂 Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/AdminController.php          # Admin dashboard and management
│   ├── Auth/SocialAuthController.php      # Google OAuth handling
│   ├── BookController.php                 # Book CRUD operations
│   ├── LoanRequestController.php          # Loan request management
│   ├── SwapRequestController.php          # Book swap functionality
│   └── HomeController.php                 # Dashboard and analytics
├── Models/
│   ├── User.php                          # User model with relationships
│   ├── Book.php                          # Book model with scopes
│   ├── BookCategory.php                  # Book categories
│   ├── LoanRequest.php                   # Loan request model
│   ├── SwapRequest.php                   # Swap request model
│   └── Review.php                        # Book reviews system
└── Policies/                            # Authorization policies

database/migrations/
├── 2024_02_19_094730_create_permission_tables.php
├── 2025_07_23_104532_add_google_id_to_users_table.php
├── 2025_07_23_123338_create_book_categories_table.php
├── 2025_07_24_192005_create_books_table.php
├── 2025_07_24_192021_create_loan_requests_table.php
├── 2025_07_24_192028_create_swap_requests_table.php
└── 2025_07_24_192036_create_reviews_table.php

resources/views/
├── auth/                                # Authentication views
├── books/                               # Book management views
├── loan-requests/                       # Loan request views
├── swap-requests/                       # Swap request views
├── admin/                               # Admin panel views
└── inc/                                 # Shared components
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL/PostgreSQL database

### Step 1: Clone the Repository
```bash
git clone https://github.com/shahariarr/Community_Book_Lending_Swapping.git
cd Community_Book_Lending_Swapping
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup
Update your `.env` file with database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=community_book_lending
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Google OAuth Setup (Optional)
Add Google OAuth credentials to `.env`:
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

### Step 6: Run Migrations and Seeders
```bash
# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed
```

### Step 7: Build Frontend Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### Step 8: Storage Setup
```bash
# Create storage symlink for file uploads
php artisan storage:link
```

### Step 9: Set Permissions (if needed)
```bash
# Create permission routes
php artisan permission:create-permission-routes
```

### Step 10: Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 🔐 Default Access Credentials

### Admin Account
- **Email**: `admin@admin.com`
- **Password**: `password`
- **Role**: Administrator with full system access

### Test User Account
- **Email**: `user@example.com`
- **Password**: `password`
- **Role**: Regular user with standard permissions

## 📊 Key Features Overview

### For Users
- Register and create profile with reading interests
- Add books to personal library with detailed information
- Search and browse available books by category
- Send loan requests with custom duration
- Propose book swaps with other users
- Track lending/borrowing history
- Manage incoming requests for owned books

### For Administrators
- **Book Moderation**: Approve/reject submitted books
- **User Management**: View user profiles and activity
- **System Analytics**: Monitor platform usage and trends
- **Request Oversight**: View all loan and swap requests
- **Category Management**: Organize book classifications
- **Content Moderation**: Ensure quality and appropriateness

## 🛣️ API Routes

### Authentication Routes
- `GET /` - Login page
- `POST /login` - User authentication
- `POST /register` - User registration
- `GET /auth/google` - Google OAuth redirect
- `GET /auth/google/callback` - Google OAuth callback

### Book Management Routes
- `GET /books` - Browse all books
- `GET /books/my-books` - User's personal library
- `GET /books/create` - Add new book form
- `POST /books` - Store new book
- `GET /books/{book}` - View book details
- `PUT /books/{book}` - Update book information
- `DELETE /books/{book}` - Remove book

### Loan Request Routes
- `GET /loan-requests` - View loan requests
- `POST /loan-requests` - Create loan request
- `POST /loan-requests/{id}/approve` - Approve loan request
- `POST /loan-requests/{id}/reject` - Reject loan request
- `POST /loan-requests/{id}/return` - Mark book as returned

### Swap Request Routes
- `GET /swap-requests` - View swap requests
- `POST /swap-requests` - Create swap request
- `POST /swap-requests/{id}/approve` - Approve swap request
- `POST /swap-requests/{id}/reject` - Reject swap request

### Admin Routes (Protected)
- `GET /admin/dashboard` - Admin dashboard with analytics
- `GET /admin/books` - Manage all books
- `GET /admin/books/pending` - Pending book approvals
- `GET /admin/users` - User management
- `PATCH /admin/books/{id}/approve` - Approve book

## 🔧 Configuration

### Cache Management
Access `/clear` route to clear all caches:
- Configuration cache
- View cache
- Route cache
- Application cache

### Permission System
The application uses Spatie Laravel Permission for role-based access control:
- **Super Admin**: Full system access
- **Admin**: Administrative functions
- **User**: Standard user permissions

## 🎯 Usage Examples

### Adding a Book
1. Navigate to "Add Book" section
2. Fill in book details (title, author, ISBN, description)
3. Select category and condition
4. Choose availability type (loan, swap, or both)
5. Upload book cover image
6. Submit for admin approval

### Requesting a Loan
1. Browse available books
2. Click on desired book
3. Select loan duration (1-4 weeks)
4. Add optional message
5. Submit request
6. Wait for owner approval

### Proposing a Book Swap
1. Find a book you want
2. Click "Request Swap"
3. Select a book from your library to offer
4. Add message explaining the swap
5. Submit proposal
6. Await owner's decision

## 🤝 Contributing

We welcome contributions! Please follow these guidelines:

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/amazing-feature`
3. **Commit changes**: `git commit -m 'Add amazing feature'`
4. **Push to branch**: `git push origin feature/amazing-feature`
5. **Open a Pull Request**

### Coding Standards
- Follow PSR-12 coding standards
- Write descriptive commit messages
- Include tests for new features
- Update documentation as needed

## 📝 License

This project is licensed under the [MIT License](LICENSE). Feel free to use, modify, and distribute as needed.

## 🐛 Troubleshooting

### Common Issues

**Permissions Error**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**Google OAuth Issues**
- Verify Google OAuth credentials in `.env`
- Ensure callback URL matches Google Console settings
- Check SSL certificate for production environments

**Database Connection Issues**
- Verify database credentials in `.env`
- Ensure database server is running
- Check firewall settings

## 📞 Support

For questions, issues, or feature requests:

- **GitHub Issues**: [Open an issue](https://github.com/shahariarr/Community_Book_Lending_Swapping/issues)
- **Email**: Contact the repository owner
- **Documentation**: Check the code comments and inline documentation

## 🏆 Acknowledgments

- Laravel framework and community
- Spatie for excellent Laravel packages
- Bootstrap for responsive UI components
- All contributors and users of this platform

---

**Built with ❤️ for book lovers and community sharing**
