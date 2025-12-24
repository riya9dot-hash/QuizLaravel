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
        Schema::create('quiz_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable(); // Assign entire category
            $table->unsignedBigInteger('quiz_id')->nullable(); // OR assign individual quiz
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('assigned_by'); // Admin who assigned
            $table->dateTime('due_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('category_id')->references('id')->on('quiz_categories')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');

            // Indexes for performance
            $table->index('user_id');
            $table->index('category_id');
            $table->index('quiz_id');
            $table->index('status');

            // Ensure either category_id or quiz_id is set (handled in application logic)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_assignments');
    }
};
