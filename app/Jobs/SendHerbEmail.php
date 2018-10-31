<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\order;
use App\url;
class SendHerbEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $order;
    public function __construct(order $order)
    {
        $this->order=$order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $order=$this->order;
         $now_order_id=$order->order_id;
         $email=$order->order_email;
         if(checkdnsrr(explode("@",$email)[1],"MX")==false){
            $order->order_isemail='2';
            $order->save();
            \Log::notice($order->order_email.'-发送邮件ping失败；');
            return;
         }
            $name = 'ZSSHOP';
            $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
           $url=url::where(function($query)use($goods){
               $query->where('url_goods_id',$goods->goods_id);
               $query->orWhere('url_zz_goods_id',$goods->goods_id);
           })->first();
           if($url==null){
            /*$url=new \App\url();
            $url->url_url='xsxxh.xyz';*/
            $url='xsxxh.xyz';
           }else{
            $url=$url->url_url;
           }
           //获取模板名称
           $blade_name=\App\goods::get_success_blade($goods);
           //获取商品图片
            $img = \App\img::where('img_goods_id',$goods->goods_id)->orderBy('img_id','asc')->first();
            $str = $goods->goods_des_html;
            $imgpreg = "/<img src=\"(.+?)\" (.*?)>/";
            preg_match($imgpreg,$str,$imgs);
            $mycount=count($imgs)-2;
            if($img){
                $goods->img = $img->img_url;
            }else if(count($imgs)>0){
                $goods->img = $imgs[$mycount];
            }else{
                $goods->img = '';
            } 
            //拼装订单属性信息
               $order_config=\App\order_config::where('order_primary_id',$order->order_id)->get();
                    if($order_config->count()>0){
                        $config_msg=[];
                        $i=0;
                        foreach($order_config  as  $va){
                          $i++;
                          $config_msg[$i]=[];
                          $orderarr=explode(',',$va['order_config']);
                          foreach($orderarr as $key => $val){
                            $conmsg=\App\config_val::where('config_val_id',$val)->first();
                            $type_name=\App\goods_config::where('goods_config_id',$conmsg['config_type_id'])->first()['goods_config_msg'];
                            $config_msg[$i][$key]= $type_name.':'.$conmsg['config_val_msg'];
                          }
                          //$config_msg[$i]=rtrim($config_msg[$i],'-');
                        }
                          $order->config_msg=$config_msg;
                      }else{
                        $order->config_msg=null;
                      }
             //为订单价格加上货币
             $order->order_currency=\App\currency_type::where('currency_type_id',$order->order_currency_id)->first()['currency_type_name'];
             //发送邮件
           try{
            $flag = \Mail::send($blade_name,['order'=>$order,'goods'=>$goods,'url'=>$url],function($message)use($email){
                $to = $email;
                $message ->to($to)->subject('order notice');
            });
            }catch(\Exception $e){
                $order=\App\order::where('order_id',$now_order_id)->first();
                $order->order_isemail='2';
                $order->save();
                \Log::notice('为'.$order->order_id.'发送邮件方法失败！邮件地址:'.$email.'错误:'.json_encode($e));
                return;
            }
            if(\Mail::failures()==[]){
                $order=\App\order::where('order_id',$now_order_id)->first();
                $order->order_isemail='1';
                $order->save();
                \Log::notice('为'.$order->order_id.'发送邮件成功！邮件地址:'.$email);
            }else{
               //发送失败,更改标记
                $order=\App\order::where('order_id',$now_order_id)->first();
                $order->order_isemail='2';
                $order->save();
                \Log::notice('为'.$order->order_id.'发送邮件失败！邮件地址:'.$email.'错误:'.json_encode(\Mail::failures()));
            }
    }
}
