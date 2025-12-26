<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only drop code column if it exists
        if (Schema::hasColumn('languages', 'code')) {
            Schema::table('languages', function (Blueprint $table) {
                // Try to drop unique index if it exists
                try {
                    DB::statement('ALTER TABLE `languages` DROP INDEX `languages_code_unique`');
                } catch (\Exception $e) {
                    // Index doesn't exist, continue
                }
                
                $table->dropColumn('code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('code', 10)->unique()->after('name');
        });
    }
};
