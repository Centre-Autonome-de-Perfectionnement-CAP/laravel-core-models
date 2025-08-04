<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('old_system_notes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('student_pending_student_id');
            $table->unsignedBigInteger('program_id');
            $table->json('notes')->nullable(); // Pour stocker plusieurs notes (devoirs)
            $table->float('moyenne')->nullable();
            $table->timestamps();

            $table->foreign('student_pending_student_id')->references('id')->on('student_pending_students')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->unique(['student_pending_student_id', 'program_id']); // Un étudiant ne peut avoir qu'un ensemble de notes par programme
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('old_system_notes');
    }
};
