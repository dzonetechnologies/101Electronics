<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWeightsTable extends Migration
{
    public function up()
    {
        Schema::create('product_weights', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->double('weight');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_weights');
    }
}
