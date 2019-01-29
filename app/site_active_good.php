<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class site_active_good extends Model
{
    public $table = 'site_active_goods';
    protected $primaryKey ='site_active_good_id';
    public $timestamps=false;
}
