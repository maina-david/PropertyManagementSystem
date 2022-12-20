<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallLogsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('call_logs', function (Blueprint $table) {
         $table->id();
         $table->char('subject',255);
         $table->text('note')->nullable();
         $table->integer('parentID');
         $table->char('section',50);
         $table->char('phone_number',100);
         $table->char('phone_code',100);
         $table->char('contact_person',255);
         $table->char('hours',20);
         $table->char('minutes',20);
         $table->char('seconds',20);
         $table->char('call_type',100);
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
      Schema::dropIfExists('call_logs');
   }
}
