<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('discount_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('discount_code');
            $table->double('voucher_price');
            $table->double('min_shopping_price');
            $table->integer('limit');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('status')->default(1)->comment('1- Active, 0- Deactive');
            $table->text('desc');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_vouchers');
    }
}
