<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spend extends Model
{
    //花费模型
    protected $table = 'spend';
    protected $primaryKey ='spend_id';
    public $timestamps=false;

    /**
     *  模型关联表
     */
    public function currency_has_spend()
    {
        return $this->hasOne('App\currency_type', 'currency_type_id', 'spend_currency_id');
    }

}
