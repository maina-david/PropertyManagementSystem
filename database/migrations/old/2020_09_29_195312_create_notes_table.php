<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('notes', function (Blueprint $table) {
         $table->id();
         $table->char('subject',255);
         $table->text('note')->nullable();
         $table->integer('parentID');
         $table->char('section',50);
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
      Schema::dropIfExists('notes');
   }
}
