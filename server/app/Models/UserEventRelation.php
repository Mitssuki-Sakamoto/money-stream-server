<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEventRelation extends Model
{
    const INVENTED = 0;
    const NORMAL = 1;
    const MANAGER = 2;
    //
    public $timestamps = false;
    protected $fillable = ['event_id', 'user_id', 'status'];
    public $primaryKey = ['user_id', 'event_id'];
    public $incrementing = false;
}
