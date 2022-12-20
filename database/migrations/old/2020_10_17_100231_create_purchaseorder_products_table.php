<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseorderProductsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('purchaseorder_products', function (Blueprint $table) {
         $table->id();
         $table->integer('lpoID');
         $table->integer('productID')->nullable();
         $table->char('quantity',50)->nullable();
         $table->char('discount',50)->nullable();
         $table->char('taxrate',50)->nullable();
         $table->char('taxvalue',50)->nullable();
         $table->char('total_amount',50)->nullable();
         $table->char('main_amount',50)->nullable();
         $table->char('sub_total',50)->nullable();
         $table->char('price',50)->nullable();
         $table->integer('businessID')->nullable();
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
      Schema::dropIfExists('purchaseorder_products');
   }
}
