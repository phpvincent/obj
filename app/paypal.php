<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paypal extends Model
{
    protected $table = 'paypal';
    protected $primaryKey ='paypal_id';
    public $timestamps=false;
}
