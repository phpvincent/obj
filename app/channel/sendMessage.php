<?php
namespace App\channel;

use App\goods;
use App\message;
use App\order;
use App\url;

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
        $order_id = $request->input('order_id', 0);
        $goods_id = url::get_goods($request);
        if($goods_id){ //前台下订单
            $goods = goods::find($goods_id);
            if(!$goods){
                return false;
            }
            $phones = message::AreaCode($goods->goods_blade_type,$phone);
        }else if($order_id){  //后台消息推送
            $blade = order::select('goods.goods_blade_type','goods.goods_id')
                ->join('goods','order_goods_id','=','goods_id')
                ->where('order.order_id',$order_id)
                ->first();
            if(!$blade){
                return false;
            }
            $goods_id = $blade->goods_id;
            $phones = message::AreaCode($blade->goods_blade_type,$phone);
        }else{
            return false;
        }

        //发送短信
        $bean=$SendSmsApi->Submit(env('FASTOO_APIKEY'), $phones, $text);
        if($bean->code==0){
            //记录订单发送信息
            $message = message::CreateMessage($request,$phones,$goods_id,$order_id,$text,$num,0);
            if($message){
                return true;
            }
            return false;
        }else{
            //记录订单发送信息
            message::CreateMessage($request,$phones,$goods_id,$order_id,$text,$num,1);
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
               $text="您正在zsshop網上商城購物，您的驗證碼為：123456，驗證碼有效時間為5分鐘";
               $text = str_replace('123456',$num, $text);
                break;
            case '1':
               $text="您正在zsshop網上商城購物，您的驗證碼為：123456，驗證碼有效時間為5分鐘";
               $text = str_replace('123456',$num, $text);
                break;
            case '12':
               $text = " لقد اشتريت من موقعنا الإلكترونيzsshop رمز التحقق 123456، صلاحية رمز التحقق 5 دقائق. ";
               $text = str_replace('123456',$num, $text);
                break;
            case '14':
               $text = " لقد اشتريت من موقعنا الإلكترونيzsshop رمز التحقق 123456، صلاحية رمز التحقق 5 دقائق. ";
               $text = str_replace('123456',$num, $text);
                break;
            case '16':
               $text = " لقد اشتريت من موقعنا الإلكترونيzsshop رمز التحقق 123456، صلاحية رمز التحقق 5 دقائق. ";
               $text = str_replace('123456',$num, $text);
                break;
            default:
               $text = "you are shopping in Zsshop Mall verification code :123456.  only valid within 5 minutes";
               $text = str_replace('123456',$num, $text);
                break;
        }
        return $text;
    }


}