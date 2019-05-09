<?php
use Illuminate\Http\Request;
use App\channel\IpLocation;

if (!function_exists("makeSingleOrder")) {
    function makeSingleOrder()
    {
          $order_date = date('Y-m-d');
 
          //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
         
          $order_id_main = date('YmdHis') . rand(100000,999999);
         
          //订单号码主体长度
         
          $order_id_len = strlen($order_id_main);
         
          $order_id_sum = 0;
         
          for($i=0; $i<$order_id_len; $i++){
         
          $order_id_sum += (int)(substr($order_id_main,$i,1));
         
          }
         
          //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
         
          $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
          return substr($order_id,4);
    }
}
if (!function_exists("getclientcity")) {
    function getclientcity(Request $request,$type=false)
    { 
      set_time_limit(0);
      $ip=$request->getClientIp();
      //$ip='175.158.216.49';
      if($type!==false){
        $ip=$type;
      }
        $IpLocation=new IpLocation();
        $ip = $IpLocation->getlocation($ip);
        if($ip!=null&&$ip!=false&&$ip!=[]&&$ip!=''){
          $iplo['ip']=$ip['ip'];
          $iplo['country']=$ip['country'];
          $iplo['city']=$ip['city'];
          $iplo['region']=$ip['province'];
          $iplo['county']=$ip['city'];
          $iplo['area']=$ip['area'];
          $iplo['isp']=$ip['area'];
          if(strpos($iplo['isp'],"facebook")!==false||strpos($iplo['isp'],"Facebook")!==false||strpos($iplo['isp'],"脸书")!==false){
             $iplo['isp']='脸书';
          }
          return $iplo;
        }
        //根据接口获取
      if($ip!='127.0.0.1'){
        //获取网络来源
         $data = @file_get_contents('https://api.ip.sb/geoip/'.$ip);
         $arr['isp']=json_decode($data,true)['organization'];
      }else{
         $data=true;
         $arr['isp']='本机地址';
      }     
        //判断是否是脸书人员
      if(strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
         $arr['isp']='脸书';
      }
      //获取地区信息
      $area=@file_get_contents('https://freeapi.ipip.net/'.$ip);
      $area=json_decode($area,true);
      $arr['ip']=$request->getClientIp();
      $arr['region']=isset($area[1])?$area[1]:'XX';
      $arr['country']=isset($area[0])?$area[0]:'XX';
      $arr['city']=isset($area[2])?$area[2]:'XX';
      $arr['county']=isset($area[3])?$area[3]:'XX';
      $arr['area']=isset($area[0])?$area[0]:'XX';
     if($data==false||$area==false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
        $wip=\App\vis::first()['vis_ip'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:8.8.8.8', "CLIENT-IP:".$wip));  //构造IP
        curl_setopt($ch, CURLOPT_REFERER, "http://taobao.com.cn/");   //构造来路
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode == 502) {
         $data = @file_get_contents('https://api.ip.sb/geoip/'.$ip);
         $arr['country']=isset(json_decode($data,true)['country'])?json_decode($data,true)['country']:'XX';
         $arr['area']=isset(json_decode($data,true)['continent_code'])?json_decode($data,true)['continent_code']:'XX';
         $arr['region']=isset(json_decode($data,true)['region'])?json_decode($data,true)['region']:'XX';
         $arr['city']=isset(json_decode($data,true)['city'])?json_decode($data,true)['city']:'XX';
         $arr['county']=isset(json_decode($data,true)['county'])?json_decode($data,true)['county']:'XX';
         $arr['isp']=isset(json_decode($data,true)['organization'])?json_decode($data,true)['organization']:'XX';
         $arr['ip']=$request->getClientIp();
         if(strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
           $arr['isp']='脸书';
         }
         return $arr;
        }
          curl_close($ch);
          $arr=json_decode($data,true);
          return $arr['data'];
     }else{
        return $arr;
     }
    return $arr;
        
      /*  if($data==null||$data==false||$data==''){
        $data = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);          
        }
        if($data==null||$data==false||$data==''){
        $data = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);          
        }*/
        /*$arr=json_decode($data,$assoc=true);*/
       /* return $arr['data'];*/
  }
}
if (!function_exists("getclientype")) {
    function getclientype()
    {     
        if(!isset($_SERVER['HTTP_USER_AGENT'])){
          return 'unknown';
        }
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
         if(stristr($_SERVER['HTTP_USER_AGENT'], 'Android')){//返回值中是否有Android这个关键字
          $a =  explode(" ",$user_agent);
          if(!isset($a[6])||!isset($a[7])){
                  return 'unknown';
                }
          $b = $a[6].$a[7];
            return 'Android';
            return $b;
        }else{
            if(stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone')){
                $a =  explode(" ",$user_agent);
                if(!isset($a[3])){
                  return 'unknown';
                }
                return 'iPhone';
                return $a[3];
            }elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                 return 'iPad';
            }else{
                return 'pc';
            }
        }
  }
}
if (!function_exists("getclientlan")) {
    function getclientlan(){
       if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
          $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
          $lang = substr($lang, 0, 5);
          if (preg_match('/zh-cn/i',$lang)) {
              $lang = '简体中文';
          } else if (preg_match('/zh/i',$lang)) {
              $lang = '繁体中文';
          } else {
              $lang = 'English';
          }
          return $lang;
      } else {
          return 'unknow';
      }
    }
}
if (!function_exists("curl_get_send")) {
    function curl_get_send($no)
    {
           $testurl = "https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?cb=jQuery110204759692032715892_1499865778178&appid=4001&com=&nu=".$no; 
           $ch = curl_init();    
           curl_setopt($ch, CURLOPT_URL, $testurl);    
            //参数为1表示传输数据，为0表示直接输出显示。  
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
            //参数为0表示不带头文件，为1表示带头文件  
           curl_setopt($ch, CURLOPT_HEADER,0);  
           $output = curl_exec($ch);   
           curl_close($ch);   
           return $output;  
  }
}
if (!function_exists('out_excil')){
      function out_excil($datas,$titlename,$title,$filename){ 

    $title="<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='".count($titlename)."' >{$title}</th></tr>";
    $endname="<tr>";
    foreach($titlename as $v){
      $endname.="<th style='width:70px;' >".$v."</th>";
    }
    $endname.="</tr>";
    set_time_limit(0);
    $counts=count($datas);

    $pg=ceil($counts/10000);
    $num=0;
   
       $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>"; 

      $str .="<table border=1><head>".$endname."</head>"; 

      $str .= $title; 
      echo $str;
      $str="";
      ob_start();
          foreach ($datas as $key=> $rt ) 

          { 

          $str .= "<tr>"; 
          
              foreach ( $rt as $k => $v ) 

              { 
              $str .= "<td>{$v}</td>"; 

              } 

          $str .= "</tr>\n"; 
/*            unset($datas[$key]);*/
          echo $str;
          $str="";
           $num+=1;
           if($num>=10000){
                ob_flush();
                flush();
                   $num=0;
                   break;
          }  
     
       }
       $str="";
      $str .= "</table></body></html>"; 

      header( "Content-Type: application/vnd.ms-excel; name='excel'" );

      header( "Content-type: application/octet-stream" );

      header( "Content-Disposition: attachment; filename=".$filename ); 

      header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" ); 

      header( "Pragma: no-cache" ); 

      header( "Expires: 0" ); 

      echo $str;
      ob_end_flush();
      //exit( $str ); 

      }
   if (!function_exists('turn_pic')){
      function turn_pic($dir){ 
        /*php 给图片加灰色透明效果*/
        $imfile = $dir;//原图 
        $origim = imagecreatefromjpeg($imfile);//从 JPEG 文件或 URL 新建一图像 
        $w=imagesx($origim);//原图宽度 
        $h=imagesy($origim);//原图高度 
        $newimg = imagecreatetruecolor($w, $h);//返回一个图像标识符，代表了一幅大小为    x_size 和 y_size 的黑色图像。imagecreatetruecolor//      
        $color=imagecolorallocatealpha($newimg,0,0,0,75);//为一幅图像分配颜色 + alpha; 和 imagecolorallocate() 相同，但多了一个额外的透明度参数 alpha，其值从 0 到 127。0 表示完全不透明，127 表示完全透明。  
        imagecolortransparent($newimg,$color);//将某个颜色定义为透明色 
        imagefill($newimg,0,0,$color);//区域填充;resource $image , int $x , int $y , int $color  
        imagecopy($origim,$newimg, 0,0, 0, 0,$w, $h);//拷贝图像的一部分;将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。 
        imagejpeg($origim, 'business/images/2.jpg');//输出图象到浏览器或文件。;resource $image [, string $filename [, int $quality ]] 
      }
    }

}
 if (!function_exists('check_pay_order')){
      function check_pay_order(){ 
            //在线支付订单超时时间（秒），小于2592000
                    $maxtime=10800;
                    $herbmaster=\App\herbmaster::where('herbmaster_type','0')->first();
                    if($herbmaster==null||strtotime($herbmaster['herbmaster_msg'])==false||strtotime($herbmaster['herbmaster_msg'])<time()-2592000){
                        $order_ltime=date("Y-m-d H:i:s",time()-2592000);
                    }else{
                        $order_ltime=$herbmaster['herbmaster_msg'];
                    }
                    $orders=\App\order::where(function($query)use($order_ltime){
                        $query->where('order_type','9');
                        $query->where('order_time','>',$order_ltime);
                    })
                    ->orderBy('order_time','asc')
                    ->get();
                    $new_time='';
                    foreach($orders as $k => $v){
                        $order_time=$v->order_time;
                        if(time()-strtotime($order_time)>=$maxtime){
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
                              if(strtotime($herbmaster->herbmaster_msg)<time()-2592000){
                                $herbmaster->herbmaster_msg=date("Y-m-d H:i:s",time()-$maxtime);
                                $herbmaster->save();
                              }
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
      }
}
 if (!function_exists('get_user_new_type')){
      function get_user_new_type(){ 
        $agent       = strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'unknow');

        $device_type = 'unknown';

        $device_type = (strpos($agent, 'windows nt')) ? 'pc' : $device_type;

        $device_type = (strpos($agent, 'iphone')) ? 'iPhone' : $device_type;

        $device_type = (strpos($agent, 'ipad')) ? 'iPad' : $device_type;

        $device_type = (strpos($agent, 'android')) ? 'Android' : $device_type;

        return $device_type;
      }
  }
 if (!function_exists('get_new_currency_rate')){
      function get_new_currency_rate(){ 
             $opts = array(
                'http'=>array(
                'method'=>'GET',
                'timeout'=>30,//单位秒
                )
             );
            $currencys=\App\currency_type::get();
            foreach($currencys as $k => $v){
                 $from=$v->currency_english_name;
                 $cnt=0;
                 $to='CNY';
                 if($v->exchange_rate<0.01){
                  $url='http://api.k780.com/?app=finance.rate&scur='.$from.'&tcur='.$to.'&appkey=37627&sign=7cbd07d00c92cf942fb7c3d4b4bc4d7b';
                  while($cnt<3 && ($bb=file_get_contents($url, false, stream_context_create($opts)))===FALSE) $cnt++;
                 }else{
                  $url='http://op.juhe.cn/onebox/exchange/currency?key=29e07833e480a84e60052a25d13e0ffa&from='.$from.'&to='.$to;
                  while($cnt<3 && ($bb=file_get_contents($url, false, stream_context_create($opts)))===FALSE) $cnt++;
                 }
                 $res=json_decode($bb,true);
                 if($v->exchange_rate>=0.01&&($res==false||!isset($res['error_code'])||$res['error_code']!='0')){
                  //接口返回错误
                    $reason=isset($res['reason'])?$res['reason']:'';
                    \Log::notice(\Carbon\Carbon::now().'-'.$url.'汇率获取失败,'.$reason);
                 }elseif($v->exchange_rate<0.01&&($res==false||!isset($res['success'])||$res['success']!='1')){
                    $reason=isset($res['msg'])?$res['msg']:'';
                    \Log::notice(\Carbon\Carbon::now().'-'.$url.'汇率获取失败,'.$reason);
                 }else{
                   if($v->exchange_rate<0.01){
                      $cur=$res['result']['rate'];
                    }else{
                      foreach($res['result'] as $key => $val){
                          if($val['currencyF']==$from){
                              $cur=$val['exchange'];
                              break;
                          }else{
                              $cur=false;
                          }
                      }
                    }
                    if($cur!=false&&abs($cur-$v->exchange_rate)<0.15*($v->exchange_rate)){
                        $old_rate=$v->exchange_rate;
                        $v->exchange_rate=$cur;
                        $v->save();
                        \Log::notice(\Carbon\Carbon::now().'-'.$from."汇率调整成功，".$old_rate."~".$cur);
                    }else{
                         $old_rate=$v->exchange_rate;
                        \Log::notice(\Carbon\Carbon::now().'-'.$from."汇率调整失败，".$old_rate."~".$cur);
                    }
                 }
            }
      }
  }

if (!function_exists('operation_log')){
    function operation_log($ip,$log,$data_json=false){
      try{
        $admin_name=Auth::user()->admin_name;
      }catch(\Exception $e){
        $admin_name='system';
      }
    $log_content = '[' . date('Y-m-d H:i:s') . '][IP:'. $ip .']管理员'.$admin_name .' '.$log. "\r\n";
        if($data_json){
            $log_content .= 'JSON数据：'. $data_json ."\r\n";
        }
        try{
            $name = date('Y-m-d').'OperationLog.log';
            $filepath = __DIR__.'/../storage/logs/beiGuo/' . $name;
            if(file_exists($filepath)){
                @file_put_contents($filepath, $log_content, FILE_APPEND);
            }else{
                @file_put_contents($filepath, $log_content);
            }
        }catch(\Exception $e){
            \Log::notice('操作日志记录报错--'.$e);
        }
    }
}

if (!function_exists('get_browse_info')){
    function get_browse_info(){
        $redis = \App\channel\Rediss::getInstance();
        if($redis->exists('today_time')){
            $redis->del('today_time');
        }
//       $start = date('Y-m-d',time()-24*3600).' 00:00:00';
//       $end = date('Y-m-d').' 00:00:00';
       $start = date('Y-m-d',time()).' 00:00:00';
       $start = date('Y-m-d H:i:s',strtotime($start)-60);
       $start_time = date('Y-m-d',time()-9*24*3600).' 00:00:00';
       $end_time = date('Y-m-d',time()-8*24*3600).' 00:00:00';
       try{
           $data = \App\vis::visBrowseCount($start); //获取昨天浏览量、购买量、下单量
           \App\data_log::whereBetween('data_time',[$start_time,$end_time])->delete();//删除7日前数据
           $name = date('Y-m-d',time()-30*24*3600).'OperationLog.log';
           $filepath = __DIR__.'/../storage/logs/beiGuo/' . $name;
           if(file_exists($filepath)){
               @unlink($filepath); //删除7日前操作日志
           }
       }catch(\Exception $e){
           \Log::notice('操作日志记录报错--'.$e);
       }


    }
}

if (!function_exists('price_format')) {
    function price_format($price){
        if (!is_numeric($price)) {
            return false;
        }
        $num = explode('.', $price);

        return number_format($num[0]);
    }
}

//商品属性 笛卡尔积函数
if (!function_exists('descartes')) {
    function descartes($arr,$str = array()){
        //去除第一个元素
        $first = array_shift($arr);
        //判断是否是第一次进行拼接
        if(count($str) > 1) {
            foreach ($str as $k => $val) {
                foreach ($first as $key => $value) {
                    //最终实现的格式 1,3,76
                    //可根据具体需求进行变更
                    $str2[] = $val.','.$value;
                }
            }
        }else{
            foreach ($first as $key => $value) {
                //最终实现的格式 1,3,76
                //可根据具体需求进行变更
                $str2[] = $value;
            }
        }

        //递归进行拼接
        if(count($arr) > 0){
            $str2 = descartes($arr,$str2);
        }
        //返回最终笛卡尔积
        return $str2;
    }
}
/**
 * 系统定时校准数据
 */
if (!function_exists("auto_storage_check")) {
    function auto_storage_check()
    {     
        //数据校准
        $msg=\App\storage_check::storage_center(true);
        
        //添加补货单日志
        operation_log('system','进行订单数据校准操作');
  }
}
/**
 * 网站状态监控
 */
if (!function_exists("check_web_status")) {
    function check_web_status()
    {      
        $mails='wxhwxhwxh@qq.com';
        $url='http://'.\App\url::where('url_site_id','>',0)->orderBy('url_id','desc')->first(['url_url'])['url_url'];
        $goods_url=$url.'/index/site_goods/'.\App\goods::where('is_del',0)->orderBy('goods_id','desc')->first(['goods_id'])['goods_id'];
        //监控站点页面
        $recode=curl_code($url);

        if($recode['code']!=200){
          //记录日志
                \Log::notice('站点页面访问异常，地址:'.$url.'响应码：'.$recode['code'].'、响应内容：'.$recode['msg']);
          //发送邮件
          try{
                $flag = \Mail::send('view.mail',['test'=>'站点页面访问异常，地址:'.$url.'<br/>响应码：'.$recode['code'].'、响应内容：'.$recode['msg']],function($message) use ($mails){
                    $message ->to($mails)->subject('zsshop');
                });
            }catch(\Exception $e){
                \Log::notice('服务监控邮件发送失败,url:'.$url.'响应码：'.$recode['code'].'、响应内容：'.$recode['msg']);
            }
          //发送短信
          $text='站点访问异常，地址:'.$url.',响应码：'.$recode['code'];
          \App\channel\sendMessage::send_err_notice($text);
        }else{
          //echo '访问正常，url:'.$url.'响应码：'.$recode['code'].'、响应内容：'.$recode['msg'].'<br/>';
          \Log::notice('访问正常，url:'.$url.',响应码：'.$recode['code']);
        }
        //监控商品页面
        $gocode=curl_code($goods_url); 
         if($gocode['code']!=200){
          //记录日志
                \Log::notice('单品页面访问异常，地址:'.$goods_url.'响应码：'.$gocode['code'].'、响应内容：'.$gocode['msg']);
          //发送邮件
          try{
                $flag = \Mail::send('view.mail',['test'=>'单品页面访问异常，地址:'.$goods_url.'<br/>响应码：'.$gocode['code'].'、响应内容：'.$gocode['msg']],function($message) use ($mails){
                    $message ->to($mails)->subject('zsshop');
                });
            }catch(\Exception $e){
                \Log::notice('服务监控邮件发送失败,url:'.$goods_url.'响应码：'.$gocode['code'].'、响应内容：'.$gocode['msg']);
            }
          //发送短信
          $text='单品页面访问异常，地址:'.$goods_url.',响应码：'.$gocode['code'];
          \App\channel\sendMessage::send_err_notice($text);
         }else{
          //echo '访问正常，url:'.$url.'响应码：'.$recode['code'].'、响应内容：'.$recode['msg'].'<br/>';
          \Log::notice('访问正常，url:'.$goods_url.',响应码：'.$gocode['code']);
         }
    }
}

if (!function_exists("curl_code")) {
    function curl_code($url)
    {     
        $ch = curl_init (); 
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 20); 
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        curl_setopt($ch, CURLOPT_NOBODY, FALSE); 
        #curl_setopt( $ch, CURLOPT_POSTFIELDS, "username=".$username."&password=".$password ); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $msg=curl_exec($ch); 
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
        return ['code'=>$httpCode,'msg'=>$msg];
  }
}
if (!function_exists("order_notice")) {
    function order_notice()
    {     
        $date=date("Y-m-d H:i:s",time()-5400);
        $orders=\App\order::where(function($query){
          $query->where('order_type',0);
          $query->where('is_del',0);
          $query->where('order_time','>','2019-4-29 12:00:00');
        })
        ->where(function($query)use($date){
          $query->whereNull('order_notice_send_time');
          $query->orWhere('order_notice_send_time','<',$date);
        })
        ->get();

        foreach($orders as $k => $v){
          $goods=\App\goods::select('goods_blade_type','goods_name')->where('goods_id',$v->order_goods_id)->first();
          $blade_type=$goods['goods_blade_type'];
          $lan=\App\goods::get_lan($blade_type);
          //$lan_arr=array_flip(\App\admin::$LANGUAGES);
          //$lan=$lan_arr[$lan];
         
          $order_notice=\App\order_notice::where([['order_notice_lan',$lan],['order_notice_status',1]])->get()->toArray();
          $notice_mans=$order_notice;
          foreach($order_notice as $keys =>$vals ){
            $date=date('Y-m-d H:i:s',time());
            if(strtotime(date('Y-m-d').' '.$vals['order_notice_start'])>time()||strtotime(date('Y-m-d').' '.$vals['order_notice_end'])<time()){
              unset($notice_mans[$keys]);
            }
          }
          $count=count($notice_mans);
          if($count==0){
            return;
          }else if($count==1){
            $notice_man=$notice_mans[0];
          }else{
            $notice_man=$notice_mans[mt_rand(0,$count-1)];
          }
          try{
            $mailnotice=App\Jobs\OrderNotice::dispatch($v,$notice_man);
            
          }catch(\Exception $e){
            \Log::notice(json_encode($e));
          };
          //try{$mailnotice=App\Jobs\OrderNotice::dispatch($phone,$str);}catch(\Exception $e){\Log::notice(json_encode($e));};
        }
    }
}

//curl 访问post请求
if (!function_exists("curl_post")) {
    function curl_post($url,$data=[])
    {
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);//设置为1或true时，是post请求，
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));//post请求参数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不直接展示数据
        $output = curl_exec($ch);
        curl_close($ch);
        $out = json_decode($output);
        return $out;
    }
}