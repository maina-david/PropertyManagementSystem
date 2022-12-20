<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_tasks', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('projectID');
			$table->integer('tasks_status_id')->nullable();
			$table->integer('tasks_priority_id')->nullable();
			$table->integer('tasks_type_id')->nullable();
			$table->integer('tasks_label_id')->nullable();
			$table->integer('tasks_groups_id')->nullable();
			$table->integer('projects_phases_id')->nullable();
			$table->integer('versions_id')->nullable();
			$table->integer('created_by');
			$table->char('name', 255);
			$table->text('description');
			$table->char('estimated_time', 10)->nullable();
			$table->date('due_date')->nullable();
			$table->date('close_date')->nullable();
			$table->integer('start_date')->nullable();
			$table->integer('progress')->nullable();
			$table->char('notify_client', 100)->nullable();
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
		Schema::dropIfExists('project_tasks');
	}
}
