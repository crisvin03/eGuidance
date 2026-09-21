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
        Schema::create('mental_health_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('assessment_type', ['headss', 'gad7', 'phq9']);
            $table->json('responses');
            $table->integer('score')->nullable(); // Numeric score for GAD-7 and PHQ-9
            $table->enum('risk_level', ['low', 'mild', 'moderate', 'moderately-high', 'high']);
            $table->boolean('counselor_notified')->default(false);
            $table->boolean('follow_up_scheduled')->default(false);
            $table->timestamp('follow_up_date')->nullable();
            $table->text('counselor_notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index('assessment_type');
            $table->index('risk_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mental_health_assessments');
    }
};
