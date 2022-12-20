<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id');
            $table->integer('client_id');
            $table->integer('statusID')->nullable();
            $table->integer('currencyID')->nullable();
            $table->char('lpo_number', 20)->nullable();
            $table->integer('projectID')->nullable();
            $table->text('terms')->nullable();
            $table->integer('invoice_number');
            $table->char('sub_total',20);
            $table->char('total',20);
            $table->char('paid',20)->nullable();
            $table->char('discount',20)->nullable();
            $table->char('discount_type',20)->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('invoice_due')->nullable();
            $table->integer('tax')->nullable();
            $table->char('attachment', 255)->nullable();
            $table->char('invoice_type',70)->nullable();
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
        Schema::dropIfExists('invoice');
    }
}
