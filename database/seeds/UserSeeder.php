<?php

use Illuminate\Database\Seeder;

// @codingStandardsIgnoreLine
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users') -> insert([
            'name' => 'lethu',
            'email' => 'lethucntt1@gmail.com',
            'password' => bcrypt('123456789'),
            'level' => 1,
            'status' => 'admin',
            ]);
    }
}
