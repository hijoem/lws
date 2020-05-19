<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name', 'detail', 'url_ktp', 'user_id', 'lang', 'lat', 'url_img', 'is_active', 'status', 'opr_hour',
    ];
}
