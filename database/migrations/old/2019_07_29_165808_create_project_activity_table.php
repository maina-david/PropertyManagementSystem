<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectActivityTable extends Migration
{
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
      Schema::create('project_activity', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->char('activity',255);
         $table->integer('projectID');
         $table->char('action',255);
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
   Schema::dropIfExists('project_activity');
   }
}
