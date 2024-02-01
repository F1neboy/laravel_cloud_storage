<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informujace extends Model
{
    protected $fillable = ['user_id', 'file'];
    public $timestamps = false;
}
