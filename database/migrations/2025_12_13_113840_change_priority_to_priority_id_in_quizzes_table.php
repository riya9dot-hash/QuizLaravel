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
        Schema::table('quizzes', function (Blueprint $table) {
            // Drop the old enum priority column
            $table->dropColumn('priority');
        });
        
        Schema::table('quizzes', function (Blueprint $table) {
            // Add new priority_id column as foreign key
            $table->unsignedBigInteger('priority_id')->nullable()->after('answer');
            $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['priority_id']);
            $table->dropColumn('priority_id');
        });
        
        Schema::table('quizzes', function (Blueprint $table) {
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('answer');
        });
    }
};
