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
        Schema::table('swap_requests', function (Blueprint $table) {
            $table->integer('swap_duration_days')->default(30)->after('message');
            $table->date('swap_start_date')->nullable()->after('responded_at');
            $table->date('swap_end_date')->nullable()->after('swap_start_date');
            $table->date('actual_return_date')->nullable()->after('swap_end_date');
            $table->enum('swap_status', ['active', 'returned', 'overdue'])->default('active')->after('actual_return_date');
            $table->text('rejection_reason')->nullable()->after('swap_status');
            $table->timestamp('cancelled_at')->nullable()->after('rejection_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('swap_requests', function (Blueprint $table) {
            $table->dropColumn([
                'swap_duration_days',
                'swap_start_date',
                'swap_end_date',
                'actual_return_date',
                'swap_status',
                'rejection_reason',
                'cancelled_at'
            ]);
        });
    }
};
