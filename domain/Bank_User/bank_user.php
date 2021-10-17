<?php

namespace Domain\Bank_User;

use Illuminate\Database\Eloquent\Model;

class Bank_user extends Model
{
    protected $table = 'bank_user';

    protected $fillable = [
      'role',
      'bank_id',
      'user_id',
      'balance'
    ];

    public function transaction()
    {
        return $this->belongsToMany('Domain\Transaction\Transaction');
    }
}
