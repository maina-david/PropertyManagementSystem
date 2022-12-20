<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPayrollSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_payroll_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('businessID');
            $table->integer('userID');
            $table->char('pay_period')->nullable();
            $table->char('monthly_payday')->nullable();
            $table->char('enable_mid_month_pay')->nullable();
            $table->char('mid_month_payday')->nullable();
            $table->char('mid_month_rate_type')->nullable();
            $table->char('mid_month_rate')->nullable();
            $table->char('compute_statutory')->nullable();
            $table->char('assignee')->nullable();
            $table->char('payroll_approval')->nullable();
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
        Schema::dropIfExists('hr_payroll_settings');
    }
}
