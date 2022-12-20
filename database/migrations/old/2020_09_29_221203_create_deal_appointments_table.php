<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealAppointmentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('deal_appointments', function (Blueprint $table) {
         $table->id();
         $table->char('title',255);
         $table->char('priority',100);
         $table->char('status',100);
         $table->integer('owner');
         $table->date('start_date',255);
         $table->char('start_time',20)->nullable();
         $table->date('end_date',255);
         $table->char('end_time',20)->nullable();
         $table->text('description');
         $table->integer('dealID');
         $table->integer('created_by');
         $table->integer('updated_by');
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
      Schema::dropIfExists('deal_appointments');
   }
}
