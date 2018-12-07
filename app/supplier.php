<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $table ='supplier';
    protected $primaryKey = 'supplier_id';
    public $timestamps = false;
}
