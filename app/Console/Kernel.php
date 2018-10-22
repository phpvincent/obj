<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
                 $filePath='./time.log';
                 $schedule->call(function(){
                    //在线支付订单超时时间（秒）
                    $maxtime=2400;
                    $herbmaster=\App\herbmaster::where('herbmaster_type','0')->first();
                    if($herbmaster==null||strtotime($herbmaster['herbmaster_msg'])==false||strtotime($herbmaster['herbmaster_msg'])<time()-2592000){
                        $order_ltime=date("Y-m-d H:i:s",time()-2592000);
                    }else{
                        $order_ltime=$herbmaster['herbmaster_msg'];
                    }
                    $orders=\App\order::where(function($query)use($order_ltime){
                        $query->where('order_pay_type','1');
                        $query->where('order_time','>',$order_ltime);
                    })
                    ->orderBy('order_time','asc')
                    ->get();
                    $new_time='';
                    foreach($orders as $k => $v){
                        $order_time=$v->order_time;
                        if($v->order_type==9&&time()-strtotime($order_time)>=2400){
                            //当订单时间已经超过超时时间时，自动删除订单
                            $new_time=$v->order_time;
                            $v->is_del='1';
                            $msg=$v->save();
                            if($msg){
                                \Log::notice($v->order_id.'号订单预付款订单超时'.$maxtime.'被删除');
                            }else{
                                \Log::notice($v->order_id."号订单删除失败");
                            }
                        }
                        
                        }
                        if($new_time==''){
                            if($herbmaster==null){
                                //设置新的订单核审节点
                                $newherbmaster=new \App\herbmaster();
                                $newherbmaster->herbmaster_type='0';
                                $newherbmaster->herbmaster_msg=null;
                                $newherbmaster->save();
                            }else{
                                $herbmaster->herbmaster_msg=date("Y-m-d H:i:s",time());
                                $herbmaster->save();
                            }
                        }else{
                             if($herbmaster==null){
                                $newherbmaster=new \App\herbmaster();
                                $newherbmaster->herbmaster_type='0';
                                $newherbmaster->herbmaster_msg=$new_time;
                                $newherbmaster->save();
                            }else{
                                $herbmaster->herbmaster_msg=$new_time;
                                $herbmaster->herbmaster_type='0';
                                $herbmaster->save();
                         }
                        }
                 })->everyMinute()->evenInMaintenanceMode()->appendOutputTo($filePath);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
