<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('admin_id');
            $table->integer('client_id');
            $table->integer('statusID')->nullable();
            $table->integer('currencyID')->nullable();
            $table->char('reference_number', 20)->nullable();
            $table->text('estimate_note')->nullable();
            $table->text('terms')->nullable();
            $table->integer('estimate_number');
            $table->char('sub_total',20);
            $table->char('total',20);
            $table->char('paid',20)->nullable();
            $table->char('discount',20)->nullable();
            $table->char('discount_type',20)->nullable();
            $table->date('estimate_date')->nullable();
            $table->date('estimate_due')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('invoice_link')->nullable();
            $table->char('attachment', 255)->nullable();
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
        Schema::dropIfExists('estimate');
    }
}
