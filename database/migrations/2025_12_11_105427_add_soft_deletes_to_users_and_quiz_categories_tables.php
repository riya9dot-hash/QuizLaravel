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
        // Add soft deletes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to quiz_categories table
        Schema::table('quiz_categories', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove soft deletes from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from quiz_categories table
        Schema::table('quiz_categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
