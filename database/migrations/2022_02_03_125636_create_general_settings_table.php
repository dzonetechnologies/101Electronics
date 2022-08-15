<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->text('facebook_pixel')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('announcement')->nullable();
            $table->text('homepage_selling_tagline')->nullable();
            $table->text('brandpage_selling_tagline')->nullable();
            $table->text('categorypage_selling_tagline')->nullable();
            $table->text('alldealspage_selling_tagline')->nullable();
            $table->string('shipping_quantity', 100)->nullable();
            $table->string('shipping_cost', 100)->nullable();
            $table->string('secure_payment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
