<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id','product_id','quantity'];

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }
}
