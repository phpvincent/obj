<?php
use Illuminate\Http\Request;
if (!function_exists("makeSingleOrder")) {
    function makeSingleOrder()
    {
          $order_date = date('Y-m-d');
 
          //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）
         
          $order_id_main = date('YmdHis') . rand(10000000,99999999);
         
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
    function getclientcity(Request $request)
    { 
      $ip=$request->getClientIp();
        $data = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
        $arr=json_decode($data,$assoc=true);
        return $arr['data'];
  }
}
if (!function_exists("getclientype")) {
    function getclientype()
    {   $user_agent = $_SERVER['HTTP_USER_AGENT'];
         if(stristr($_SERVER['HTTP_USER_AGENT'], 'Android')){//返回值中是否有Android这个关键字
          $a =  explode(" ",$user_agent);
          $b = $a[6].$a[7];
            return $b;
        }else{
            if(stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone')){
                $a =  explode(" ",$user_agent);
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
    $title="<tr style='height:50px;border-style:none;><th border=\"0\" style='height:60px;width:270px;font-size:22px;' colspan='11' >{$title}</th></tr>";
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
   
   
}