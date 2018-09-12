<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class goods_templet extends Model
{
    //指定表名
    protected $table = 'goods_templet';
    protected $primaryKey ='templet_goods_id';
    public $timestamps=false;

    /**
     *  模型关联表
     */
    public function templet_has_show()
    {
        return $this->hasOne('App\templet_show', 'templet_show_id', 'templet_id');
    }
}
