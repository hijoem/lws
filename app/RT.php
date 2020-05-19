<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    protected $fillable = [
        'name', 'detail', 'url_ktp', 'url_sk', 'user_id', 'lang', 'lat', 'url_img', 'is_active',
    ];
}
