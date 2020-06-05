<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
                'name' => 'Juan Fernando',
                'last_name' => 'Dederlé Baena',
                'email' => 'jfdeder@gmail.com',
                'password' => Hash::make('qwerqwer')
            ]);
        \App\User::create([
                'name' => 'Qwer Qwer',
                'last_name' => 'Adsf Asdf',
                'email' => 'q@q',
                'password' => Hash::make('qwerqwer')
        ]);
    }
}
