<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('productID')->nullable();
            $table->char('file_name')->nullable();
            $table->char('file_mime')->nullable();
            $table->char('file_size')->nullable();
            $table->integer('userID');
            $table->integer('businessID');
            $table->char('cover')->nullable();
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
        Schema::dropIfExists('product_gallery');
    }
}
