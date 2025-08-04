<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('minimal_averages', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('cycle_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->float('minimal_average')->default(12.0);
            $table->string('uuid')->unique()->default(\Illuminate\Support\Str::uuid());
            $table->timestamps();

            $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->unique(['cycle_id', 'academic_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('minimal_averages');
    }
};
