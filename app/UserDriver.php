<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDriver extends Model
{
    protected $fillable = [
        'no_plat', 'model', 'url_sim', 'url_stnk', 'user_id', 'is_active',
    ];
}
