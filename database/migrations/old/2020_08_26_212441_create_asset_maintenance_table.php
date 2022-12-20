<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMaintenanceTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('asset_maintenance', function (Blueprint $table) {
         $table->id();
         $table->integer('assetID')->nullable();
         $table->integer('supplierID')->nullable();
         $table->integer('maintenance_type')->nullable();
         $table->char('title',255)->nullable();
         $table->datetime('start_date')->nullable();
         $table->datetime('completion_date')->nullable();
         $table->char('warranty_improvement',10)->nullable();
         $table->char('cost',20)->nullable();
         $table->text('note')->nullable();
         $table->integer('businessID');
         $table->integer('created_by')->nullable();
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
      Schema::dropIfExists('asset_maintenance');
   }
}
