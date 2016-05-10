<?php

use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buyers')->insert([
            'name'       => 'david dharmendra',
            'email'      => 'david.dharmendra@ithands.net',
            'password'   => bcrypt('admin'),
            'phone_no'   => '9876543210',
            'status'     => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
    	]);
    }
}