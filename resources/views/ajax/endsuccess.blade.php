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
<body style=""><header class="mui-bar mui-bar-nav" style="background:#fff;">
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#333"></a>
        <h1 class="mui-title">確認訂單</h1>
</header>
    <div class="mui-content">
    <div class="pay_image"><span class="sico"><i class="mui-icon mui-icon-checkmarkempty"></i></span></div>
    <div class="pay_success">
            <h2 style="padding:16px 0px 10px 0px; text-align:center; color:#3cba92">訂單已成功！</h2>
                            <div style="padding:15px;">
                您的訂單編號:<font color="red">{{$order->order_single_id}}</font><br>
                應支付：<font color="red">NT$ {{$order->order_price}}</font>
                            </div>
                                <div style="text-align:left;padding:10px 15px 20px">
                                            <!--同一个币种不同团队的邮箱不一样-->
請您保持手機暢通，方便快遞員能及時與您取得聯繫，如有任何疑問， 請及時聯繫我們在線客服。 祝您購物愉快！            </div>
            <div align="center" style="padding:0px 15px">
                <button type="button" class="succuss_center_a" style="" onclick="javascript:history.go(-2);">返回首頁&gt;&gt;</button>
            </div>
    </div>
</div>
<script language="javascript">
    function goHome(){
        var u = 'http://{{$url}}';
    location.href=u;
        //window.location.href=u;
    }
</script>