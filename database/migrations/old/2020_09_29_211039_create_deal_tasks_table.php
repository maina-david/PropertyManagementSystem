<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealTasksTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('deal_tasks', function (Blueprint $table) {
         $table->id();
         $table->char('task',255);
         $table->date('date')->nullable();
         $table->char('time',20)->nullable();
         $table->integer('assigned_to')->nullable();
         $table->char('priority',100)->nullable();
         $table->char('status',100)->nullable();
         $table->char('category',100)->nullable();
         $table->integer('dealID')->nullable();
         $table->text('description')->nullable();
         $table->integer('created_by');
         $table->integer('updated_by')->nullable();
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
      Schema::dropIfExists('deal_tasks');
   }
}
