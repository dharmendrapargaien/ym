<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerAdvertiseImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('seller_advertise_images', function(Blueprint $table){
            
            $table->increments('id');

            $table->integer('seller_business_advertise_id')->unsigned();
            $table->foreign('seller_business_advertise_id')->references('id')->on('seller_business_advertises');

            $table->string('name', 255);
            $table->string('url', 255)->nullable();
            
            $table->integer('image_order')->default(1);//default there is no type
            $table->tinyInteger('status')->default(0);//default advertise is not approved
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

        Schema::drop('seller_advertise_images');
    }
}
