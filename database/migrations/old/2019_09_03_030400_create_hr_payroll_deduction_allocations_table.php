<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollDeductionAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_payroll_deduction_allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('businessID');
            $table->integer('userID');
            $table->integer('employeeID');
            $table->integer('deductionID');
            $table->char('rate');
            $table->char('amount');
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
        Schema::dropIfExists('hr_payroll_deduction_allocations');
    }
}
