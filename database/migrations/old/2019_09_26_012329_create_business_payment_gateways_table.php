<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessPaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('businessID');
            $table->integer('userID');
            $table->integer('gatewayID');
            $table->char('currency_code',100)->nullable();
            $table->char('email',255)->nullable();
            $table->char('conversion_rate',255)->nullable();
            $table->integer('status');
            $table->char('publishable_key',255)->nullable();
            $table->char('secret_key',255)->nullable();
            $table->char('bank_name',255)->nullable();
            $table->char('bank_account',255)->nullable();
            $table->char('bank_branch',255)->nullable();
            $table->char('bank_account_name',255)->nullable();
            $table->char('api_login_id',255)->nullable();
            $table->char('transaction_key',255)->nullable();
            $table->char('merchantID',255)->nullable();
            $table->char('public_key',255)->nullable();
            $table->char('private_key',255)->nullable();
            $table->char('default_account',255)->nullable();
            $table->char('live_or_sandbox',255)->nullable();
            $table->char('till_number',255)->nullable();
            $table->char('paybill_number',255)->nullable();
            $table->char('customer_key',255)->nullable();
            $table->char('customer_secret',255)->nullable();
            $table->char('merchant_consumer_key',255)->nullable();
            $table->char('merchant_consumer_secret',255)->nullable();
            $table->char('iframelink',255)->nullable();
            $table->char('callback_url',255)->nullable();
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
        Schema::dropIfExists('business_payment_gateways');
    }
}
