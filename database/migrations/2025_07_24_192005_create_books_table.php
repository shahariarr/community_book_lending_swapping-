<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('book_categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('condition', ['new', 'like_new', 'good', 'fair', 'poor'])->default('good');
            $table->enum('availability_type', ['loan', 'swap', 'both'])->default('both');
            $table->enum('status', ['available', 'loaned', 'swapped', 'unavailable'])->default('available');
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('review_count')->default(0);
            $table->date('published_date')->nullable();
            $table->string('language')->default('en');
            $table->integer('page_count')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
