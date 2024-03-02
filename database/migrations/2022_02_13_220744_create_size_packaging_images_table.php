<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizePackagingImagesTable extends Migration
{
    public function up()
    {
        Schema::create('size_packaging_images', function (Blueprint $table) {
            $table->id();
            $table->integer('category');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('size_packaging_images');
    }
}
