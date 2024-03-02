<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSubcategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('sub_subcategories', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('category');
            $table->integer('subcategory');
            $table->string('title');
            $table->string('meta_title');
            $table->text('description')->nullable();
            $table->string('brand');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_subcategories');
    }
}
