<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zakazu extends Model
{
    protected $fillable = ['user_id', 'file'];
    public $timestamps = false;
}
