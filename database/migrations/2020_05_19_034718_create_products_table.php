<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->string('url_img1')->nullable();
            $table->string('url_img2')->nullable();
            $table->string('url_img3')->nullable();
            $table->string('name')->nullable();
            $table->string('detail')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('discount')->nullable();
            $table->integer('product_category')->nullable();
            $table->boolean('is_published')->default(true);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('products');
    }
}
