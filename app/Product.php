<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'detail', 'price', 'shop_id', 'discount', 'quantity', 'url_img1', 'url_img2', 'url_img3', 'is_active', 'is_published',
    ];
}
