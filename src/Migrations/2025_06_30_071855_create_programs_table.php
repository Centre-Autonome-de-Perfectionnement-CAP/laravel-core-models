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
        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->foreignId('classe_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_professor_id')->constrained('course_professors')->onDelete('cascade');
                $table->string('semester');
                $table->integer('hourly_mass');
                $table->foreignId('ue_id')->nullable()->constrained()->onDelete('set null');
                $table->string('code');
                $table->json('pond_session_normale')->nullable();
                $table->json('pond_session_rattrapage')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
