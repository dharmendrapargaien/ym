<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'david dharmendra',
            'email'      => 'david.dharmendra@ithands.net',
            'password'   => bcrypt('admin'),
            'phone_no'   => '9876543210',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
    	]);

        factory(App\Models\User::class, 50)->create();
    }
}
