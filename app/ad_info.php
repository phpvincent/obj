<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ad_info extends Model
{
    //广告信息模型（广告编号）
    protected $table = 'ad_info';
    protected $primaryKey ='ad_id';
    public $timestamps=false;
}
