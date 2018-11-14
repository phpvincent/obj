<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class price extends Model
{
    protected $table = 'price';
    protected $primaryKey ='price_id';
    public $timestamps = false;
}
