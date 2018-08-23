
<!DOCTYPE html>
<html>
    <head>
                <link rel="shortcut icon" href="https://cdn.uudobuy.com/ueditor/image/20171019/1508385777747154.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{$goods->goods_name}}</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link href="/css/mui.min.css" rel="stylesheet">
        <link href="/css/iconfont.css" rel="stylesheet">
        <link href="/css/base.css" rel="stylesheet">
        <link href="/css/component.css" rel="stylesheet">
        <link href="/css/detail.css" rel="stylesheet">
        <link href="/css/new.css" rel="stylesheet">
        <link href="/css/shop.css" rel="stylesheet">
        <link href="/css/total.css" rel="stylesheet">
        <link href="/css/temporary.css" rel="stylesheet">
        <link href="/css/pay.css" rel="stylesheet">
        <link href="/css/JS5.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/mui.min.js" type="text/javascript"></script>
        <script src="/js/base.js" id="baseScript" path="http://oatsbasf.3cshoper.com"></script>
        <script src="/js/mui.lazyload.js"></script>
        <script src="/js/shop5.js"></script>
        <script src="/js/ytc.js" async=""></script>
        <script src="/js/bat.js" async=""></script>
        <script async="" src="/js/analytics.js"></script>

        <!--产品页轮播-->
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="/js/yxMobileSlider.js"></script>
        <script type="text/javascript" src="/js/icheck.min.js"></script>
        <script type="text/javascript" src="/js/conversion.js"></script>
        <script type="text/javascript" src="/js/global.js?v=1.0"></script>
        <script>
        jQuery(function(){setFrom();});
        </script>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '{{$goods->goods_pix}}'); 
        fbq('track', 'PageView');
        fbq('track', 'InitiateCheckout');//发起结账
        fbq('track', 'Lead');//潜在客户,填写表单
        fbq('track', 'Purchase', {value:'{{$goods->goods_price}}', currency:'TWD'});//购买
        </script>
        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id={{$goods->goods_pix}}&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
    <!--雅虎统计代码-->
   <!--  <script type="application/javascript">(function(w,d,t,r,u){w[u]=w[u]||[];w[u].push({'projectId':'10000','properties':{'pixelId':'10042137'}});var s=d.createElement(t);s.src=r;s.async=true;s.onload=s.onreadystatechange=function(){var y,rs=this.readyState,c=w[u];if(rs&&rs!="complete"&&rs!="loaded"){return}try{y=YAHOO.ywa.I13N.fireBeacon;w[u]=[];w[u].push=function(p){y([p])};y(c)}catch(e){}};var scr=d.getElementsByTagName(t)[0],par=scr.parentNode;par.insertBefore(s,scr)})(window,document,"script","https://s.yimg.com/wi/ytc.js","dotq");</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=FYdC6J1" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript> -->

</head>
<body style="">
<link href="/css/addcart.css" rel="stylesheet">

<script src="/js/Validform.min.js"></script>
<!-- <script src="/js/addcart.js"></script> -->
<!--gleepay-->
<script type="text/javascript" src="/js/broser.js"></script>
<!--gleepay-->
<!--国内网站需修改导航内容，把头部导航抽象到 nav_checkout中 -->
<header class="mui-bar mui-bar-nav" style="background:#fff;">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#333"></a>
    <h1 class="mui-title">確認訂單</h1>
</header>
<script>
    $(document).scroll(function () {
        $("#navigationBox").css('top', $(document).scrollTop());
    });
</script><script>
jQuery(function(){
    jQuery("#coll_id").val(getQueryString('coll_id'));
});
</script>
<div class="mui-content">
<form class="mui-content" id="save" onsubmit="return false;" method="post" action="/saveform">
    <input type="hidden" name="cuxiao_id" @if($goods->goods_cuxiao_type=='2') value="{{\App\cuxiao::where('cuxiao_goods_id',$goods->id)->first()->cuxiao_id}}" @endif >{{$goods->goods_cuxiao_type}}
<input type='hidden' name='_auth_token_' value='1531802224'><input type="hidden" name="coll_id" id="coll_id" value=""/>
<input type="hidden" id="from" name="from" value=""/>
{{ csrf_field()}}
<div class="addcart-specs-body"><dl class="addcart-specs-content"><dt data-id="52414" data-sort="50">顏色</dt><dd><span data-id="200169" data-def="true" class="">01#自然黑</span><span data-id="200170" class="">02#淺棕色</span><span data-id="200171" class="active">03#深棕色</span></dd></dl></div>
<!--product info begin-->
<div class="pro_info">
    <div class="ctxthead">
        <div class="limgbox"><img src="{{App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}"/></div>
        <div class="rpricebox">NT$<span id="price">{{$goods->goods_price}}</span></div>
    </div>
    <div class="ctxtbox">
        <h1>{{$goods->goods_name}}</h1>
        <h2><span style="color: rgb(255, 0, 0);"><strong>【{{$goods->goods_cuxiao_name}}】</strong></span>{{$goods->goods_msg}}</h2>
            </div>
