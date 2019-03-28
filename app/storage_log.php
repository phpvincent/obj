<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class storage_log extends Model
{
    protected $table = 'storage_log';
    protected $primaryKey ='storage_log_id';

    /**
     * 操作记录表插入入口
     * @param  [array] $storage_log [主表数据]
     * @param  array  $data        [从表数据，一维数据]
     * @return [type]              [description]
     */
    public static function insert_log(Array $storage_log,$data=[]){
        $arr=[];
        $allowarr=['storage_log_type','storage_log_operate_type','is_danger'];
        $unimportant=['storage_log_admin_id'=>0];
        foreach($unimportant as $k => $v){
            if(!isset($storage_log[$k])){
                $arr[$k]=$v;
            }else{
                $arr[$k]=$storage_log[$k];
            }
        }
        foreach($allowarr as $k => $v){
            if(!isset($storage_log[$v])){
                return false;
            }
            $arr[$v]=$storage_log[$v];
        }
        $arr['created_at'] = date('Y-m-d H:i:s');
        $storage_log_id=self::insertGetId($arr);
        if($data!=null){
            if(is_array($data)){
                if(count($data)!=count($arr,1)) return false;
                foreach($data as $k => $v){
                    $msg=\App\storage_log_data::insert(['storage_log_primary_id'=>$storage_log_id,'storage_log_data'=>$v]);
                }
            }else{
                $msg=\App\storage_log_data::insert(['storage_log_primary_id'=>$storage_log_id,'storage_log_data'=>$data]);
            }
        }
        if($msg) return true;
        return false;
    }
}
