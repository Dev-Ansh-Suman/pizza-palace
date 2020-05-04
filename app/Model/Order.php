<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','session_cart','total_amount','payment_status','payment_method','pay_currency','order_token'];

    public function orderProducts()
    {
        return $this->hasMany('App\Model\OrderProducts');
    }
}
