<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods_kind extends Model
{
    protected $table = 'goods_kind';
    protected $primaryKey ='goods_kind_id';
    public $timestamps=false;
}
