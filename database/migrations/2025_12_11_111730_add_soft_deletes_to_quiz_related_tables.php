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
        // Add soft deletes to quizzes table
        Schema::table('quizzes', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to quiz_assignments table
        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to quiz_attempts table
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to quiz_sessions table
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove soft deletes from quizzes table
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from quiz_assignments table
        Schema::table('quiz_assignments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from quiz_attempts table
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from quiz_sessions table
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
