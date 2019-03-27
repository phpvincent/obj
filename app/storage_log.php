<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class storage_log extends Model
{
    protected $table = 'storage_logs';
    protected $primaryKey ='storage_logs_id';

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
}
