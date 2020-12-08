<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    const API_KEY_LENGTH = 32;
    const INVENT_CODE_LENGTH = 20;
    public static function generateApiKey(){
        return Str::random(self::API_KEY_LENGTH);
    }
    public static function generateInventCode()
    {
        return Str::random(self::INVENT_CODE_LENGTH);
    }

    public $timestamps = false;
    //
    protected $fillable = [
        'name', 'invent_code', 'api_key', 'thumbnail'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_key',
    ];

}
