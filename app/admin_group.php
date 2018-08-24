<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin_group extends Model
{
    protected $table = 'admin_group';
    protected $primaryKey ='admin_group_id';
    public $timestamps=false;
}
