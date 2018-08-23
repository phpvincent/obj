<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class config_val extends Model
{
     protected $table = 'config_val';
    protected $primaryKey ='config_val_id';
    public $timestamps=false;
}
