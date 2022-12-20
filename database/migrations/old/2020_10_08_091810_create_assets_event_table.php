<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_event', function (Blueprint $table) {
            $table->id();
            $table->integer('assetID');
            $table->integer('status')->nullable();
            $table->char('due_action_date')->nullable();
            $table->char('action_date');
            $table->char('check_out_to')->nullable();
            $table->integer('branch')->nullable();
            $table->integer('allocated_to')->nullable();
            $table->char('site_location',255)->nullable();
            $table->integer('department')->nullable();
            $table->text('note')->nullable();       
            $table->char('cost')->nullable();
            $table->char('action_to')->nullable();
            $table->char('deductible')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('assets_event');
    }
}