</div>
<!--product info end-->
<!--size begin-->
<div id="addcart">
    <!-- <div class="addcart-group-buttons" style="display: block;"><div class="addcart-float-buttons-block" data-id="7022"><button type="button" class="addcart-float-buttons-block-button">限時特惠 加$300再得兩件[點擊購買]</button></div></div> -->
</div>

<!-- <script src="/js/buy.js"></script> -->

<!--iframe id="storage" src="http://feilm.top/index/storage?url=http://tw.5ittbat.com" height="0px" frameborder="0"></iframe-->
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/layer/layer.js"></script>

<script type="text/javascript">
    $(function(){
        $.ajax({
                url:"{{url('/gethtml')}}",
                type:'post',
                data:{'id':{{$goods->goods_id}},'_token':"{{csrf_token()}}"},
                datatype:'html',
                success:function(msg){
                 $('#addcart').html(msg);
                    // window.setTimeout("window.location='{{url('admin/contro/index')}}'",2000);       
                }
            })
    })
</script>



<div id="loading" style="display: none;">
    <center>Submiting</center>
</div>
<!--qty total end-->
<!--table begin-->
    <div class="secure secure_03"><img src="/images/secure_03.jpg" /></div>
<div class="mui-input-group">
    
    <div class="mui-input-row">
        <label><span class="require">*</span>姓名:</label>
        <input type="text" name="firstname" datatype="s1-30" placeholder="必填，填寫收件人姓名" nullmsg="填寫收件人姓名" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>Last name:</label>
        <input type="text" name="lastname" class="mui-input-clear">
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>手機:</label>
        <input type="text" datatype="/^\d+$/" placeholder="必填，填寫收件人聯繫電話" nullmsg="填寫收件人聯繫電話" errormsg="請填寫正確的電話號碼" name="telephone" class="mui-input-clear">
    </div>
    <!--<div class="mui-input-row" style="display:none;">-->
        <!--<label>Country / Region:</label>-->
        <!---->
    <!--</div>-->
    <div class="mui-input-row" style="display:none;">
        <label>State:</label>
        <!--<input type="text" datatype="z1-300" nullmsg="state_not_correct" errormsg="state_not_correct" name="state" class="mui-input-clear">-->
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>City:</label>
        <!--<input type="text" name="city" datatype="z1-300" nullmsg="city_not_correct" errormsg="city_not_correct" class="mui-input-clear">-->
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span></label>
        <div id="twzipcode"></div>
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>詳細地址:</label>
        <input type="text" datatype="z1-300" placeholder="必填，街道門牌信息" nullmsg="街道門牌信息" errormsg="address_not_correct" name="address1" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>Address Line2:</label>
        <input type="text" name="address2" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>郵政編號:</label>
        <input type="text" name="zip" class="mui-input-clear">
    </div>
        <div class="mui-input-row need_email">
        <label>Email:</label>
        <!--<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" datatype="/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" class="mui-input-clear">-->
        <input type="text" name="email" placeholder="選填，填寫收件人電子郵件" class="mui-input-clear">
    </div>
<script>
    jQuery(function(){
        var html1 ='';
//        html +='<div class="mui-input-row need_email">';
        html1 += ' <label><span style="color:red;">*</span>Email:</label>';
        html1 +='<input type="text" placeholder="選填，填寫收件人電子郵件" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" datatype="/^([0-9A-Za-z\-_\.]+)@([0-9a-z\.]+)$/g" name="email" class="mui-input-clear"></div>';
        var html2 = '';
        html2 += "<label>Email:</label>";

        html2 += '<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" class="mui-input-clear">';

        var payty =  jQuery('input[name=pay_type]:checked').val();
        if(payty==7||payty==2){
            jQuery('.need_email').children().remove();
            jQuery('.need_email').append(html1);
        }else{
            jQuery('.need_email').children().remove();
            jQuery('.need_email').append(html2);
        }
        jQuery('input[name=pay_type]').click(function(){
            if(jQuery(this).val()==7 || jQuery(this).val()==2){
                jQuery('.need_email').children().remove();
                jQuery('.need_email').append(html1);
            }else{
                jQuery('.need_email').children().remove();
                jQuery('.need_email').append(html2);
            }

        });

    });

</script>    <div class="mui-input-row" style=" height:66px">
        <label>留言:</label>
        <textarea name="notes" placeholder="選填，如備用電話、產品規格或配送時間等"></textarea>
    </div>
<!--地区实现三级联动的脚本-->
<!--引入不同地区的脚本文件，默认引入台湾的文件，其它地区的文件，在自定义block中设置-->
<script src="/js/diqu/jquery.twzipcode3.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(e) {
        jQuery('#twzipcode').twzipcode();
        jQuery('input[name="zipcode"]').attr('style','display:none;');
        jQuery('#twzipcode').find("[name='state']").attr('style','margin-right:4.7%;width: 40%;');
        jQuery('#twzipcode').find("[name='state']").change(function(){
            var county = jQuery(this).val();
            var district = jQuery('#twzipcode').find("[name='city']").val();
            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all').val(message_info);
        });

        jQuery('#twzipcode').find("[name='city']").change(function(){
            var county = jQuery('#twzipcode').find("[name='state']").val();
            district = jQuery(this).val();


            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all').val(message_info);
        });

        jQuery('.gw_address_message_info').change(function(){
            var county = jQuery('#twzipcode').find("[name='state']").val();
            var district = jQuery('#twzipcode').find("[name='city']").val();
            //alert(district);
            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all ').val(message_info);
        });

    });
