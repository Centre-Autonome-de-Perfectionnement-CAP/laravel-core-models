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
        if (!Schema::hasTable('course_professors')) {
            Schema::create('course_professors', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
                $table->boolean('principal')->default(false);
                $table->unique(['course_id', 'principal']);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_professors');
    }
};
