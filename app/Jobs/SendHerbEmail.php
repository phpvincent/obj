<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\order;
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
       $flag = \Mail::raw('server test'.$order->id,function($message){
            $to = 'wxhwxhwxh@qq.com';
            $message ->to('wxhwxhwxh@qq.com')->subject('order notice');
        });
        if(\Mail::failures()==[]){
            \Log::notice('发送邮件成功，请查收！');
        }else{
            \Log::notice('发送邮件失败，请重试！');
        }
    }
}
