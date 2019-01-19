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
    private static $phones=['8618348406783','8615978789522','8613253618257','8618736974521','8618238205232','8618638233841'];
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
                return self::respendData(1,'参数错误');
            }
            $phones = message::AreaCode($goods->goods_blade_type,$phone);
        }else if($order_id){  //后台消息推送
            $blade = order::select('goods.goods_blade_type','goods.goods_id')
                ->join('goods','order_goods_id','=','goods_id')
                ->where('order.order_id',$order_id)
                ->first();
            if(!$blade){
                return self::respendData(1,'参数错误');
            }
            $goods_id = $blade->goods_id;
            $phones = message::AreaCode($blade->goods_blade_type,$phone);
        }else{
            $phones = $phone;
            $goods_id = 0;
        }
        //发送短信
        $bean=$SendSmsApi->Submit(env('FASTOO_APIKEY'), $phones, $text);
        //0 提交成功；101 没有此用户；200 金额不足；203 非法IP地址访问；204 模板不匹配；205 下发号码无效；400 请求参数错误；600 系统异常
        if($bean->code==0){
            //记录订单发送信息
            $message = message::CreateMessage($request,$phones,$goods_id,$order_id,$text,$num,0,$bean->msg);
            if($message){
                return self::respendData($bean->code,$bean->msg);
            }
            return self::respendData(1,'参数错误');
        }else{
            //记录订单发送信息
            message::CreateMessage($request,$phones,$goods_id,$order_id,$text,$num,1,$bean->msg);

            //金额不足，发送短信提醒
            if($bean->code==200){
                self::message_notice();
            }
            return self::respendData($bean->code,$bean->msg);
        }
    }
    public static function message_notice(){
        $nums=implode(',', self::$phones);
        $url='http://api.fastoo.cn/v1/admin/getUserBalance.json';
        $apiKey=['apiKey'=>env('FASTOO_APIKEY')];
        //$result=file_get_contents($url,false,)
        $postdata = http_build_query($apiKey);  
        $options = array( 
                'http' => array(  
                        'method' => 'POST',
                        'header' => 'Content-type:application/x-www-form-urlencoded',
                        'content' => $postdata,
                        'timeout' => 20 // 超时时间（单位:s）
                        )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $data=json_decode($result);
        $SendSmsApi=new \SendSmsApi();
        if(isset($data->msg)&&$data->msg=='ok'){
            \Log::notice('短信服务余额为：'.$data->data->balance);
             if($data->data->balance<8000){
                    $text='短信服务余额不足，余额：'.$data->data->balance;
                    \Log::notice($text);
                    try{
                        $SendSmsApi->Submit(env('FASTOO_APIKEY'), $nums,"zsshop notice:".$text);
                    }catch(\Exception $e){\Log::notice($e);}
                }
        }else{
            \Log::notice('短信服务-通讯余额接口失败');
                $text='短信服务-通讯余额接口失败';
                try{
                     $SendSmsApi->Submit(env('FASTOO_APIKEY'), $nums,"zsshop notice:".$text);
                 }catch(\Exception $e){\Log::notice($e);}
        }      
    }

    /**
     * 返回参数
     * @param $code
     * @param $msg
     * @return mixed
     */
    public static function respendData($code,$msg)
    {
        $data['code'] = $code;
        $data['msg'] = $msg;
        return $data;
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
               $text="您正在zsshop网上商城购物，您的验证码为：123456，验证码有效时间为5分钟";
               $text = str_replace('123456',$num, $text);
                break;
            case '6':
                $text='Anda berbelanja di toko online zsshop, kode verifikasi Anda adalah: 123456, kode verifikasi ini berlaku selama 5 menit.';
                $text=str_replace('123456', $num, $text);
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