<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods extends Model
{
    protected $table = 'goods';
    protected $primaryKey ='goods_id';
    public $timestamps=false;
    public static function comment(){
    	return $this->hasMany('App\comment','com_goods_id','goods_id');
    }
}
