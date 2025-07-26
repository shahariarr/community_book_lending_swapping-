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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->json('reading_interests')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_active_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'location', 'bio', 'reading_interests', 'is_active', 'last_active_at']);
        });
    }
};
