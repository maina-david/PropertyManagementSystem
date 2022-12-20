<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmSocialAccountsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('crm_social_accounts', function (Blueprint $table) {
         $table->id();
         $table->char('title');
         $table->char('token'); 
         $table->integer('buisnessID');
         $table->integer('created_by');
         $table->integer('updated_by');
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
      Schema::dropIfExists('crm_social_accounts');
   }
}
