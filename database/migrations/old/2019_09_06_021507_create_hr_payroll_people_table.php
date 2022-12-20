<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_payroll_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payrollID');
            $table->integer('businessID');
            $table->integer('employeeID');
            $table->char('salary');
            $table->char('net_pay');
            $table->char('gross_pay');
            $table->char('deduction');
            $table->char('addition');
            $table->char('payment_type');
            $table->char('period');
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
        Schema::dropIfExists('hr_payroll_people');
    }
}
