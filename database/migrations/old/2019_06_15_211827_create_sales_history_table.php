<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productID');
            $table->char('transactionID');
            $table->char('qty');
            $table->char('selling_price');
            $table->char('buying_price');
            $table->char('taxrate');
            $table->integer('businessID');
            $table->char('total_price');
            $table->integer('userID');
            $table->integer('customerID');
            $table->text('note');
            $table->integer('payment_type_id');
            $table->integer('statusID');
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
        Schema::dropIfExists('sales_history');
    }
}
