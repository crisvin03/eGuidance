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
        Schema::create('student_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['poetry', 'artwork', 'photography']); // Poetry & Stories, Artwork, Photography
            $table->string('file_name')->nullable(); // for artwork/photography files
            $table->string('file_path')->nullable(); // for artwork/photography files
            $table->string('file_type')->nullable(); // jpg, png, pdf, etc.
            $table->integer('file_size')->nullable(); // in bytes
            $table->longText('content')->nullable(); // for poetry/stories text content
            $table->unsignedBigInteger('student_id'); // student who submitted
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('counselor_notes')->nullable(); // feedback from counselor
            $table->unsignedBigInteger('reviewed_by')->nullable(); // counselor who reviewed
            $table->timestamp('reviewed_at')->nullable();
            $table->boolean('is_featured')->default(false); // for showcasing best submissions
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['type', 'status']);
            $table->index(['student_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_submissions');
    }
};
