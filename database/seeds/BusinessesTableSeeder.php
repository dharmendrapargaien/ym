<?php

use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('businesses')->insert([ 
            0 => [
                'id'         => 1,
                'title'      => 'Business1',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
            1 => [
                'id'         => 2,
                'title'      => 'Business2',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
            
    	]);
    }
}