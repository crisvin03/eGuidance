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
        Schema::table('session_notes', function (Blueprint $table) {
            // Make appointment_id nullable so notes can be for concerns too
            $table->foreignId('appointment_id')->nullable()->change();
            
            // Add concern_id as an optional foreign key
            $table->foreignId('concern_id')->nullable()->after('appointment_id')->constrained('concerns')->onDelete('cascade');
            
            // Add note title for better organization
            $table->string('title')->nullable()->after('counselor_id');
            
            // Add follow-up date
            $table->date('follow_up_date')->nullable()->after('recommendations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->dropColumn(['concern_id', 'title', 'follow_up_date']);
            $table->foreignId('appointment_id')->nullable(false)->change();
        });
    }
};
