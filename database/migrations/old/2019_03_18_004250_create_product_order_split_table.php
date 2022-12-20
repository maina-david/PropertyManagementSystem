<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOrderSplitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order_split', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productID');
            $table->integer('qty');
            $table->char('product_type', 255);
            $table->char('price', 255);
            $table->integer('userID');
            $table->integer('OrderID');
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
        Schema::dropIfExists('product_order_split');
    }
}
