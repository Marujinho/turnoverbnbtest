<?php

use Illuminate\Database\Seeder;
use Domain\Bank\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::create([
            'name' => 'bnb_bank'
        ]);
    }
}
