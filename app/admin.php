<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
	use \Illuminate\Auth\Authenticatable;
    protected $table = 'admin';
    protected $primaryKey ='admin_id';
    public $timestamps=false;
    public static function getrole($admin_role_id){
        App\role::where()->first();
    }
    //获取所在分组的所有管理员id，true为数组形式返回，false为字符串形式返回
    public static function get_group_ids($id,$type=true){
    	$group=self::where('admin_id',$id)->first()['admin_group'];

    	if($group==null){
    		if($type){
    			return $arr=[$id];
    		}else{
    			return $str="($id)";
    		}
    	}
        if(\App\admin_group::where('admin_group_id',$group)->first()['admin_group_name']=='#全体人员#'){
           $resu=self::get(['admin_id'])->toArray();
        }else{
           $resu=self::where('admin_group',$group)->get(['admin_id'])->toArray();
        }
    	if($type){
    		$arr=[];
    		foreach($resu as $k => $v){
    			$arr[]=$v['admin_id'];
    		}
    		return $resu;
    	}else{
    		$str='';
    		foreach($resu as $k => $v){
    			$str.=$v['admin_id'].',';
    		}
    		$str=rtrim($str,',');
    		return "(".$str.")";
    	}
    }
    public static function get_group($id){
    	$group=self::where('admin_id',$id)->first()['admin_group'];
    	if($group!=null){
    		    	return self::where('admin_group',$group)->get();
    	}else{
    		return $arr=[];
    	}
    }
}
