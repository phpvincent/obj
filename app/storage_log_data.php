<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class storage_log_data extends Model
{
    protected $table = 'storage_logs';
    protected $primaryKey ='storage_logs_id';
    public $timestamps = false;
}
