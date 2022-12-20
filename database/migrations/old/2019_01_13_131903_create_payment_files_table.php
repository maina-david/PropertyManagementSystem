<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paymentID');
            $table->char('file', 255);
            $table->char('file_name', 255)->nullable();
            $table->char('file_size', 20)->nullable();
            $table->char('file_mime', 150)->nullable();
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
        Schema::dropIfExists('payment_files');
    }
}
