<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods_type extends Model
{
    protected $table = 'goods_type';
    protected $primaryKey ='goods_type_id';
    public $timestamps=false;
}
