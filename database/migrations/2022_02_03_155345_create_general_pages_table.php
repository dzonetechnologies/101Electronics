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
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_pages');
    }
}
