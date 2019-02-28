<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kind_config extends Model
{
    protected $table = 'kind_config';
    protected $primaryKey = 'kind_config_id';
    public $timestamps = false;

    public function vals()
    {
        return $this->hasMany(kind_val::class, 'kind_type_id', 'kind_config_id');
    }
}
