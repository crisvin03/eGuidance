<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('form_type');        // e.g. confiscation-electronic, call-slip
            $table->string('form_title');       // Human-readable title
            $table->string('student_name')->nullable();
            $table->string('grade_section')->nullable();
            $table->longText('form_data');      // JSON of all filled fields
            $table->enum('status', ['submitted', 'reviewed', 'acknowledged'])->default('submitted');
            $table->text('counselor_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_form_submissions');
    }
};
