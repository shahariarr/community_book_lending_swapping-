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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->date('requested_start_date');
            $table->date('requested_end_date');
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->date('returned_date')->nullable();
            $table->text('lender_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->boolean('is_overdue')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};
