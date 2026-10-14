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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->enum('employment_type', ['full-time', 'part-time', 'internship'])->default('full-time');
            $table->text('description');
            $table->string('application_url')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->timestamps();

            $table->index('company');
            $table->index('employment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
