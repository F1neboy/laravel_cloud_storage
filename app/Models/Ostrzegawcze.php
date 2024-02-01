<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ostrzegawcze extends Model
{

    protected $fillable = ['user_id', 'file'];
    public $timestamps = false;

    protected $casts = [
        'data' => 'datetime',
    ];
}
