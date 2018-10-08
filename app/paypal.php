<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paypal extends Model
{
    protected $table = 'paypal';
    protected $primaryKey ='paypal_id';
    public $timestamps=false;
    public static $PAYPAL_TYPE0 = 0; //货到付款
    public static $PAYPAL_TYPE1 = 1; //paypal在线支付
}
