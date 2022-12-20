<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('branch_name',255);
            $table->char('country',255);
            $table->char('city',255);
            $table->char('address',255);
            $table->char('phone_number',255);
            $table->char('email',255);
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
        Schema::dropIfExists('hr_branches');
    }
}
