<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectEventsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('project_events', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('projectID');
         $table->char('title');
         $table->text('description')->nullable();
         $table->text('results')->nullable();
         $table->datetime('start_date')->nullable();
         $table->datetime('end_date')->nullable();
         $table->char('status')->nullable();
         $table->char('venue', 255)->nullable();
         $table->char('priority')->nullable();
         $table->integer('userID');
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
      Schema::dropIfExists('project_events');
   }
}
