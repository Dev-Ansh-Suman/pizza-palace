<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = ['user_id','session_cart','username','mobile','address_line_1','address_line_2','landmark'];
}
