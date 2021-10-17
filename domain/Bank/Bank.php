<?php

namespace Domain\Bank;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banks';

    protected $fillable = [
        'name'
    ];


    public function users()
    {
        return $this->belongsToMany('Domain\User\User')->withPivot('balance', 'role', 'id');
    }
}
