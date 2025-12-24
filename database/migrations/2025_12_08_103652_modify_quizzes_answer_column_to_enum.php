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
            $table->dropColumn('answer');
        });
        
        Schema::table('quizzes', function (Blueprint $table) {
            $table->enum('answer', ['true', 'false', 'both'])->default('true')->after('question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('answer');
        });
        
        Schema::table('quizzes', function (Blueprint $table) {
            $table->boolean('answer')->default(true)->after('question');
        });
    }
};
