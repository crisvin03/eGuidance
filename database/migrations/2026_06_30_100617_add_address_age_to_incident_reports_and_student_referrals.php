<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->string('student_address')->nullable()->after('student_name');
            $table->unsignedTinyInteger('student_age')->nullable()->after('student_address');
        });

        Schema::table('student_referrals', function (Blueprint $table) {
            $table->string('student_address')->nullable()->after('student_name');
            $table->unsignedTinyInteger('student_age')->nullable()->after('student_address');
        });
    }

    public function down(): void
    {
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->dropColumn(['student_address', 'student_age']);
        });

        Schema::table('student_referrals', function (Blueprint $table) {
            $table->dropColumn(['student_address', 'student_age']);
        });
    }
};
