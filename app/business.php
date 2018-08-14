<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class business extends Model
{
    protected $table = 'business';
    protected $primaryKey ='bus_id';
    public $timestamps=false;
    public static function  checkserver(Request $request){
    	$url=$_SERVER['SERVER_NAME'];
    	$data=self::where('bus_url',$url)->first();
    	if($data==null){
    		return false;
    	}
    	if($data!=null){
    		if($data->bus_isuse!='1'){
    			return 'notallow';
    		}
    		$bus_type=$data->bus_type;
    		switch ($bus_type) {
    			case '1':

    			return 'home.business.1';
    				break;
    			
    			default:
    				# code...
    				break;
    		}
    	}
    }
}
