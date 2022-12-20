<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTaskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_task_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('taskID');
            $table->char('file_name', 255)->nullabe();
            $table->char('file', 255);
            $table->char('mime', 255)->nullable();
            $table->char('size', 255)->nullabe();
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
        Schema::dropIfExists('project_task_files');
    }
}
