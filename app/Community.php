<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = [
        'name', 'detail', 'url_ktp', 'user_id', 'lang', 'lat', 'url_img', 'is_active',
    ];
}
