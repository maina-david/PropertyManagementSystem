<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesorderSettingsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('salesorder_settings', function (Blueprint $table) {
         $table->id();
         $table->integer('number');
         $table->char('prefix')->nullable();
         $table->integer('businessID');
         $table->integer('updated_by')->nullable();
         $table->integer('created_by');
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
      Schema::dropIfExists('salesorder_settings');
   }
}
