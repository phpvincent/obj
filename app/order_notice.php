<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_notice extends Model
{
    protected $table = 'order_notice';
    protected $primaryKey ='order_notice_id';
    public $timestamps=false;
}
