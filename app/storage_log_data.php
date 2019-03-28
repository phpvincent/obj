<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class storage_log_data extends Model
{
    protected $table = 'storage_log_data';
    protected $primaryKey ='storage_log_data_id';
    public $timestamps = false;
}
