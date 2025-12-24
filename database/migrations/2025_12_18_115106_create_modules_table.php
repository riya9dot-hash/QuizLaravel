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
        if (!Schema::hasTable('modules')) {
            Schema::create('modules', function (Blueprint $table) {
                $table->id();
                $table->string('name', 191)->unique(); // e.g., 'dashboard', 'quiz', 'user'
                $table->unsignedBigInteger('created_by')->nullable(); // Super Admin who created
                $table->timestamps();
                $table->softDeletes();
                
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            });
        } else {
            // Table exists, ensure required columns exist
            Schema::table('modules', function (Blueprint $table) {
                if (!Schema::hasColumn('modules', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('name');
                    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                }
                if (!Schema::hasColumn('modules', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
