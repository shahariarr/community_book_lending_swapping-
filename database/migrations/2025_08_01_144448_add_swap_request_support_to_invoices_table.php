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
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('swap_request_id')->nullable()->constrained()->onDelete('cascade')->after('loan_request_id');
            $table->enum('invoice_type', ['loan', 'swap'])->default('loan')->after('swap_request_id');
            $table->foreignId('offered_book_id')->nullable()->constrained('books')->onDelete('cascade')->after('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['swap_request_id']);
            $table->dropForeign(['offered_book_id']);
            $table->dropColumn(['swap_request_id', 'invoice_type', 'offered_book_id']);
        });
    }
};
