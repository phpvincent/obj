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
        <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" style="color:#333" onclick="javascript :history.back(-1);"></a>
        <h1 class="mui-title">xác nhận đơn đặt hàng </h1>
</header>
    <div class="mui-content">
    <div class="pay_image" ><span class="sico" ><i class="mui-icon mui-icon-closeempty" style="background-color: red; border-radius: 50%;"></i></span></div>
    <div class="pay_success">
            <h2 style="padding:16px 0px 10px 0px; text-align:center; color:#f00">đưa ra đơn đặt hàng thất bại</h2>
                           
                                <div style="text-align:left;padding:10px 15px 20px">
                                            <!--同一个币种不同团队的邮箱不一样-->
                                            xin quay về đưa lại đơn đặt hàng ！            </div>
            <div align="center" style="padding:0px 15px">
                <button type="button" class="succuss_center_a" style="" onclick="goHome();">quay về &gt;&gt;</button>
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