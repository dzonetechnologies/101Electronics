<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_repairs', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->text('get_care_repair');
            $table->text('inspection');
            $table->text('day_fix');
            $table->text('visit_charges');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_repairs');
    }
}
