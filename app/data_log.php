<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_log extends Model
{
    protected $table = 'data_log';
    protected $primaryKey ='data_log_id';
    public $timestamps=false;
}
