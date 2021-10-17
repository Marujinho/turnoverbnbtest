<?php

use Illuminate\Database\Seeder;
use Domain\User\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Mr. admin',
            'email' => 'admin@bnb.com',
            'password' => Hash::make('123456789'),
            'current_bank' => 1
        ]);

        $user->banks()->attach(1, ['role' => 'admin' ]);
    }
}
