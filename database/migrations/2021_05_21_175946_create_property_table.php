<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->id();
            $table->integer('parentID')->default(0);
            $table->integer('businessID');
            $table->integer('landlordID');
            $table->integer('tenantID')->default(0);
            $table->char('serial',255)->nullable();
            $table->char('property_code',255)->nullable();
            $table->char('leaseID',255)->nullable();
            $table->char('title',255)->nullable();
            $table->date('year_built')->nullable();
            $table->char('propert_type')->nullable();
            $table->char('street_address')->nullable();
            $table->char('city')->nullable();
            $table->char('state')->nullable();
            $table->char('zip_code')->nullable();
            $table->char('countryID')->nullable();
            $table->char('geaolocation')->nullable();
            $table->char('latitude')->nullable();
            $table->char('longitude')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->char('size')->nullable();
            $table->char('land_size')->nullable();
            $table->char('price')->nullable();
            $table->char('escalation')->nullable();
            $table->text('features')->nullable();
            $table->text('amenities')->nullable();
            $table->char('smoking')->nullable();
            $table->char('laundry')->nullable();
            $table->char('furnished')->nullable();
            $table->char('parking_size')->nullable();
            $table->text('description')->nullable();
            $table->char('ownership_type')->nullable();
            $table->char('status')->nullable();
            $table->char('management_name')->nullable();
            $table->char('management_email')->nullable();
            $table->char('management_phonenumber')->nullable();
            $table->char('management_postaladdress')->nullable();
            $table->char('bank_name')->nullable();
            $table->char('bank_branch')->nullable();
            $table->char('bank_account_number')->nullable();
            $table->char('paybill_number')->nullable();
            $table->char('paybill_name')->nullable();
            $table->char('image')->nullable();
            $table->integer('listing_status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('property');
    }
}
