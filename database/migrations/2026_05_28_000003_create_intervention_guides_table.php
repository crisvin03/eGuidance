<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intervention_guides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', [
                'adult_learner',
                'learner_learner',
                'learner_community',
                'panic_attack',
                'referral_guide',
                'career',
            ]);
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervention_guides');
    }
};
