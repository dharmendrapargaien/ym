<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerBusinessAdvertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('seller_business_advertises', function(Blueprint $table){
            
            $table->increments('id');

            $table->integer('seller_business_id')->unsigned();
            $table->foreign('seller_business_id')->references('id')->on('seller_businesses');

            $table->string('description', 400)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('advertise_type')->default(1);//default there is no type
            $table->tinyInteger('status')->default(0);//default advertise is not approved

            $table->softDeletes();
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

        Schema::drop('seller_business_advertises');
    }
}
