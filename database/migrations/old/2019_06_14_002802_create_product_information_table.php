<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('product_name', 255)->nullable();
            $table->char('sku_code', 100)->nullable();
            $table->integer('brandID')->nullable();
            $table->integer('vendorID')->nullable();
            $table->char('pos_item', 50)->nullable();
            $table->char('ecommerce_item', 50)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->char('trash', 20)->nullable();
            $table->integer('userID');
            $table->integer('businessID');
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
        Schema::dropIfExists('product_information');
    }
}
