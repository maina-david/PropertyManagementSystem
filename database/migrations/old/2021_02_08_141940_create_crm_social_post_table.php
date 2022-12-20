<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmSocialPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_social_post', function (Blueprint $table) {
            $table->id();
            $table->integer('businessID');
            $table->text('post');
            $table->text('link')->nullable();
            $table->text('link_description')->nullable();
            $table->text('code'); 
            $table->integer('status');
            $table->char('scheduled_upload_date_time');
            $table->char('repeat',50)->nullable();
            $table->char('repeat_period',50)->nullable();
            $table->char('repeat_day_date',50)->nullable();
            $table->date('repeat_end_date')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('crm_social_post');
    }
}
