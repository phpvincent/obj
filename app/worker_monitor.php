<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class worker_monitor extends Model
{
    protected $table = 'worker_monitor';
    public $timestamps=false;
     protected $primaryKey ='worker_monitor_id';
}
