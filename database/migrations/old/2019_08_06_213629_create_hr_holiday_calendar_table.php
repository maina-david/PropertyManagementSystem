<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrHolidayCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_holiday_calendar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name');
            $table->char('status');
            $table->date('start');
            $table->date('end');
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
        Schema::dropIfExists('hr_holiday_calendar');
    }
}
