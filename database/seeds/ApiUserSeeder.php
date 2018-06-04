<?php

use Illuminate\Database\Seeder;

class ApiUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ul-api',
            'email' => 'prog@b2b-logist.com',
            'password' => bcrypt('secret'),
            'api_token' => 'dXNlcjpwYXNzd29yZA==',
        ]);
    }
}
