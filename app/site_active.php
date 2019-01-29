<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class site_active extends Model
{
    public $table = 'site_actives';
    protected $primaryKey ='site_active_id';
    public $timestamps=false;
}
