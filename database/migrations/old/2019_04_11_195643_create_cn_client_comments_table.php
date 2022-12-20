<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnClientCommentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('cn_client_comments', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('adminID');
         $table->integer('clientID');
         $table->text('comment');
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
      Schema::dropIfExists('cn_client_comments');
   }
}
