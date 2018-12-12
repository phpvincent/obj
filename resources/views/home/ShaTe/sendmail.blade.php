<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$goods->goods_name}}</title>
    <style type="text/css">
      a:hover{
        color: #bcd4ec !important;
        border-radius: 5%;
      }
    </style>
    <style>
        *{
            text-align: right;
        }
        </style>
</head>
<body >
        
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="2" style="background-image: url();">
          <tbody><tr>
            <td height="21" colspan="3"><table width="800" border="0" align="center" cellpadding="0" cellspacing="2">
              <tbody><tr>
                
                <td width="204" rowspan="3"><img  style="border: 1px solid #F29400; border-radius: 8%;" src="http://{{$url}}/images/ydzs.png" width="100"></td>
                <td width="179" height="21">&nbsp;</td>
                <!-- <td width="409"><div align="right"><font style="vertical-align: inherit; font-size: 32px;font-weight: bold; color: #F29400;">订单通知</font></div></td> -->
              </tr>
              <tr>
                <td height="3" colspan="2" background=""></td>
              </tr>
              <tr>
                <!-- <td colspan="2"><div align="right"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单编号：</font></font><span style="border-bottom:1px dashed #ccc;z-index:1" t="7" onclick="return false;" data="{{$order->order_single_id}}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;color: red;">{{$order->order_single_id}}</font></font></span></div></td> -->
              </tr>
            </tbody></table></td>
          </tr>
          <tr>
          <td ><div style="text-align:  center;"><font style="vertical-align: inherit; font-size: 32px;font-weight: bold; color: #F29400;"> اشعار الطلب </font></div></td>
          </tr>
        
          <tr style="
          color: #666;
          font-size: 14px;
          line-height: 24px;">
            <td height="78" colspan="3"><span class="STYLE1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> [{{$order->order_name}}]عزيزنا العميل </font></font><br>
                <!-- 非常感谢您在我们网上商店从开始的订单。我们将尽快执行您的订单号为<b><u>{{$order->order_single_id}}</u></b>的订单。 -->
                نشكركم علي التسوق والطلب  من موقعنا الالكتروني<a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a>   
