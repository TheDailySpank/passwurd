<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyHash extends Model
{
    /**
     * @var mixed
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['sha1', 'password'];
}
