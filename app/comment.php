<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey ='com_id';
    public $timestamps=false;
    //拼組評論者姓名
    public static function get_fakercom(){
    	$namearr=config('faker.name');
    	$six=[true,false,true,true];
    	$fasx=array_rand($six);
    	if($six[$fasx]){
    		    	$sname=array_rand($namearr,3);
    	}else{
    		    	$sname=array_rand($namearr,2);
    	}
    	$rname='';
    	foreach($sname as $k => $v){
    		$rname.=mb_substr($namearr[$v],$k,1);
    	}
    	return $rname;
    }
    public static function get_phone($num){
    	$fnum='';
    	for ($i=$num-4; $i >0 ; $i--) { 
    		$fnum.='*';
    	}
    	$fnum.=rand(1000,9999);
    	return $fnum;
    }
}
