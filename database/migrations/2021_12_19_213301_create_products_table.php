<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->string('name');
            $table->string('brand');
            $table->integer('category');
            $table->integer('sub_category');
            $table->integer('sub_subcategory');
            $table->boolean('clearance_sale')->comment("0- No, 1- Yes")->default(0);
            $table->double('rating')->nullable();
            $table->double('review')->nullable();
            $table->boolean('installment_calculator')->comment("0- not available, 1- available")->default(0);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('primary_img')->nullable();
            $table->string('size_packaging_img')->nullable();
            $table->string('video_link')->nullable();
            $table->string('video_file')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_img')->nullable();
            $table->string('color_variants')->nullable();
            $table->double('unit_price')->default(0);
            $table->double('purchase_price')->default(0);
            $table->double('tax')->default(0);
            $table->double('tax_price')->default(0);
            $table->double('discount')->nullable();
            $table->double('discount_price')->default(0);
            $table->double('total_price_without_discount');
            $table->double('total_price');
            $table->integer('quantity')->default(0);
            $table->boolean('free_shipping')->comment("0- free shipping, 1- paid shipping")->default(0);
            $table->double('shipping_flat_rate')->nullable();
            $table->boolean('fast_24hour_delivery')->comment("0- No, 1- yes")->default(0);
            $table->boolean('normal_2to3days_delivery')->comment("0- No, 1- yes")->default(0);
            $table->boolean('zero_free_installation')->comment("0- No, 1- yes")->default(0);
            $table->double('intallation_price')->nullable();
            $table->string('pdf_specification')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('draft_status')->default(0)->comment('0- published,	1- draft');
            $table->boolean('homepage_status')->default(0)->comment('0- No,	1- Yes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
