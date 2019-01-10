<?php
namespace App\channel;

use App\message;

include_once __DIR__.'/../Utils/fastoo_sdk/client/HttpPostClient.php';
include_once __DIR__.'/../Utils/fastoo_sdk/model/SendSingleSmsParm.php';
include_once __DIR__.'/../Utils/fastoo_sdk/model/SendBatchSmsParm.php';
include_once __DIR__.'/../Utils/fastoo_sdk/api/SendSmsApi.php';
class sendMessage{
    /**
     * 发送消息
     * @param $request
     * @param $text
     * @param $num
     * @return bool
     */
    public static function send($request,$phone,$text,$num)
    {
        $SendSmsApi=new \SendSmsApi();
        $bean=$SendSmsApi->Submit(env('FASTOO_APIKEY'), $phone, $text);
        if($bean->code==0){
            $message = Message::CreateMessage($request,$phone,$text,$num,0);
            if($message){
                return true;
            }else{
                return false;
            }
        }else{
            Message::CreateMessage($request,$phone,$text,$num,1);
            return false;
        }
    }
}