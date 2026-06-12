<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('student_name');
            $table->string('grade_section');
            $table->date('date_of_referral');
            $table->enum('incident_category', [
                'bullying',
                'behavioral_concern',
                'mental_health',
                'academic_risk',
                'child_protection',
                'classroom_incident',
            ]);
            $table->enum('concern_type', [
                'academic',
                'emotional_mental',
                'social_peer',
                'family',
                'behavioral',
                'relationships_personal',
                'safety_protection',
                'career_future',
                'counseling_support',
                'other',
            ]);
            $table->text('incident_description');
            $table->text('initial_intervention')->nullable();
            $table->string('parent_guardian_name')->nullable();
            $table->string('parent_guardian_contact')->nullable();
            $table->string('referred_by_name');
            $table->string('referred_by_designation');
            $table->enum('urgency_level', ['low', 'moderate', 'high'])->default('low');
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'closed'])->default('pending');
            $table->foreignId('assigned_counselor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('counselor_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
