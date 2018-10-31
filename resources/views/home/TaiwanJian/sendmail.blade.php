<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$goods->goods_name}}</title>
</head>
<body >
        
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="2" style="background-image: url();">
          <tbody><tr>
            <td height="21" colspan="3"><table width="800" border="0" align="center" cellpadding="0" cellspacing="2">
              <tbody><tr>
                
                <td width="204" rowspan="3"><img src="{{$url->url}}/images/ydzs.png" width="100"></td>
                <td width="179" height="21">&nbsp;</td>
                <td width="409"><div align="right"><font style="vertical-align: inherit; font-size: 32px;font-weight: bold; color: #F29400;">订单通知</font></div></td>
              </tr>
              <tr>
                <td height="3" colspan="2" background=""></td>
              </tr>
              <tr>
                <td colspan="2"><div align="right"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单编号：</font></font><span style="border-bottom:1px dashed #ccc;z-index:1" t="7" onclick="return false;" data="{{$order->order_single_id}}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;color: red;">{{$order->order_single_id}}</font></font></span></div></td>
              </tr>
            </tbody></table></td>
          </tr>
        
        
          <tr>
            <td height="78" colspan="3"><span class="STYLE1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">亲爱的 [{{$order->order_name}}]</font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                感谢您访问</font></font><a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">&nbsp; ZSshop</font></font></a><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 
                兹通知您，我们已收到您的订单。
            </font></font></span></td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td colspan="3" bgcolor="#EFEFEF"><table width="800" border="0" align="center" cellpadding="0" cellspacing="2">
              <tbody>
                  <tr>
                <td width="322" height="20"><p><font style="vertical-align: inherit;">订单创建时间：</font></p>
                <p><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></p>
             <!--    <p> 星期四，<span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">2018/10/11</font></font></span></p> -->
                <p><font style="vertical-align: inherit;">支付方式：@if($order->order_pay_type=='0')货到付款@else在线支付@endif</font></p>
                <p><font style="vertical-align: inherit;">备注：@if($order->order_remark!=null){{$order->order_remark}}@endif</font></p>
                </td>
                <td width="472" colspan="2" rowspan="4" align="left" valign="top"><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">客户名称：</font></font><span class="STYLE1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_name}}</font></font></span></p>
                  <p>收货地区:&nbsp;{{$order->order_state}} {{$order->order_city}}</p>
                  <p>详细地址:&nbsp;{{$order->order_add}}</p>
                  <p>联系电话:&nbsp;{{$order->order_tel}} </p>
                  @if($order->order_email!=null)
                  <p>联系邮箱:{{$order->order_email}}</p>
                  @endif
                  @if($order->order_zip!=null)
                  <p>ZIP:&nbsp;{{$order->order_zip}} </p>
                  @endif
                </td>
              </tr>
            </tbody></table></td>
          </tr>
        
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td height="20" colspan="3" style=" border-bottom: 1px solid #F29400; color: #F29400;"><p><strong><font style="vertical-align: inherit;">订单详细信息</font></strong></p></td>
          </tr>
          <tr>
            <td height="20" colspan="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单号：</font></font><span style="border-bottom:1px dashed #ccc;z-index:1" t="7" onclick="return false;" data="{{$order->order_single_id}}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit; color: red;">{{$order->order_single_id}}</font></font></span></td>
          </tr>
          <tr>
            <td height="20" colspan="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单创建时间：</font></font><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></td>
          </tr>
          <tr>
            <td height="212" colspan="3">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                <tbody><tr>
                        <td width="209" height="108"  style="vertical-align: top;"><div align="center"><a href="{{$url->url_url}}"><img src="{{$goods->img}}" width="223" height="223"></a></div></td>
                        <td width="585" colspan="2" style=" padding-left: 20px;">
                            <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$goods->goods_name}}</font></font></p>
                           <!--  @if($order->order_cuxiao_id!=null)
                            <script type="text/javascript">
                              var config_msg=config_msg;
                            </script>
                            <p><font style="font-size:14px;color:red">【】</font></p>
                            @endif
                                -->
                            @if($order->config_msg!=null)
                            <div>                
                              @foreach($order->config_msg as $k => $v)        
                                <p class="STYLE1">
                                        <strong>item.{{$k}}</strong><br>
                                        @foreach($v as $key => $val)
                                    <font style="vertical-align: inherit;">                              
                                    {{$val}}</font>@if($key!=count($v)-1)<span>&nbsp;/</span>@endif
                                        @endforeach
                                        <br>
                                </p>
                              @endforeach
                            </div>
                            @endif 
                                <p>
                                    <font style="color:red">{{$order->order_price}}</font> <br>
                                             联系邮箱：
                                
                              <a href="mailto:hyfhdcjn@gmail.com"  >hyfhdcjn@gmail.com</a>
                                </p>
                        </td>
                    </tr>
                            </tbody></table></td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td height="40" colspan="3"><div align="right">
              <p align="right"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">件数：<font style="color:red">{{$order->order_num}}</font> </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                  订单价格：   <font style="color:red">{{$order->order_price}}</font>        </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                  小计：<font style="color:red">{{$order->order_price}}</font></font></font></p>
            </div></td>
          </tr>
          <tr>
            <td height="40" colspan="3"><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">此电子邮件仅用于确认您在</font></font><a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$url->url_url}}</font></font></a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">上的 
                 </font><a><font style="vertical-align: inherit;">订单</font></a><font style="vertical-align: inherit;">。</font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                这是一个自动回复电子邮件，你不必回复。</font><font style="vertical-align: inherit;">如果您还有其他问题，请发送电子邮件至 
        
                 </font></font><a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 
        
                。</font></font></p></td>
          </tr>
          <tr>
            <td height="40" colspan="3"><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">期待您的下次访问。</font></font><br>
            <a href="mailto:hyfhdcjn@gmail.com" ><font  style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$url->url_url}}</font></font></a>
            </p></td>
          </tr>
        </tbody></table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p> 
</body>
</html>