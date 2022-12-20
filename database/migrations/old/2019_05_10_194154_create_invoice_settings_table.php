<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceSettingsTable extends Migration
{
   /**
    * Run the migrations.
      *
      * @return void
      */
   public function up()
   {
      Schema::create('invoice_settings', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->integer('invoice_number')->nullable();
         $table->char('invoice_prefix', 255)->nullable();
         $table->char('editing_of_Sent', 20)->nullable();
         $table->char('notify_on_payment', 20)->nullable();
         $table->char('automate_thank_you_note', 20)->nullable();
         $table->text('default_terms_conditions')->nullable();
         $table->text('default_customer_notes')->nullable();
         $table->char('auto_thank_you_payment_received',20)->nullable();
         $table->char('auto_archive', 20)->nullable();
         $table->char('automatically_email_recurring', 20)->nullable();
         $table->text('default_invoice_footer')->nullable();
         $table->char('show_discount_tab',20)->nullable();
         $table->char('show_tax_tab',20)->nullable();
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
      Schema::dropIfExists('invoice_settings');
   }
}
