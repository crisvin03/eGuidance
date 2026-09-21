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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['hrg', 'handbook', 'gender_dev']); // Home Room Guidance, Handbook & Policies, Gender and Development Corner
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // pdf, doc, docx, etc.
            $table->integer('file_size'); // in bytes
            $table->unsignedBigInteger('uploaded_by'); // counselor who uploaded
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['category', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
