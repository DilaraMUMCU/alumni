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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('resume_url')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'shortlisted', 'accepted', 'rejected'])->default('pending');
            $table->dateTime('applied_at')->useCurrent();
            $table->timestamps();

            $table->unique(['job_posting_id', 'user_id']);
            $table->index('status');
            $table->index(['job_posting_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
