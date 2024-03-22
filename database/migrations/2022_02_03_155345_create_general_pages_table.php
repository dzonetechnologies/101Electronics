<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralPagesTable extends Migration
{
    public function up()
    {
        Schema::create('general_pages', function (Blueprint $table) {
            $table->id();
            $table->string("page_name");
            $table->string("meta_title")->nullable();
            $table->text("meta_description")->nullable();
            $table->text('desc')->nullable();
            $table->string("banner_img")->nullable();
            $table->string("banner_img_mobile")->nullable();
            $table->integer("type");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_pages');
    }
}
