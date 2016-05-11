<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_devices', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers');

            $table->tinyInteger('device_type');
            $table->string('reg_id');

            $table->tinyInteger('status')->default(1);

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
        Schema::drop('seller_devices');
    }
}
