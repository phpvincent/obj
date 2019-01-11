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
            }
            return false;
        }else{
            Message::CreateMessage($request,$phone,$text,$num,1);
            return false;
        }
    }

    /**
     * 发送短信内容
     * @param $blade_id
     * @param $num
     * @return mixed|string
     */
    public static function send_text($blade_id,$num)
    {
        $text="";
        switch ($blade_id) {
            case '0':
               $text="您的驗證碼為：123456，驗證碼有效時間為5分鐘";
               $text = str_replace('123456',$num, $text);
                break;
            case '1':
               $text="您的驗證碼為：123456，驗證碼有效時間為5分鐘";
               $text = str_replace('123456',$num, $text);
                break;
            case '12':
               $text = "رمزالتحقق 123456.تنفع رمزالتحقق تكون خلال داخل خمس الدقائق";
               $text = str_replace('123456',$num, $text);
                break;
            case '14':
               $text = "رمزالتحقق 123456.تنفع رمزالتحقق تكون خلال داخل خمس الدقائق";
               $text = str_replace('123456',$num, $text);
                break;
            case '16':
               $text = "رمزالتحقق 123456.تنفع رمزالتحقق تكون خلال داخل خمس الدقائق";
               $text = str_replace('123456',$num, $text);
                break;
            default:
               $text = "verification code :123456.  only valid within 5 minutes";
               $text = str_replace('123456',$num, $text);
                break;
        }
        return $text;
    }
}