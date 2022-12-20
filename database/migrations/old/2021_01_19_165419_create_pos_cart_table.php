<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCartTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('pos_cart', function (Blueprint $table) {
         $table->id();
         $table->integer('productID')->unsigned();
         $table->integer('qty')->default(1);
         $table->integer('price')->default(1);
         $table->integer('tax_rate')->default(0);
         $table->integer('tax_value')->default(0);
         $table->integer('discount')->default(0);
         $table->integer('userID')->unsigned();
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
      Schema::dropIfExists('pos_cart');
   }
}
