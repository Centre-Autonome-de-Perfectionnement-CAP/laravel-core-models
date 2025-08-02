<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuryFeesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('programs')) {
            Schema::create('jury_fees', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('degree_type');
                $table->string('role');
                $table->decimal('amount', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('jury_fees');
    }
}
