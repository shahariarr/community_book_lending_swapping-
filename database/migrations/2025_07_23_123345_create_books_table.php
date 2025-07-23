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
            $table->string('isbn')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('English');
            $table->string('condition')->default('Good'); // New, Good, Fair, Poor
            $table->string('availability_status')->default('Available'); // Available, Borrowed, Reserved, Maintenance
            $table->string('cover_image')->nullable();
            $table->decimal('price', 8, 2)->nullable(); // For purchase/value reference
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            // Foreign keys
            $table->foreignId('book_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index(['title', 'author']);
            $table->index('availability_status');
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
