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
        Schema::table('users', function (Blueprint $table) {
            $table->string('lrn')->nullable()->after('student_id'); // Learner Reference Number
            $table->string('grade_level')->nullable()->after('lrn');
            $table->string('section')->nullable()->after('grade_level');
            $table->string('adviser')->nullable()->after('section');
            $table->string('contact_person')->nullable()->after('adviser');
            $table->string('contact_number')->nullable()->after('contact_person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lrn', 'grade_level', 'section', 'adviser', 'contact_person', 'contact_number']);
        });
    }
};
