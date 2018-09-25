<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods_kind extends Model
{
    protected $table = 'goods';
    protected $primaryKey ='goods_id';
    public $timestamps=false;
}
