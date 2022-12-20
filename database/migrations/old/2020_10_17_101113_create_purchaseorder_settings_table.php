<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseorderSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('purchaseorder_settings', function (Blueprint $table) {
         $table->id();
         $table->integer('number');
         $table->char('prefix')->nullable();
         $table->integer('businessID');
         $table->integer('created_by');
         $table->integer('updated_by')->nullable();
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
      Schema::dropIfExists('purchaseorder_settings');
   }
}
