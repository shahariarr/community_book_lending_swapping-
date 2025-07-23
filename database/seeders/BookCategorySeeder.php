<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiction',
                'slug' => 'fiction',
                'description' => 'Fictional stories, novels, and narratives',
                'color' => '#007bff',
                'icon' => 'fas fa-book',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Non-Fiction',
                'slug' => 'non-fiction',
                'description' => 'Factual books, biographies, and educational content',
                'color' => '#28a745',
                'icon' => 'fas fa-graduation-cap',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Science & Technology',
                'slug' => 'science-technology',
                'description' => 'Scientific research, technology, and innovation',
                'color' => '#17a2b8',
                'icon' => 'fas fa-flask',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'History',
                'slug' => 'history',
                'description' => 'Historical events, biographies, and documentation',
                'color' => '#6f42c1',
                'icon' => 'fas fa-landmark',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Romance',
                'slug' => 'romance',
                'description' => 'Romantic stories and love narratives',
                'color' => '#e83e8c',
                'icon' => 'fas fa-heart',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Mystery & Thriller',
                'slug' => 'mystery-thriller',
                'description' => 'Suspenseful stories and crime fiction',
                'color' => '#dc3545',
                'icon' => 'fas fa-search',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Fantasy',
                'slug' => 'fantasy',
                'description' => 'Fantasy worlds, magic, and mythical creatures',
                'color' => '#fd7e14',
                'icon' => 'fas fa-magic',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Biography',
                'slug' => 'biography',
                'description' => 'Life stories and autobiographies',
                'color' => '#20c997',
                'icon' => 'fas fa-user',
                'is_active' => true,
                'sort_order' => 8
            ],
            [
                'name' => 'Self-Help',
                'slug' => 'self-help',
                'description' => 'Personal development and improvement',
                'color' => '#ffc107',
                'icon' => 'fas fa-lightbulb',
                'is_active' => true,
                'sort_order' => 9
            ],
            [
                'name' => 'Children\'s Books',
                'slug' => 'childrens-books',
                'description' => 'Books designed for children and young readers',
                'color' => '#6610f2',
                'icon' => 'fas fa-child',
                'is_active' => true,
                'sort_order' => 10
            ],
            [
                'name' => 'Art & Design',
                'slug' => 'art-design',
                'description' => 'Visual arts, design, and creative inspiration',
                'color' => '#e91e63',
                'icon' => 'fas fa-palette',
                'is_active' => true,
                'sort_order' => 11
            ],
            [
                'name' => 'Health & Fitness',
                'slug' => 'health-fitness',
                'description' => 'Health, wellness, and fitness guides',
                'color' => '#4caf50',
                'icon' => 'fas fa-heartbeat',
                'is_active' => true,
                'sort_order' => 12
            ],
            [
                'name' => 'Business & Economics',
                'slug' => 'business-economics',
                'description' => 'Business strategies, economics, and entrepreneurship',
                'color' => '#795548',
                'icon' => 'fas fa-chart-line',
                'is_active' => true,
                'sort_order' => 13
            ],
            [
                'name' => 'Religion & Spirituality',
                'slug' => 'religion-spirituality',
                'description' => 'Religious texts and spiritual guidance',
                'color' => '#9c27b0',
                'icon' => 'fas fa-pray',
                'is_active' => true,
                'sort_order' => 14
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel guides and adventure stories',
                'color' => '#00bcd4',
                'icon' => 'fas fa-plane',
                'is_active' => true,
                'sort_order' => 15
            ]
        ];

        foreach ($categories as $category) {
            BookCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
