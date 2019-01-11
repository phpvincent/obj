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
       $order_id = $request->input('order_id', 0);
       $message = new Message();
       $message->message_ip = $request->getClientIp();
       $message->message_gettime = date('Y-m-d H:i:s');
       $message->message_goods_id = url::get_goods($request);
       $message->message_order_msg = serialize($request->all());
       $message->messaga_content = $text;
       $message->messaga_code = $num;
       $message->message_order_id = $order_id;
       $message->message_status = $message_status;
       if($message->message_goods_id){ //前台下订单
           $goods = goods::find($message->message_goods_id);
           if(!$goods){
               return false;
           }
           $phones = self::AreaCode($goods->goods_blade_type,$phone);
       }else if($order_id){ //后台消息推送
           $blade = order::select('goods.goods_blade_type','goods.goods_id')
                           ->join('goods','order_goods_id','=','goods_id')
                           ->where('order.order_id',$order_id)
                           ->first();
           if(!$blade){
               return false;
           }
           $message->message_goods_id = $blade->goods_id;
           $phones = self::AreaCode($blade->goods_blade_type,$phone);
       }else{
           return false;
       }
       $message->message_mobile_num = $phones;
       if($message->save()){
            return true;
       }else{
           return false;
       }
    }

    /** 地区区号处理
     * @param $blade_id
     * @param $phone
     * @return string
     */
    private static function AreaCode($blade_id,$phone)
    {
        switch ($blade_id) {
            case '0': //台湾模板
                if('886' == substr($phone,0,3)){
                    $phones = $phone;
                }else{
                    $phones = '886'.$phone;
                }
                break;
            case '1': //简体模板
                if('886' == substr($phone,0,3)){
                    $phones = $phone;
                }else{
                    $phones = '886'.$phone;
                }
                break;
            case '2': //阿联酋模板
                if('971' == substr($phone,0,3)){
                    $phones = $phone;
                }else{
                    $phones = '971'.$phone;
                }
                break;
            case '3': //马来西亚
                if('60' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '60'.$phone;
                }
                break;
            case '4': //泰国
                if('66' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '66'.$phone;
                }
                break;
            case '5': //日本
                if('81' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '81'.$phone;
                }
                break;
            case '6': //印度尼西亚
                if('62' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '62'.$phone;
                }
                break;
            case '7': //菲律宾
                if('63' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '63'.$phone;
                }
                break;
            case '8': //英国
                if('44' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '44'.$phone;
                }
                break;
            case '9': //英国
                if('44' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '44'.$phone;
                }
                break;
            case '10': //美国
                if('1' == substr($phone,0,1)){
                    $phones = $phone;
                }else{
                    $phones = '1'.$phone;
                }
                break;
            case '11': //越南
                if('84' == substr($phone,0,2)){
                    $phones = $phone;
                }else{
                    $phones = '84'.$phone;
                }
                break;
            default: //沙特、卡塔尔、中东地区
                $phones = $phone;
                break;
        }
        return $phones;
    }
}
