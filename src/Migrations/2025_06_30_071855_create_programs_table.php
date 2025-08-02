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
                $table->integer('credit');
                $table->float('pond_session_normale');
                $table->float('pond_session_rattrapage');
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
