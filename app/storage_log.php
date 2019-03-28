<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class storage_log extends Model
{
    protected $table = 'storage_log';
    protected $primaryKey ='storage_log_id';

    /**
     * 记录仓库日志
     * @param $storage_id
     * @param $order_id
     * @param $storage_status
     * @param $storage_order_status
     * @return bool
     */
    public static function CreateStorageLog($storage_id,$order_id,$storage_status,$storage_order_status)
    {
        $storage_log = new storage_log();
        $storage_log->storage_id = $storage_id;
        $storage_log->storage_order_id = $order_id;
        $storage_log->storage_status = $storage_status;
        $storage_log->storage_order_status = $storage_order_status;
        if($storage_log->save()){
            return true;
        }
        return false;
    }
    /**
     * 操作记录表插入入口
     * @param  [array] $storage_log [主表数据]
     * @param  array  $data        [从表数据，一维数据]
     * @return [type]              [description]
     */
    public static function insert_log(Array $storage_log,$data=[]){
        $arr=[];
        $allowarr=['storage_log_type','storage_log_operate_type','is_danger'];
        foreach($allowarr as $k => $v){
            if(!isset($storage_log[$v])){
                return false;
            }
            $arr[$v]=$storage_log[$v];
        }
        $unimportant=['storage_log_admin_id'=>0];
        foreach($unimportant as $k => $v){
            if(!isset($storage_log[$k])){
                $arr[$k]=$v;
            }else{
                $arr[$k]=$storage_log[$k];
            }
        }
        $storage_log=self::insert($arr);
        if($data!=null){
            if(is_array($data)){
                if(count($data)!=count($arr,1)) return false;
                foreach($data as $k => $v){
                    $msg=\App\storage_log_data::insert(['storage_log_primary_id'=>$storage_log->storage_log_id,'storage_log_data'=>$v]);
                }
            }else{
                $msg=\App\storage_log_data::insert(['storage_log_primary_id'=>$storage_log->storage_log_id,'storage_log_data'=>$data]);
            }
        }
        if($msg) return true;
        return false;
    }
}
