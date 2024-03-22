<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 100)->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('payment_gateway');
            $table->string('discount_code', 100)->nullable();
            $table->double('b2b_discount');
            $table->double('sub_total');
            $table->double('gst');
            $table->double('discount');
            $table->double('shipping');
            $table->double('installation');
            $table->double('voucher_amount')->nullable();
            $table->double('order_total');
            $table->text('order_notes');
            $table->integer('order_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
