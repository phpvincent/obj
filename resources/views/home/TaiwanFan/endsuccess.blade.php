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
@if($is_monitor==1&&in_array('6',explode(',',\App\worker_monitor::first(['worker_monitor_route_type'])['worker_monitor_route_type'])))
            <script type="text/javascript" src="/js/jquery.min.js"></script>
            <script type="text/javascript" src="/js/moudul/websockets.js?v=1.0"></script>
        @endif
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
</head>
<div class="m-hd">
    <div class="m-topBar">
                    <a class="goback" href="/backpack"></a>
                <div class="title">確認訂單</div>
    </div>
</div>
<div class="explain">
    <div class="imgbox">
        <img src="/img/order_success.png" class="img_list">
        <span>訂單已成功！</span>
        <span style="margin: 0px; display: none" id="unAuthLabel">(Unverified)</span>
    </div>
    <div>
                    <ul class="pay_list">
                <li>
                <span class="tips1">付款方式 :</span>
                <span class="tips2">{{$order_pay_type}}</span>
                </li>
                <li>
                <span class="tips1">您的訂單編號 :</span>
                <span class="tips2">{{$order->order_single_id}}</span>
                </li>
                <li>
                <span class="tips1">應支付：</span>
                <span class="tips2">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}} {{$order->order_price}}
                                </span>
                </li>
            </ul>
            </div>
    <p style="margin-bottom: 38px;" id="order_tips">祝賀！您的訂單提交成功。我們會儘快交貨。感謝您的支持!</p>

            <div style="text-align: center;">
            <a href="javascript:;" onclick="goHome()" class="order_quality">返回首頁</a>
            <a href="/send?goods_id={{$goods->goods_id}}&order_id={{$order->order_single_id}}" class= "kefu">訂單查詢</a>
        </div>
    

</div>
<div class="m-orderItem">
    <div class="reminder_title"><i class="reminder_icon"></i>通知</div>
    <div class="reminder">
    溫馨提示：支持貨到付款+免費送貨+七天鑑賞期。如果您在收到商品後有任何疑問請聯繫我們的在線服務或髮送電子郵件至我們的售後服務電子郵箱<a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>。請記得在郵件中附上您的姓名和訂單號。我們會儘快回複你！祝你購物愉快！
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