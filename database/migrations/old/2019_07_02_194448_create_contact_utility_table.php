<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUtilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_utility', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contactID');
            $table->integer('utilityID');
            $table->char('name',255);
            $table->char('serial_number');
            $table->char('start_units');
            $table->char('current_units')->nullable();
            $table->char('billing_count')->nullable();
            $table->integer('businessID');
            $table->integer('userID');
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
        Schema::dropIfExists('contact_utility');
    }
}
