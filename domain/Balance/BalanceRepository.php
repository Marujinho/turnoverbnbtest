<?php

namespace Domain\Balance;

class BalanceRepository {

    public function hasEnoughBalance($balance, $purchase_value)
    {
        return $balance >= $purchase_value;
    }

    public function subtractBalance($balance, $amount)
    {
        return  $balance - $amount;
    }

    public function addBalance($balance, $amount)
    {
        return  $balance + $amount;
    }

    public function updateBalance($user_bank, $new_balance)
    {
        $user_bank->pivot->balance = $new_balance;
        $user_bank->pivot->save();
        return $user_bank;
    }

}
