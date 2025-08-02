<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('defense_submissions')) {
            Schema::create('defense_submissions', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('last_name')->nullable();
                $table->string('first_names')->nullable();
                $table->string('email')->nullable();
                $table->json('contacts')->nullable();
                $table->string('student_id_number')->nullable();
                $table->foreignId('defense_submission_period_id')->constrained()->onDelete('cascade');
                $table->string('thesis_title');
                $table->foreignId('department_id');
                $table->foreignId('professor_id')->nullable()->constrained()->nullOnDelete();
                $table->json('files')->nullable();
                $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
                $table->enum('defense_type', ['licence', 'master', 'engineering']);
                $table->text('rejection_reason')->nullable();
                $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
                $table->dateTime('defense_date')->nullable();
                $table->timestamps();

                $table->foreign('student_id_number')->references('student_id_number')->on('students')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('defense_submissions');
    }
};
