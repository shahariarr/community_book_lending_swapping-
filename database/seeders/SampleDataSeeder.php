<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\BookCategory;
use App\Models\User;
use App\Models\Book;
use App\Models\Review;
use Spatie\Permission\Models\Role;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Create book categories
        $categories = [
            ['name' => 'Fiction', 'description' => 'Fictional literature and novels', 'is_active' => true],
            ['name' => 'Science', 'description' => 'Science and technology books', 'is_active' => true],
            ['name' => 'Romance', 'description' => 'Romance and love stories', 'is_active' => true],
            ['name' => 'Self-Help', 'description' => 'Personal development and self-improvement', 'is_active' => true],
            ['name' => 'Mystery', 'description' => 'Mystery and thriller books', 'is_active' => true],
            ['name' => 'Biography', 'description' => 'Biographies and memoirs', 'is_active' => true],
            ['name' => 'History', 'description' => 'Historical books and events', 'is_active' => true],
            ['name' => 'Fantasy', 'description' => 'Fantasy and magical stories', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            BookCategory::firstOrCreate(['name' => $category['name']], $category);
        }

        // Create sample users if they don't exist
        $users = [
            [
                'name' => 'Sarah Martinez',
                'email' => 'sarah@example.com',
                'password' => bcrypt('password'),
                'location' => 'Downtown Seattle',
                'phone' => '123-456-7890',
                'bio' => 'Avid reader and book lover. Always looking for new recommendations!',
                'reading_interests' => ['fiction', 'romance', 'mystery'],
                'is_active' => true,
            ],
            [
                'name' => 'Mike Rodriguez',
                'email' => 'mike@example.com',
                'password' => bcrypt('password'),
                'location' => 'Midtown',
                'phone' => '123-456-7891',
                'bio' => 'Science and self-help enthusiast.',
                'reading_interests' => ['science', 'self-help', 'biography'],
                'is_active' => true,
            ],
            [
                'name' => 'Emma Chen',
                'email' => 'emma@example.com',
                'password' => bcrypt('password'),
                'location' => 'Uptown',
                'phone' => '123-456-7892',
                'bio' => 'Fantasy and fiction reader.',
                'reading_interests' => ['fantasy', 'fiction', 'history'],
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(['email' => $userData['email']], $userData);
            // Assign user role if it exists
            if (Role::where('name', 'User')->exists()) {
                $user->assignRole('User');
            }
        }

        // Create sample books
        $books = [
            [
                'title' => 'The Seven Husbands of Evelyn Hugo',
                'author' => 'Taylor Jenkins Reid',
                'description' => 'A captivating novel about a reclusive Hollywood icon who finally decides to tell her story.',
                'category' => 'Romance',
                'user_email' => 'sarah@example.com',
                'condition' => 'like_new',
                'availability_type' => 'both',
                'language' => 'en',
                'page_count' => 400,
                'published_date' => '2017-06-13',
                'image' => 'book_images/seven_husbands_evelyn_hugo.jpg',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'An Easy & Proven Way to Build Good Habits & Break Bad Ones.',
                'category' => 'Self-Help',
                'user_email' => 'mike@example.com',
                'condition' => 'good',
                'availability_type' => 'loan',
                'language' => 'en',
                'page_count' => 320,
                'published_date' => '2018-10-16',
                'image' => 'book_images/atomic_habits.jpg',
            ],
            [
                'title' => 'The Midnight Library',
                'author' => 'Matt Haig',
                'description' => 'Between life and death there is a library, and within that library, the shelves go on forever.',
                'category' => 'Fiction',
                'user_email' => 'emma@example.com',
                'condition' => 'good',
                'availability_type' => 'swap',
                'language' => 'en',
                'page_count' => 288,
                'published_date' => '2020-08-13',
                'image' => 'book_images/midnight_library.jpg',
            ],
            [
                'title' => 'Educated',
                'author' => 'Tara Westover',
                'description' => 'A memoir about a woman who grows up in a survivalist family.',
                'category' => 'Biography',
                'user_email' => 'sarah@example.com',
                'condition' => 'like_new',
                'availability_type' => 'both',
                'language' => 'en',
                'page_count' => 334,
                'published_date' => '2018-02-20',
                'image' => 'book_images/educated.jpg',
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'description' => 'A magical story about following your dreams.',
                'category' => 'Fiction',
                'user_email' => 'mike@example.com',
                'condition' => 'good',
                'availability_type' => 'loan',
                'language' => 'en',
                'page_count' => 163,
                'published_date' => '1988-01-01',
                'image' => 'book_images/alchemist.jpg',
            ],
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'description' => 'A science fiction masterpiece set in the distant future.',
                'category' => 'Science',
                'user_email' => 'emma@example.com',
                'condition' => 'fair',
                'availability_type' => 'swap',
                'language' => 'en',
                'page_count' => 688,
                'published_date' => '1965-08-01',
                'image' => 'book_images/dune.jpg',
            ],
        ];

        foreach ($books as $bookData) {
            $category = BookCategory::where('name', $bookData['category'])->first();
            $user = User::where('email', $bookData['user_email'])->first();

            if ($category && $user) {
                $book = Book::firstOrCreate([
                    'title' => $bookData['title'],
                    'author' => $bookData['author'],
                    'user_id' => $user->id,
                ], [
                    'description' => $bookData['description'],
                    'category_id' => $category->id,
                    'condition' => $bookData['condition'],
                    'availability_type' => $bookData['availability_type'],
                    'language' => $bookData['language'],
                    'page_count' => $bookData['page_count'],
                    'published_date' => $bookData['published_date'],
                    'image' => $bookData['image'],
                    'is_approved' => true,
                    'approved_at' => now(),
                    'status' => 'available',
                ]);

                // Add some sample reviews
                if ($book->wasRecentlyCreated) {
                    $reviewers = User::where('id', '!=', $user->id)->take(2)->get();
                    foreach ($reviewers as $reviewer) {
                        Review::create([
                            'book_id' => $book->id,
                            'user_id' => $reviewer->id,
                            'rating' => rand(4, 5),
                            'comment' => 'Great book! Really enjoyed reading it.',
                            'is_approved' => true,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Sample data created successfully!');
    }
}
