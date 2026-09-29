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
        // First, add the client_name column
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('student_id');
        });
        
        // Then, make student_id nullable by modifying it directly with raw SQL
        DB::statement('ALTER TABLE appointments MODIFY student_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('client_name');
        });
        
        // Make student_id required again
        DB::statement('ALTER TABLE appointments MODIFY student_id BIGINT UNSIGNED NOT NULL');
    }
};
