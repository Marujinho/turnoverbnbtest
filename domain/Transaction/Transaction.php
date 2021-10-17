<?php

namespace Domain\Transaction;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
      'bank_id',
      'bank_user_id',
      'type',
      'check',
      'description',
      'amount',
      'authorization_status',
      'customer_current_balance'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('MMMM DD YYYY, H:mm');
    }


    public function bankUser()
    {
        return $this->belongsTo('Domain\Bank_User\bank_user');
    }
}
