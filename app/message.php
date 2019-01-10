<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $table = 'message';
    protected $primaryKey ='message_id';
    public $timestamps=false;

    /** 创建新消息
     * @param $request
     * @param $text  //发送短信内容
     * @param $num   //短信验证码
     * @param $message_status //发送状态 0：成功 1：失败
     * @return bool
     */
    public static function CreateMessage($request,$phone,$text,$num,$message_status){
       $message = new Message();
       $message->message_ip = $request->getClientIp();
       $message->message_gettime = date('Y-m-d H:i:s');
       $message->message_goods_id = url::get_goods($request);
       $message->message_mobile_num = $phone;
       $message->message_order_msg = serialize($request->all());
       $message->messaga_content = $text;
       $message->messaga_code = $num;
       $message->message_status = $message_status;
       if($message->save()){
            return true;
       }else{
           return false;
       }
    }
}
