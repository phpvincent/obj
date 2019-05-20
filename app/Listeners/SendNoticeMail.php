<?php

namespace App\Listeners;

use App\Events\OrderNotice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\SendHerbEmail;
class SendNoticeMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderNotice  $event
     * @return void
     */
    public function handle(OrderNotice $event)
    {
        $order=$event->order;
        if(filter_var($order->order_email,FILTER_VALIDATE_EMAIL)!=false){
                    //推送到发送邮件队列
                            if(config('queue')['default']!='sync'){
                                  try{$emailsend=SendHerbEmail::dispatch($order);}catch(\Exception $e){\Log::notice(json_encode($e));};
                                  \App\order::where('order_id',$order->order_id)->update(['order_isemail'=>'1']);
                                  \Log::notice($order['order_email']."是合法邮箱，推送至队列中");
                            }else{
                                \Log::notice('队列驱动为同步驱动，取消发送邮件');
                            }
                            
        }else{
                    //邮件不合法,不发送
                            \App\order::where('order_id',$order->order_id)->update(['order_isemail'=>'0']);
                            \Log::notice($order['order_email']."不是合法邮箱，取消推送至队列中");
        }
    }
}
