<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $fillable = ['cart_id','product_id','quantity'];
}
