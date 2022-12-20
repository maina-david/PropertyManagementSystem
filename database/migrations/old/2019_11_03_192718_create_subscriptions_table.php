<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('subscriptions', function (Blueprint $table) {
         $table->id();
         $table->integer('customer');
         $table->char('subscription_number');         
         $table->char('reference')->nullable();  
         $table->date('starts_on');
         $table->date('next_billing');
         $table->date('last_billing');         
         $table->integer('sales_person')->nullable(); 
         $table->char('expiration_cycle')->nullable();  
         $table->char('cycles')->nullable();  
         $table->char('amount');   
         $table->char('price');
         $table->char('trial_days')->nullable();  
         $table->date('trial_end_date')->nullable();   
         $table->integer('product');   
         $table->integer('plan');
         $table->char('qty');
         $table->char('tax_rate')->nullable();  
         $table->integer('status')->nullable();   
         $table->integer('businessID');
         $table->integer('created_by');
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
      Schema::dropIfExists('subscriptions');
   }
}
