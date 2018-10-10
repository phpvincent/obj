<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class currency_type extends Model
{
    protected $table = 'currency_type';
    protected $primaryKey ='currency_type_id';
    public $timestamps=false;
    public static $CURRENCY_TYPE = ['HKD','TWD','USD','SGD','THD','EUR','JPY','PHP','GBP','MYR'];
}
