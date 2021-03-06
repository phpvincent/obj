<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\channel\sendMessage;
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
                   check_pay_order();
                 })->everyMinute()->appendOutputTo($filePath);
                 $schedule->call(function(){
                    get_new_currency_rate();
                   /* \Log::notice('check');*/
                 })->dailyAt('3:00');
                 $schedule->call(function(){
                    get_browse_info(); //处理今日访问数据
                   /* \Log::notice('check');*/
                 })->dailyAt('23:59');
                $schedule->call(function(){
                    today_count_data();  //处理今日统计数据
                    /* \Log::notice('check');*/
                })->dailyAt('23:59');
                 $schedule->call(function(){
                    sendMessage::message_notice();
                 })->hourly();
                 /**
                  * 定时进行仓储数据校对
                  */
                 $schedule->call(function(){
                    auto_storage_check();
                 })->everyThirtyMinutes();
                  /**
                  * 定时监控网站状态
                  */
                 $schedule->call(function(){
                    check_web_status();
                 })->everyTenMinutes();
                 //定时发送订单核审通知
                 $schedule->call(function(){
//                    order_notice();
                 })->everyMinute();
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
