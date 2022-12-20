<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrEmployeeSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_employee_salary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employeeID');
            $table->integer('userID');
            $table->char('type')->nullable();
            $table->char('rate_per_month')->nullable();
            $table->char('rate_per_hour')->nullable();
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
        Schema::dropIfExists('hr_employee_salary');
    }
}
