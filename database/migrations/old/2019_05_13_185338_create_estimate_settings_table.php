<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number')->nullable();
            $table->char('prefix', 255)->nullable();
            $table->char('editing_of_Sent', 20)->nullable();
            $table->text('default_terms_conditions')->nullable();
            $table->text('default_customer_notes')->nullable();
            $table->text('default_footer')->nullable();
            $table->char('show_discount_tab',20)->nullable();
            $table->char('show_tax_tab',20)->nullable();
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
        Schema::dropIfExists('estimate_settings');
    }
}
