<head>
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
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/layer/layer.js"></script>
@if(isset($is_monitor)&&$is_monitor==1&&in_array('6',explode(',',\App\worker_monitor::first(['worker_monitor_route_type'])['worker_monitor_route_type'])))
            <script type="text/javascript" src="/js/moudul/websockets.js?v=1.0"></script>
        @endif
@if($order['pix_event'])
<!-- Facebook Pixel Code -->
@if($goods->goods_pix!=null&&$goods->goods_pix!='')    
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
        fbq('track', 'Purchase', {value:'{{$order->order_price}}', currency:'TWD'});//购买
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
<body style="">

<header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#333" onclick="(function(){window.location.href = '/pay?goods_id={{$goods->goods_id}}';})()"></a>
        <h1 class="mui-title">オーダー確認 </h1>
</header>
    <div class="mui-content">
    <div class="pay_image"><span class="sico"><i class="mui-icon mui-icon-checkmarkempty"></i></span></div>
    <div class="pay_success">
            <h2 style="padding:16px 0px 10px 0px; text-align:center; color:#3cba92">オーダーできました！</h2>
                            <div style="padding:15px;">        
                            あなたのオーダーナンバー:<font color="red" style="user-select: text;" id="copyOrder">{{$order->order_single_id}}</font>
                <img src="/img/copy.png" style="height: 15px;width: 15px;" onclick="copyOrder()">
                <input type="text" value="" id="copyOrderTextarea" style="position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;">
                            <br>
                            支払い金額:<font color="red">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}} {{$order->order_price}}</font>
                            </div>
                                <div style="text-align:left;padding:10px 15px 20px">
                                            <!--同一个币种不同团队的邮箱不一样-->
                                            配送する時、携帯電話が掛かるようにお願いします、何か質問があれば、オンラインサービスまでご連絡ください。では、お買い物を楽しみに<a href="mailto:esdkhjes@gmail.com" style="color:#F8770E">esdkhjes@gmail.com</a>      </div>            </div>
            <div align="center" style="padding:0px 15px">
                <button type="button" class="succuss_center_a" style="" onclick="goHome()">ホームへ戻る&gt;&gt;</button>
            </div>
    </div>
</div>
<script language="javascript">
    function goHome(){
        var u = 'http://{{$url}}';
    location.href=u;
        //window.location.href=u;
    }
    function copyOrder (){
        var Url2 = document.getElementById("copyOrderTextarea");
        var text = document.getElementById("copyOrder").innerText;
            Url2.value = text
            Url2.select(); // 选择对象
            document.execCommand("Copy"); // 执行浏览器复制命令
            layer.msg("コピー成功！");
    }
</script>