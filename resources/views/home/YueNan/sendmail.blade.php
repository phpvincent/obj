<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[zsshop]{{$goods->goods_name}}</title>
    <style type="text/css">
      a:hover{
        color: #bcd4ec !important;
        border-radius: 5%;
      }
    </style>
</head>
<body >
        
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="2" style="background-image: url();">
          <tbody><tr>
            <td height="21" colspan="3"><table width="800" border="0" align="center" cellpadding="0" cellspacing="2">
              <tbody><tr>
                
                <td width="204" rowspan="3"><img  style="border: 1px solid #F29400; border-radius: 8%;" src="http://{{$home_url}}/images/ydzs.png" width="100"></td>
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
          <td ><div style="text-align:  center;"><font style="vertical-align: inherit; font-size: 32px;font-weight: bold; color: #F29400;">thông báo đơn đặt hàng </font></div></td>
          </tr>
        
          <tr style="
          color: #666;
          font-size: 14px;
          line-height: 24px;">
            <td height="78" colspan="3"><span class="STYLE1"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">kính chào quý khách [{{$order->order_name}}]</font></font><br>
            Rất cảm ơn quý khách đã đặt hàng trong cửa hàng trên mạng chúng tôi qua <a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a>.Chúng tôi sẽ xử lý ngay  đơn đặt hàng của quý khách . số đơn đặt hàng là<b><u>{{$order->order_single_id}}</u></b>.
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
                    <p style="margin:0"><font style="vertical-align: inherit;">thời gian tạo đơn đặt hàng : {{$order->order_time}}</font></p>
                    <!-- <p style="margin:0"><span style="border-bottom:1px dashed #ccc;" t="5" times=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{$order->order_time}}</font></font></span></p> -->
                    <p style="margin:0"><font style="vertical-align: inherit;">cách thanh toán : @if($order->order_pay_type=='0') thanh toán sau khi nhận hàng @else thanh toán trên mạng @endif</font></p>
                    <p style="margin:0"><font style="vertical-align: inherit;">ghi chú : @if($order->order_remark!=null){{$order->order_remark}}@endif</font></p>
                </div>
                <div style="width:70%;margin:0 auto;    text-align: center;">
                  <p style="margin:0"> khu vực nhận hàng :&nbsp;{{$order->order_state}} {{$order->order_city}}</p>
                  <p style="margin:0">địa chỉ kỹ  :&nbsp;{{$order->order_add}}</p>
                  <p style="margin:0"> Điện thoại liên lạc :&nbsp;{{$order->order_tel}} </p>
                  @if($order->order_email!=null)
                  <p style="margin:0">Email liên hệ : {{$order->order_email}}</p>
                  @endif
                  @if($order->order_zip!=null)
                  <p style="margin:0">ZIP :&nbsp;{{$order->order_zip}} </p>
                  @endif
              </div>
              </td>
          </tr>
          <tr>
            <td height="3" colspan="3" background=""></td>
          </tr>
          <tr>
            <td height="20" colspan="3" style=" border-top: 1px solid #F29400; color: #F29400;"><p style="    text-align: center;"><strong><font style="vertical-align: inherit;">thông tin tỉ mỉ của sản phẩm</font></strong></p></td>
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
                        <td width="100" height="100"  style="vertical-align: top;"><div align="center"><a target="_blank" href="http://{{$url}}"><img src="http://{{$home_url}}/{{$goods->img}}" width="100" height="100"></a></div></td>
                        <td width="585" colspan="2" style=" padding-left: 20px;">
                            <p style="margin:6px 0 10px 0; "><font style="vertical-align: inherit;color:#333"><font style="vertical-align: inherit;">{{$goods->goods_name}}</font></font></p>
                            
                            @if($order->order_cuxiao_id!='暂无促销信息')
                            <p style="margin: 0; ">
                            hoạt động khuyến mại :{{$order->order_cuxiao_id}}
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
                              <strong>kiện thứ {{$k}}</strong><br>
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
                  <p style="display:inline-block;margin: 6px 0;"> đơn giá  :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right; padding-left: 4px">{{$order->order_currency}}{{price_format($goods->goods_price)}}</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">số lượng hàng :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_num}}</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">giá cả ưu đãi  :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{price_format(($goods->goods_price*$order->order_num)-($order->order_price))}}</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">miễn phí phân phối hàng :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}0</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">tổng cộng  :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{price_format($order->order_price)}}</p>
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
                  <p style="display:inline-block;margin: 6px 0;">số lượng hàng :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_num}}</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">miễn phí phân phối hàng :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}0</p>
                </div>
                <div style="text-align: right;">
                  <p style="display:inline-block;margin: 6px 0;">tổng cộng  :</p><p style="display:inline-block;width: 100px;;margin: 6px 0;text-align: right;padding-left: 4px">{{$order->order_currency}}{{price_format($order->order_price)}}</p>
                </div>
              </div>
              @endif
            </td>
          </tr>
          <tr>
            <td height="40" colspan="3"style="color:#666;font-size:14px;border-top: 1px solid #F29400;"><p style="
              margin-top: 48px;
          "><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">email này chỉ dùng để xác nhận đơn đặt hàng của quý khách trên</font></font><a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a></font></font></a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                 </font><a><font style="vertical-align: inherit;"></font></a><font style="vertical-align: inherit;">。</font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                </font><font style="vertical-align: inherit;">Dây là một email  trả lời tự động, quý khách không cần trả lời. Nếu quý khách có vấn đề gì khác, xin gửi email đến
        
                 </font></font><a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"> 
        
                。</font></font></p></td>
          </tr>
          <tr>
            <td height="40" colspan="3"style="color:#666;font-size:14px"><p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">mong chờ quý khách phỏng vấn lần sau. </font></font><br>
            <a href="mailto:hyfhdcjn@gmail.com" ><font  style="vertical-align: inherit;"><font style="vertical-align: inherit;"><a style="color:#F8770E" target="_blank" href="http://{{$url}}">{{$url}}</a></font></font></a>
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