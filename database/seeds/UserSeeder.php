<?php

use Illuminate\Database\Seeder;
use Domain\User\User;
use Domain\Bank\Bank;
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
        // $banks = Bank::all();
        // $bank = $banks->first();

        $bank = Bank::first();

        $user = User::create([
            'name' => 'Mr. admin',
            'email' => 'admin@bnb.com',
            'password' => Hash::make('123456789'),
            'current_bank' => $bank->id
        ]);

        $user->banks()->attach($bank->id, ['role' => 'admin' ]);
    }
}
