<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('business_code')->unique()->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('added_by')->nullable();
            $table->tinyInteger('status')->default(1);//default every created business is activated
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
        
        Schema::drop('businesses');
    }
}
