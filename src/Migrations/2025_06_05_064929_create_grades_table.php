<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('grades')) {
            Schema::create('grades', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('name');
                $table->string('abbreviation');
                $table->timestamps();
            });


            // Insérer les grades autorisés
            DB::table('grades')->insert([
                ['name' => 'Professeur', 'uuid' => Str::uuid(), 'abbreviation' => 'Pr'],
                ['name' => 'Maître de Conférences', 'uuid' => Str::uuid(), 'abbreviation' => 'MC'],
                ['name' => 'Docteur', 'uuid' => Str::uuid(), 'abbreviation' => 'Dr'],
                ['name' => 'Maître Assistant', 'uuid' => Str::uuid(), 'abbreviation' => 'Dr(MA)'],
                ['name' => 'Monsieur', 'uuid' => Str::uuid(), 'abbreviation' => 'M.'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
