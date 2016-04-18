<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('temporary_password', 10)->nullable();
            $table->string('phone_no',12)->unique();
            $table->string('address',255)->nullable();
            $table->string('city',50)->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('last_login_ip',50)->nullable();
            $table->tinyInteger('gender')->default(1);//1 = M, 2 = F, 3 = Ohter 
            $table->string('avatar',500)->default('default-m-avatar.png');
            $table->tinyInteger('buyer_type')->default(0);
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
        Schema::drop('buyers');
    }
}
