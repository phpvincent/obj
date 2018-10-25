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
         $email=$order->order_email;
         if(checkdnsrr(explode("@",$email)[1],"MX")==false){
            $order->order_isemail='2';
            $order->save();
            \Log::notice($order->order_isemail.'-发送邮件ping失败；');
            return;
         }
         /*try{
                $flag = \Mail::raw('server test'.$order->id,function($message){
                $to = 'wxhwxhwxh@qq.com';
                $message ->to('wxhwxhwxh@qq.com')->subject('order notice');
            });
            }catch(\Exception $e){
             \Log::notice($e);
            }*/
            $name = 'ZSSHOP';
            $goods=\App\goods::where('goods_id',$order->order_goods_id)->first();
           $url=url::where(function($query)use($goods){
               $query->where('url_goods_id',$goods->goods_id);
               $query->orWhere('url_zz_goods_id',$goods->goods_id);
           })->first();
           $blade_name=\App\goods::get_success_blade($goods);
            $flag = \Mail::send($blade_name,['order'=>$order,'goods'=>$goods,'url'=>$url],function($message)use($email){
                $to = $email;
                $message ->to($to)->subject('order notice');
            });
        if(count(\Mail::failures())>0){
            $order->order_isemail='1';
            $order->save();
            \Log::notice('为'.$order->order_id.'发送邮件成功！邮件地址:'.$email);
        }else{
           //发送失败,更改标记,
            $order->order_isemail='2';
            $order->save();
            \Log::notice('为'.$order->order_id.'发送邮件失败！邮件地址:'.$email.'错误:'.json_encode(\Mail::failures()));
        }
    }
}
