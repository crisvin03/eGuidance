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
        // Alter the enum to add 'future_me'
        DB::statement("ALTER TABLE resources MODIFY COLUMN category ENUM('hrg', 'handbook', 'gender_dev', 'future_me') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'future_me' from the enum
        DB::statement("ALTER TABLE resources MODIFY COLUMN category ENUM('hrg', 'handbook', 'gender_dev') NOT NULL");
    }
};
