<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseordersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchaseorders', function (Blueprint $table) {
			$table->id();
			$table->integer('supplierID');
			$table->char('lpo_number')->nullable();
			$table->char('reference_number')->nullable();
			$table->char('title')->nullable();
			$table->date('lpo_date')->nullable();
			$table->date('lpo_due')->nullable();
			$table->char('customer_note')->nullable();
			$table->char('terms')->nullable();
			$table->integer('statusID')->nullable(); 
			$table->char('purchesorder_code')->nullable();
			$table->integer('businessID');
			$table->char('sub_total')->nullable();
			$table->char('main_amount')->nullable();
			$table->char('discount')->nullable();
			$table->char('total')->nullable();
			$table->char('taxvalue')->nullable();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
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
		Schema::dropIfExists('purchaseorders');
	}
}
