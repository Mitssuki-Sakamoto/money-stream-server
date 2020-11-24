<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    public $timestamps = false;
    //
    protected $fillable = [
        'name', 'thumbnail', 'start_date', 'end_date', 'thumbnail', 'description'
    ];

}
