<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerBusinessAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('seller_business_addresses', function(Blueprint $table){
            
            $table->increment('id');

            $table->integer('seller_business_id')->unsigned();
            $table->foreign('seller_business_id')->references('id')->on('seller_businesses');
            
            $table->string('phone_no',12)->unique();
            $table->string('address',255)->nullable();
            $table->string('city',50)->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('zip_code')->nullable();
            
            $tavle->double('lat', 21, 8)->nullable();
            $tavle->double('long', 21, 8)->nullable();

            $table->tinyInteger('status')->default(1);//default user business is activated
            
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

        Schema::drop('seller_business_addresses');
    }
}
