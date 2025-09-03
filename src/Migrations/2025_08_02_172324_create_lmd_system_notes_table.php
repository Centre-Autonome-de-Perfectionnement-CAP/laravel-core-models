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
        Schema::create('lmd_system_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('student_pending_student_id');
            $table->unsignedBigInteger('program_id');
            $table->json('notes')->nullable();
            $table->float('moyenne')->nullable();
            $table->json('notes_rattrapage')->nullable();
            $table->float('moyenne_rattrapage')->nullable();
            $table->boolean('valide')->default(false);
            $table->boolean('rattrape')->default(false);
            $table->boolean('reprends')->default(false);
            $table->timestamps();

            $table->foreign('student_pending_student_id')->references('id')->on('student_pending_students')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unique(['student_pending_student_id', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lmd_system_notes');
    }
};
