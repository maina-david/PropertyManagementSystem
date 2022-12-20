<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesordersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('salesorders', function (Blueprint $table) {
         $table->id();
         $table->integer('customerID');
         $table->char('subject')->nullable();
         $table->char('reference')->nullable();
         $table->integer('salesorder_number');
         $table->date('salesorder_date')->nullable();
         $table->date('salesorder_due_date')->nullable();
         $table->text('customer_note')->nullable();
         $table->text('terms_conditions')->nullable();
         $table->integer('salesperson')->nullable();
         $table->char('taxconfig',25)->nullable();
         $table->integer('statusID')->nullable();
         $table->integer('businessID')->nullable();
         $table->char('main_amount',50)->nullable();
         $table->char('discount', 50)->nullable();
         $table->char('total', 50)->nullable();
         $table->char('balance', 50)->nullable();
         $table->char('sub_total', 50)->nullable();
         $table->char('taxvalue', 50)->nullable();
         $table->integer('created_by')->nullable();         
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
      Schema::dropIfExists('salesorders');
   }
}
