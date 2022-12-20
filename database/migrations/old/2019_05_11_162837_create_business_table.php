<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('business', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('businessID',100);
         $table->char('name',255);
         $table->char('logo',255)->nullable();
         $table->integer('industry')->nullable();
         $table->integer('country')->nullable();
         $table->char('postal_address', 100)->nullable();
         $table->char('street',255)->nullable();
         $table->char('city', 255)->nullable();
         $table->char('state_province', 255)->nullable();
         $table->char('zip_code', 50)->nullable();
         $table->char('primary_phonenumber', 100)->nullable();
         $table->char('fax', 255)->nullable();
         $table->char('primary_email', 255)->nullable();
         $table->char('update_address_in_all',10)->nullable();
         $table->integer('base_currency')->nullable();
         $table->integer('fiscal_year')->nullable();
         $table->char('website', 255)->nullable(); 
         $table->char('company_size', 100)->nullable(); 
         $table->integer('language')->nullable();
         $table->char('time_zone', 255)->nullable();
         $table->integer('date_format')->nullable();
         $table->integer('adminID');
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
      Schema::dropIfExists('business');
   }
}