سنقوم في الحال بتنفيذ الطلب  

            </font></font></span></td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <!-- <tr>
            <td colspan="3" bgcolor="#EFEFEF"><table width="800" border="0" align="center" cellpadding="0" cellspacing="2">
              <tbody>
                <tr>
                <td width="322" height="20"><p><font style="vertical-align: inherit;">订单创建时间：</font></p>
                <p><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></p>
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
          </tr> -->
          <tr>
              <td colspan="3" style="
              color: #666;
              font-size: 14px;
              line-height: 28px;">
                <div style="width:70%;margin:0 auto;    text-align: center;">
                    <p style="margin:0"><font style="vertical-align: inherit;"> {{$order->order_time}}:وقت الطلب</font></p>
                    <!-- <p style="margin:0"><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></p> -->
                    <p style="margin:0"><font style="vertical-align: inherit;"> @if($order->order_pay_type=='0')الدفع عبر الانترنت  @else الدفع عند الاستلام @endif :طريقة الدفع </font></p>
                    <p style="margin:0"><font style="vertical-align: inherit;"> @if($order->order_remark!=null){{$order->order_remark}}@endif :ملاحظات </font></p>
                </div>
                <div style="width:70%;margin:0 auto;    text-align: center;">
                  <p style="margin:0">&nbsp;{{$order->order_state}} {{$order->order_city}} :منطقه الاستلام </p>
                  <p style="margin:0">&nbsp;{{$order->order_add}} : العنوان بالتفصيل</p>
                  <p style="margin:0">&nbsp;{{$order->order_tel}}: رقم الهاتف </p>
                  @if($order->order_email!=null)
                  <p style="margin:0">{{$order->order_email}} :عنوان البريد الالكتروني </p>
                  @endif
                  @if($order->order_zip!=null)
                  <p style="margin:0">&nbsp;{{$order->order_zip}} :الرمز البريدي </p>
                  @endif
              </div>
              </td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td height="20" colspan="3" style=" border-top: 1px solid #F29400; color: #F29400;"><p style="    text-align: center;"><strong><font style="vertical-align: inherit;">تفاصيل المنتج</font></strong></p></td>
          </tr>
          <!-- <tr>
            <td height="20" colspan="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单号：</font></font><span style="border-bottom:1px dashed #ccc;z-index:1" t="7" onclick="return false;" data="{{$order->order_single_id}}"><font style="vertical-align: inherit;"><font style="vertical-align: inherit; color: red;">{{$order->order_single_id}}</font></font></span></td>
          </tr> -->
          <!-- <tr>
            <td height="20" colspan="3"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">订单创建时间：</font></font><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></td>
          </tr> -->
          <tr>
            <td colspan="3"    style=" padding: 20px 0 0 20px;color:#666;font-size:14px">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
                                <tbody><tr>
                        <td width="100" height="100"  style="vertical-align: top;"><div align="center"><a target="_blank" href="http://{{$url}}"><img src="http://{{$url}}/{{$goods->img}}" width="100" height="100"></a></div></td>
                        <td width="585" colspan="2" style=" padding-left: 20px;">
                            <p style="margin:6px 0 10px 0; "><font style="vertical-align: inherit;color:#333"><font style="vertical-align: inherit;">{{$goods->goods_name}}</font></font></p>
                            
                            @if($order->order_cuxiao_id!='暂无促销信息')
                            <p style="margin: 0; ">
                              {{$order->order_cuxiao_id}}: الخصومات
                            </p>
                            @endif
                        </td>
                    </tr>
                            </tbody></table></td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td colspan="3"style=" padding: 20px 0 0 20px;color:#666;font-size:12px">
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
            </td>
          </tr>
          <tr>
            <td height="40" colspan="3">
              @if(($goods->goods_price*$order->order_num)-($order->order_price)>0)
              <div align="right"style=" padding: 20px 0 0 20px;color:#666;font-size:14px;margin-bottom:30px">
                <!-- <p align="right">
                    件数：<font style="color:red">{{$order->order_num}}</font> </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                    订单价格：   <font style="color:red">{{$order->order_price}}</font>        </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                    小计：<font style="color:red">{{$order->order_price}}</font></font>
                </p> -->
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right; padding-left: 4px">{{$order->order_currency}}{{$goods->goods_price}}</p><p style="display:inline-block;margin: 6px 0;">:السعر للقطعه الواحده </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_num}}</p><p style="display:inline-block;margin: 6px 0;">:عدد القطع </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{($goods->goods_price*$order->order_num)-($order->order_price)}}</p><p style="display:inline-block;margin: 6px 0;">:السعر بعد الخصم  </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}0</p><p style="display:inline-block;margin: 6px 0;">: التوصيل مجانا </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{$order->order_price}}</p><p style="display:inline-block;margin: 6px 0;">: الاجمالي </p>
                </div>
              </div>
              @else
              <div align="right"style=" padding: 20px 0 0 20px;color:#666;font-size:14px;margin-bottom:30px">
                <!-- <p align="right">
                    件数：<font style="color:red">{{$order->order_num}}</font> </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                    订单价格：   <font style="color:red">{{$order->order_price}}</font>        </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                    小计：<font style="color:red">{{$order->order_price}}</font></font>
                </p> -->
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_num}}</p><p style="display:inline-block;margin: 6px 0;">: عدد القطع </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}0</p><p style="display:inline-block;margin: 6px 0;"> : التوصيل مجانا </p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{$order->order_price}}</p><p style="display:inline-block;margin: 6px 0;">: الاجمالي</p>
                </div>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td height="40" colspan="3"style="color:#666;font-size:14px;border-top: 1px solid #F29400;"><p style="
              margin-top: 48px;
          ">
          <font style="vertical-align: inherit;">
            <a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a>هذا الايميل للتأكيد علي انكم طلبتم من 
          </font>
          <br>
          <font style="vertical-align: inherit;">
                <!-- 这是一个自动回复电子邮件，您不必回复。如果您还有其他问题，请发送电子邮件至<a href="mailto:yejforlh@gmail.com" style="color:#F8770E">yejforlh@gmail.com</a> -->
                هذه الرساله مسجله ,لا داعي للرد عليها ,للرد علي ايه استتفسارات من فضلك تواصل معنا عبر البريد الالكتروني التالي  <a href="mailto:yejforlh@gmail.com" style="color:#F8770E">yejforlh@gmail.com</a>
                </font></p></td>
          </tr>
          <tr>
            <td height="40" colspan="3"style="color:#666;font-size:14px"><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">نرحب بجميع استفساراتكم وننتظر تسوقكم مره اخري </font></font><br>
            <a href="mailto:yejforlh@gmail.com" ><font  style="vertical-align: inherit;"><font style="vertical-align: inherit;"><a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a></font></font></a>
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