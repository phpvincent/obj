<?php

namespace App\Http\Controllers\admin;

use App\channel\sendMessage;
use App\goods;
use App\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ToolController extends Controller
{
    /** 辅助工具=====发送消息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function send_phone(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.tool.send_message');
        }else if($request->isMethod('post')){
            $region = $request->input('region');
            $tel = $region.$request->input('order_tel');
            if($region == '86'){
                $content = 'zsshop notice:'.$request->input('content');
            }else{
                $content = $request->input('content');
            }
            $data = sendMessage::send($request, $tel, $content, '12345');
            if($data['code'] == 0) {
                return response()->json(['err'=>0,'str'=>'发送成功']);
            }else{
                return response()->json(['err'=>1,'str'=>$data['msg']]);
            }
        }
    }


    /** 辅助工具=====发送邮箱
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function send_mail(Request $request)
    {
        if($request->isMethod('get')){
            return view('admin.tool.send_mail');
        }else if($request->isMethod('post')){
            $content = $request->input('editor2');
            $mail = trim($request->input('send_mail'));
            if(!$content){
                return response()->json(['err'=>1,'str'=>'邮件内容不能为空']);
            }

            $contents = preg_replace('/<img src="/', '<img src="http://hsydzs.cn', $content);
            $mails = explode(',',$mail);
            if(count($mails) == 1){ //判断是否成功拆分（区分中文"，"、","）
                $mails = explode('，',$mail);
            }
            if(count($mails) == 1){ //判断是否为1个邮箱
                $mails = $mail;
            }
            //发送邮件
            try{
                $flag = \Mail::send('view.mail',['test'=>$contents],function($message) use ($mails){
                    $message ->to($mails)->subject('zsshop');
                });
            }catch(\Exception $e){
                return response()->json(['err'=>1,'str'=>'发送失败']);
            }
            return response()->json(['err'=>0,'str'=>'发送成功']);
        }
    }
}
