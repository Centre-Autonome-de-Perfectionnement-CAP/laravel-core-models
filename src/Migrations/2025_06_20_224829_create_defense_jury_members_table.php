<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('defense_jury_members')) {
            Schema::create('defense_jury_members', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->foreignId('defense_submission_id')->constrained()->onDelete('cascade');
                $table->foreignId('professor_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('grade_id')->nullable()->constrained()->onDelete('set null');
                $table->string('name')->nullable();
                $table->enum('role', [
                    'Président du Jury',
                    'Maitre de mémoire',
                    'Examinateur',
                    'Membre du Jury'
                ])->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('defense_jury_members');
    }
};
