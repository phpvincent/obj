<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
	use \Illuminate\Auth\Authenticatable;
    protected $table = 'admin';
    protected $primaryKey ='admin_id';
    public static function getrole($admin_role_id){
        App\role::where()->first();
    }
  
}
