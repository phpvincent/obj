<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_type extends Model
{
    protected $table = 'product_type';
    protected $primaryKey ='product_type_id';
    public $timestamps = false;
}
