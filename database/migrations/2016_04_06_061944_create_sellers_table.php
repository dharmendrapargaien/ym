<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('temporary_password', 10)->nullable();
            $table->string('phone_no',10)->unique();
            $table->string('address',255)->nullable();
            $table->string('city',50)->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('last_login_ip',50)->nullable();
            $table->tinyInteger('gender')->default(1);//1 = M, 2 = F, 3 = Ohter 
            $table->string('avatar',500)->default('default-m-avatar.png');
            $table->tinyInteger('seller_type')->default(0);
            $table->string('confirmation_code', 10)->nullabe();
            $table->tinyInteger('status')->default(0);//created but not active
            $table->rememberToken();
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
        Schema::drop('sellers');
    }
}
