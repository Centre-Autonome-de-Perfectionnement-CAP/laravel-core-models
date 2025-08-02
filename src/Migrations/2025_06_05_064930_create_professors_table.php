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
        if (!Schema::hasTable('professors')) {
            Schema::create('professors', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('last_name');
                $table->string('first_name');
                $table->string('email')->unique();
                $table->string('phone');
                $table->string('password');
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->string('rib_number');
                $table->string('rib');
                $table->string('ifu_number');
                $table->string('ifu');
                $table->string('bank');
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professors');
    }
};
