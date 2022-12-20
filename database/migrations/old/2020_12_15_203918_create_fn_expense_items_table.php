<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnExpenseItemsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('fn_expense_items', function (Blueprint $table) {
         $table->id();
         $table->integer('expenseID');
         $table->integer('travelID');
         $table->text('expense');
         $table->char('quantity',50);
         $table->char('price',50);
         $table->char('taxrate',20)->nullable();
         $table->char('taxvalue',20)->nullable();
         $table->char('total_amount');
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
      Schema::dropIfExists('fn_expense_items');
   }
}
