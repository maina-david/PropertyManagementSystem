<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrTravelsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('hr_travels', function (Blueprint $table) {
         $table->id();
         $table->integer('employeeID');
         $table->char('place_of_visit',255);
         $table->integer('departmentID');
         $table->date('date_of_arrival');
         $table->date('departure_date');
         $table->char('duration',50);
         $table->char('purpose_of_visit',255);
         $table->integer('customerID');
         $table->char('bill_customer',20);
         $table->integer('status');         
         $table->integer('approved_by')->nullable();
         $table->date('approval_date')->nullable();
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
      Schema::dropIfExists('hr_travels');
   }
}
