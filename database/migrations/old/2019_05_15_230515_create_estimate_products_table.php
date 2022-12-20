<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateProductsTable extends Migration
{
   /**
    * Run the migrations.
      *
      * @return void
      */
   public function up()
   {
      Schema::create('estimate_products', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('estimateID');
         $table->integer('productID');
         $table->char('product_name', 255)->nullable();
         $table->integer('quantity');
         $table->char('price',10)->nullable();
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
      Schema::dropIfExists('estimate_products');
   }
}
