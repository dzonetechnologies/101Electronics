<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstantCalculatorsTable extends Migration
{
    public function up()
    {
        Schema::create('instant_calculators', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instant_calculators');
    }
}
