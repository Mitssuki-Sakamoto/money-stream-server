<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEventRelation extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['event_id', 'user_id', 'manager'];
    public $primaryKey = ['event_id', 'user_id'];
    public $incrementing = false;
}
