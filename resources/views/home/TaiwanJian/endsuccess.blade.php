<head>
<meta http-equiv="content-Type" content="text/html; charset=utf-8">
        <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport" />
        <meta content="yes" name="apple-mobile-web-app-capable" />
        <meta content="yes" name="apple-touch-fullscreen">
        <meta content="black" name="apple-mobile-web-app-status-bar-style" />
        <meta content="320" name="MobileOptimized" />
        <meta content="telephone=no" name="format-detection" />
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
<link href="/css/page-success.css" rel="stylesheet" type="text/css">
@if($order['pix_event'])
      @if($goods->goods_pix!=null&&$goods->goods_pix!='')    
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
        fbq('track', 'Purchase', {value:'{{$order->order_price}}', currency:'{{\App\currency_type::where("currency_type_id",$order->order_currency_id)->first()["currency_english_name"]}}'});//购买
        </script>
        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id={{$goods->goods_pix}}&ev=PageView
        &noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
        @endif
          <!-- YaHoo Pixel Code -->
        @if($goods->goods_yahoo_pix!=null&&$goods->goods_yahoo_pix!='')
        <script type="application/javascript">(function(w,d,t,r,u){w[u]=w[u]||[];w[u].push({'projectId':'10000','properties':{'pixelId':'{{$goods->goods_yahoo_pix}}'}});var s=d.createElement(t);s.src=r;s.async=true;s.onload=s.onreadystatechange=function(){var y,rs=this.readyState,c=w[u];if(rs&&rs!="complete"&&rs!="loaded"){return}try{y=YAHOO.ywa.I13N.fireBeacon;w[u]=[];w[u].push=function(p){y([p])};y(c)}catch(e){}};var scr=d.getElementsByTagName(t)[0],par=scr.parentNode;par.insertBefore(s,scr)})(window,document,"script","https://s.yimg.com/wi/ytc.js","dotq");</script>
        <script>
            window.dotq = window.dotq || [];
            window.dotq.push(
            {
            'projectId':'10000',
            'properties':{
                'pixelId':'{{$goods->goods_yahoo_pix}}',
                'qstrings':{
                'et':'custom',
                'ea':'Purchase',
                'product_id': '{{$goods->goods_id}}',
                }
            }});
        </script>
        @endif
          <!-- End YaHoo Pixel Code -->
          <!-- Global site tag (gtag.js) - Google Analytics -->
          @if($goods->goods_google_pix!=null&&$goods->goods_google_pix!='')
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$goods->goods_google_pix}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{$goods->goods_google_pix}}');
        </script>
        @endif 
        <!-- End Google Pixel Code -->
@endif
        <script type="text/javascript" src="/js/moudul/websockets.js?v=1.0"></script>

</head>
<!-- <body style=""><header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#333" onclick="(function(){window.location.href = '/pay?goods_id={{$goods->goods_id}}';})()"></a>
        <h1 class="mui-title">确认订单</h1>
</header>
    <div class="mui-content">
    <div class="pay_image"><span class="sico"><i class="mui-icon mui-icon-checkmarkempty"></i></span></div>
    <div class="pay_success">
            <h2 style="padding:16px 0px 10px 0px; text-align:center; color:#3cba92">订单已成功！</h2>
                            <div style="padding:15px;">
                您的订单编号:<font color="red"style="user-select: text;">{{$order->order_single_id}}</font><br>
                應支付：<font color="red">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}} {{$order->order_price}}</font>
                            </div>
                                <div style="text-align:left;padding:10px 15px 20px">
                                            请您保持手机畅通，方便快递员能及时与您取得联系，如有任何疑问，请及时联系我们在线客服。祝您购物愉快！<a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a> </div> </div>            </div>
            <div align="center" style="padding:0px 15px">
                <button type="button" class="succuss_center_a" style="" onclick="goHome()">返回首页&gt;&gt;</button>
            </div>
    </div>
</div> -->
<div class="m-hd">
    <div class="m-topBar">
                    <a class="goback" href="/backpack"></a>
                <div class="title">确认订单</div>
    </div>
</div>
<div class="explain">
    <div class="imgbox">
        <img src="/img/order_success.png" class="img_list">
        <span>订单已成功！</span>
        <span style="margin: 0px; display: none" id="unAuthLabel">(Unverified)</span>
    </div>
    <div>
                    <ul class="pay_list">
                <li>
                <span class="tips1">付款方式 :</span>
                <span class="tips2">{{$order_pay_type}}</span>
                </li>
                <li>
                <span class="tips1">您的订单编号 :</span>
                <span class="tips2">{{$order->order_single_id}}</span>
                </li>
                <li>
                <span class="tips1">应支付 :</span>
                <span class="tips2">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}} {{$order->order_price}}
                                </span>
                </li>
            </ul>
            </div>
    <p style="margin-bottom: 38px;" id="order_tips">祝贺！您的订单提交成功。我们会尽快交货。感谢您的支持!</p>

            <div style="text-align: center;">
            <a href="javascript:;" onclick="goHome()" class="order_quality">返回首页</a>
            <a href="/send?goods_id={{$goods->goods_id}}&order_id={{$order->order_single_id}}" class= "kefu">订单查询</a>
        </div>
    

</div>
<div class="m-orderItem">
    <div class="reminder_title"><i class="reminder_icon"></i>通知</div>
    <div class="reminder">
    温馨提示：支持货到付款+免费送货+七天鉴赏期。如果您在收到商品后有任何疑问请联系我们的在线服务或发送电子邮件至我们的售后服务电子邮箱<a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>。请记得在邮件中附上您的姓名和订单号。我们会尽快回复你！祝你购物愉快！
    </div>
</div>
<div class="timetips">
    <ul>
        <li><img src="/img/7day.png" alt="">Seven days appreciation period</li>
        <li><img src="/img/huodao.png" alt="">cash on delivery</li>
    </ul>
</div>
<script language="javascript">
    function goHome(){
        var u = 'http://{{$url}}';
    location.href=u;
        //window.location.href=u;
    }
</script>