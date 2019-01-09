<?php
namespace App\channel;

include_once __DIR__.'/../Utils/fastoo_sdk/client/HttpPostClient.php';
include_once __DIR__.'/../Utils/fastoo_sdk/model/SendSingleSmsParm.php';
include_once __DIR__.'/../Utils/fastoo_sdk/model/SendBatchSmsParm.php';
include_once __DIR__.'/../Utils/fastoo_sdk/api/SendSmsApi.php';
class sendMessage{
    public static function send($phone,$text)
    {
        $SendSmsApi=new \SendSmsApi();
        $bean=$SendSmsApi->Submit(env('FASTOO_APIKEY'), $phone, $text);
        if($bean->code==0){
            return true;
        }else{
            return false;
        }
    }
}