<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\User;
use Illuminate\Console\Command;

class ApproveAllBooks extends Command
{
    protected $signature = 'books:approve-all';
    protected $description = 'Approve all pending books (for development/testing)';

    public function handle()
    {
        $admin = User::role('Admin')->first();

        if (!$admin) {
            $this->error('No admin user found. Please create an admin user first.');
            return 1;
        }

        $pendingBooks = Book::where('is_approved', false)->get();

        if ($pendingBooks->isEmpty()) {
            $this->info('No books pending approval.');
            return 0;
        }

        $count = 0;
        foreach ($pendingBooks as $book) {
            $book->update([
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => $admin->id,
                'status' => 'available'
            ]);
            $count++;
        }

        $this->info("Successfully approved {$count} books.");
        return 0;
    }
}
