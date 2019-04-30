<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \App\order_notice;
class OrderNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $order;
    protected $order_notice;
    public function __construct($order,$order_notice)
    {
        $this->order=$order;
        $this->order_notice=$order_notice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {       
         $v=$this->order;
         $notice_man=$this->order_notice;
         $phone=$notice_man['order_notice_phone'];
          //$phone=\App\message::AreaCode($blade_type,$notice_man['order_notice_phone']);
          if($v->order_village!=null){
            $village=$v->order_village;
          }else{
            $village='';
          }
          //属性字符拼接
          $config_str='(';
          $order_config=\App\order_config::where('order_primary_id',$v->order_id)->get();
          foreach($order_config as $key => $val){
            $arr=explode(',', $val);
            foreach($arr as $kk => $vv)
            {
              $config_str.=\App\config_val::where('config_val_id',$vv)->first(['config_val_msg'])['config_val_msg'].'-';
            }
            rtrim('-',$config_str);
            $config_str.=',';
          }
          rtrim(',',$config_str);
          $config_str.=')';

          //拼接通知路由
          if($v->order_goods_url==null){
              $back_url='http://alinetrendy.com';
          }else{
              $back_url='http://'.$v->order_goods_url;
          }
          $back_url.='/ch_order_by_send/';
          $goods=\App\goods::where('goods_id',$v->order_goods_id)->first(['goods_name']);
          $end_str=urlencode(gzcompress($v->order_id.'_'.$notice_man['order_notice_id']));
          //gzuncompress(urldecode($pass_str))
          $str="%s :".$v->order_single_id.' ,'  //id
              ."%s :".$v->order_state.'-'.$v->order_city.'-'.$village.'('.$v->order_add.') ,' //地址
              ."%s :".$v->order_tel.' ,' //电话
              ."%s :".$v->order_email.' ,' //邮箱
              ."%s :".$v->order_num.' ,' //件数
              ."%s :".$goods['goods_name']. ' ,'
              ."%s :".$config_str. ' ,';
              /*."%s :".$back_url.'/'.$end_str.'/1 ,'
              ."%s :".$back_url.'/'.$end_str.'/2';*/
          
          switch ($notice_man['order_notice_lan']) {
            case '1':
            //\Log::notice($str);
              $str=sprintf($str,'订单号','地址信息','电话','邮箱','件数','商品名','属性');
              //$str.="通过:(".$back_url.$end_str.'/1)'
                  //."不通过:(".$back_url.$end_str.'/2)';
              break;
            
            default:
              $str=sprintf($str,'order No','area message','tel:','email:','num:','name:','attr:');
              //$str.="pass:(".$back_url.$end_str.'/1)'
                  //."nopass:(".$back_url.$end_str.'/2)';
              break;
          }

        $msg=\App\channel\sendMessage::order_notice($phone,$str);
        if(!$msg){
              $msg=\App\channel\sendMessage::order_notice($phone,$str);
              if($msg){
                $order_notice=\App\order_notice::where('order_notice_id',$notice_man['order_notice_id'])->update(['order_notice_time'=>date('Y-m-d H:i:s',time()),'order_notice_num'=>$notice_man['order_notice_num']+1]);
                if(!$order_notice){
                    \Log::notice($phone."database update failed");
                }
              }else{
                \Log::notice($phone."notice failed-"."order_id:".$v->order_id);
              }
        }
    }
}
