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
    		'email' => 'david.dharmendra@ithands.net',
	        'password' => bcrypt('admin'),
	        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
    	]);

        factory(App\Models\User::class, 50)->create();
    }
}
