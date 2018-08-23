<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods_config extends Model
{
   protected $table = 'goods_config';
    protected $primaryKey ='goods_config_id';
    public $timestamps=false;
}
