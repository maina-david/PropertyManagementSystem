<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productID')->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('reorder_level')->nullable();
            $table->integer('replenish_level')->nullable();
            $table->date('expiration_date');
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
        Schema::dropIfExists('product_inventory');
    }
}
