<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_config extends Model
{
     protected $table = 'order_config';
    protected $primaryKey ='order_config_id';
    public $timestamps=false;
}