</script></div>
<!--table end-->
<!--paypal begin-->
<div class="paymentbox">
	<ul>
        <script>
    jQuery(function(){
        jQuery("#pay_1").click();                                        
    });
    </script>
            <li>
       	  <div class="mui-input-row mui-radio mui-left cash-on-delivery">
              <input checked="" name="pay_type" id="pay_1" value="1" type="radio">
            <label>
                貨到付款            </label>
              <span style="width:100px;">
                                    <img src="/images/cash.jpg" alt="" id="cash"/>
                                                  </span>
          </div>
        </li>
            </ul>
</div>
<!--paypal end-->
    <!--把货到付款费用添加抽象到cash_on_delivery中-->
    
<!--button begin-->
<div class="btndiv">
	<button id="pay" type="button" class="btnstyle01">提交訂單</button>
</div>
<!--button end-->
<!--footer begin-->
    <!--把最下方的底部内容抽象到newfooter中-->
    <div class="newfooter">
            溫馨提示：支持貨到付款+免郵費+七天無理由退換貨！收到商品後有任何疑問請聯繫我們在線客服，或發郵件至
        <a href="hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>.
    </div><!--footer end-->
<input type="hidden" name="id" value="103107897"/>
<input type="hidden" name="poid" value=""/>
<input type="hidden" name="append" value="0"/>
<input type="hidden" name="salerule_id" value="0"/>
<input type="hidden" name="currency_code" value="NTD"/>
<input type="hidden" name="currency_id" value="1"/>
<input type="hidden" name="amount" value="0"/>
</form>

<script>
jQuery(function(){

    try{fbq('track', "AddPaymentInfo");}
    catch(e){}
    jQuery('input').one('click',function(){
       jQuery('form').removeAttr('onsubmit');
    });
    jQuery("#select_ship").change(function(){
       jQuery.each(jQuery(this).find('option'),function(){
            var that = jQuery(this);
            if(that.attr('value')==jQuery("#select_ship").val())
            {
                price = that.data('price');
                jQuery("#ship_price").html(price);
            }
       });
    });

//    var form=jQuery("form").Validform({
//		tiptype:function(msg){
//			$2.toast(msg);
//		},
//		tipSweep:true
//    });
//    form.tipmsg.r="訂單提交中...";
});
</script>
<script src="/js/Validform.min.js"></script>
<script>
    var form=jQuery("form").Validform({
        tiptype:function(msg){
            $2.toast(msg);
        },
        datatype:{
            "z6-18": /^[\S\s]{6,18}$/,
        },
        beforeSubmit:function(){
            /*if(jQuery("input[name='data']").val() == undefined){
                console.log(jQuery("input[name='data']").val());
                alert('Incomplete data,Form validation error!');
                return false;
            }*/
            	var vname = /先生|小姐|太太|男士|女士|退貨|換貨|退货|换货|(^.$)/;
				if(vname.test(jQuery("input[name='firstname']").val())){
					/*layer.msg("請填寫您的真實姓名");
					return false;*/
				}
				if(_checkBlackName(jQuery("input[name='firstname']").val())){
					layer.msg("無效的名字");
					return false;
				}
			            if(jQuery("select[name='state6']").val()==""){
                alert('請選取縣市');
                return false;
            }
            jQuery('#pay').attr('disabled',true);
            return true;
        },
        tipSweep:true
    });
    form.tipmsg.r="訂單提交中...";


jQuery('input[name=pay_type]').change(function(){
    var id = jQuery('input[name=pay_type]:checked').val() || 0;
    //stripe是ajax支付
    if(id == 10 || id == 11 || id==13)
    {
        _data = '';
        form.config({
            ajaxPost:true,
            callback:function(data){
                _data = data;
                if( id==10 || id==13)
                {
                    var token = data.stripeToken || '';
                    jQuery("#pay").show();
                    jQuery("#applepay").hide();
                    jQuery.post('/stripe/callback?stripeToken='+token,data,function(html){
                            var res = jQuery.parseJSON(html);
                            if(res.status=='ok')
                            {
                                location.href = res.url;
                            }
                            else
                            {
                                $2.toast(res.errormsg);
                                jQuery("#pay").removeAttr('disabled');
                            }
                    });
                }
                if( id==11 )
                {
                    jQuery('input[type=text]').change(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('input[type=text]').focus(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('input[type=text]').blur(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('.mui-btn').click(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery("#pay").hide();
                    jQuery("#applepay").show();
                    _data = data;
                }
            },
        });
    }
    //其他的正常请求
    else
    {
        jQuery("#pay").show();
        jQuery("#applepay").hide();
        form.config({
            ajaxPost:false
        });
    }
});
$('#pay').bind('click',function(){
   $('#save').submit();
})
</script>

</body>
</html>