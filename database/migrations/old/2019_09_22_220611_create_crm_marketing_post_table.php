<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmMarketingPostTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_marketing_post', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('businessID');
         $table->integer('userID');
         $table->integer('accountID');
         $table->integer('channelID');
         $table->text('post');
         $table->char('media');
         $table->char('status');
         $table->char('upload_time');
         $table->integer('post_count');
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
      Schema::dropIfExists('crm_marketing_post');
   }
}
