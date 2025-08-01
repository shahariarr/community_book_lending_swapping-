# Frontend Blade Templates

This directory contains the converted Blade templates from the static HTML files in `BookBub_frontend`.

## Structure

- `layouts/master.blade.php` - Main layout template with header, footer, and asset includes
- `partials/` - Reusable template components (navbar, footer, preloader, etc.)
- `home.blade.php` - Homepage template
- `browse-books.blade.php` - Book browsing/listing page
- `category.blade.php` - Book categories page
- `about.blade.php` - About us page
- `contact.blade.php` - Contact us page
- `blog.blade.php` - Blog listing page

## Features

- Responsive design maintained from original templates
- Laravel Blade templating with `@extends`, `@section`, `@include`
- Asset helper functions for proper URL generation
- Route helper functions for navigation
- Clean separation of layout, partials, and content

## Routes

The following frontend routes are available:

- `/` - Homepage (frontend.home)
- `/browse-books` - Browse books (frontend.browse-books)
- `/categories` - Book categories (frontend.category)
- `/about-us` - About page (frontend.about)
- `/contact-us` - Contact page (frontend.contact)
- `/blog` - Blog page (frontend.blog)

## Assets

Frontend assets are located in `public/frontend/assets/` and are properly linked using Laravel's `asset()` helper.

## Notes

- Templates are static (no dynamic data integration)
- Design unchanged from original HTML files
- No authentication or user functionality included
- Backend admin routes remain separate and unchanged
