<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookApprovalSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::role('Admin')->first();

        if (!$admin) {
            $this->command->error('No admin user found. Please run UserSeeder first.');
            return;
        }

        // Approve all existing books
        Book::where('is_approved', false)->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => $admin->id,
            'status' => 'available'
        ]);

        $this->command->info('All books have been approved.');

        // Create some additional test books if needed
        $users = User::role('User')->take(3)->get();
        $categories = BookCategory::take(3)->get();

        if ($users->isNotEmpty() && $categories->isNotEmpty()) {
            $testBooks = [
                [
                    'title' => 'Test Book for Swapping 1',
                    'author' => 'Test Author 1',
                    'description' => 'A test book available for swapping',
                    'condition' => 'good',
                    'availability_type' => 'swap',
                ],
                [
                    'title' => 'Test Book for Swapping 2',
                    'author' => 'Test Author 2',
                    'description' => 'Another test book available for swapping',
                    'condition' => 'like_new',
                    'availability_type' => 'both',
                ],
                [
                    'title' => 'Test Book for Swapping 3',
                    'author' => 'Test Author 3',
                    'description' => 'Yet another test book available for swapping',
                    'condition' => 'good',
                    'availability_type' => 'swap',
                ],
            ];

            foreach ($testBooks as $index => $bookData) {
                if (isset($users[$index]) && isset($categories[$index])) {
                    Book::create([
                        'title' => $bookData['title'],
                        'author' => $bookData['author'],
                        'description' => $bookData['description'],
                        'category_id' => $categories[$index]->id,
                        'user_id' => $users[$index]->id,
                        'condition' => $bookData['condition'],
                        'availability_type' => $bookData['availability_type'],
                        'status' => 'available',
                        'is_approved' => true,
                        'approved_at' => now(),
                        'approved_by' => $admin->id,
                    ]);
                }
            }

            $this->command->info('Created additional test books for swapping.');
        }
    }
}
