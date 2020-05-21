<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'name', 'no_hp', 'no_hp_confirmed', 'user_id', 'url_img', 'url_ktp', 'status', 'birthday', 'address', 'rt', 'community', 'shop', 'driver', 'is_active',
    ];
}
