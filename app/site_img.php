<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class site_img extends Model
{
    public $table = 'site_imgs';
    protected $primaryKey ='site_img_id';
    public $timestamps=false;
}
