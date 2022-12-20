<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKnowledgebaseGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledgebase_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name',255);
            $table->text('description')->nullable();
            $table->char('status')->nullable();
            $table->char('slug',255);
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('knowledgebase_group');
    }
}
