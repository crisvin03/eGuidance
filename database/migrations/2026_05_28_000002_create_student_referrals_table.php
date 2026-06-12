<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referral_number')->unique();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('student_name');
            $table->string('grade_section');
            $table->text('reason_for_referral');
            $table->text('observed_behavior')->nullable();
            $table->text('actions_taken')->nullable();
            $table->string('preferred_followup')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'closed'])->default('pending');
            $table->foreignId('assigned_counselor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('counselor_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_referrals');
    }
};
