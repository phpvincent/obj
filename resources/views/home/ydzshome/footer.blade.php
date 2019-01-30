<div class="footer4">
    <div class="baozhang">
        <div class="buy-logo"><img src="{{asset('img/site_img/buy-logo.png')}}"></div>
        <div class="buy-p">
            <h3>買家保障</h3>
            <p><em></em>如果您未收到商品<b>全額退款！</b></p>
            <p><em></em>如果您購買的商品與描述不符，<b>全額或部分退款！</b></p>
        </div>
    </div>
    <div class="footmenu">
        <div class="fot-zf"><img src="{{asset('img/site_img/zhifuyinh02.png')}}" alt=""></div>
        <div class="footmenu-list">
            <ul class="f-list">
                <li>
                    <a href="/about">關於我們</a>
                    <a href="/service">服務條款</a>
                    <a href="/shipping">物流條款</a>
                    <a href="/return">退換貨政策</a>
                    <a href="/privacy">隱私協議</a>
                </li>
                <li>© 2017 <a href="/" title="">ydzsshop.tw</a>. All rights reserved</li>
            </ul>
        </div>
    </div>
</div>
<ul class="rightmenu">
    <li id="go_top" style="display: block;"></li>
</ul>
<script type="text/javascript" src="{{ asset('js/site_js/ld.js') }}" async="true"></script>
<script>
    jQuery(document).ready(function () {
    jQuery("#go_top").hide();
    jQuery(window).scrollTop(0);
    jQuery(function () {
        var height = jQuery(window).height();
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > height) {
                jQuery("#go_top").fadeIn(500);
            } else {
                jQuery("#go_top").fadeOut(500);
            }
        });
        jQuery("#go_top").click(function () {
            jQuery('body,html').animate({scrollTop: 0}, 100);
            return false;
        });
    });
});
</script>
<script type="text/javascript">
    var deviceType = (window.innerWidth <= 767) ? 'm' : (window.innerWidth >= 980) ? 'd' : 't';
    window.criteo_q = window.criteo_q || [];
    window.criteo_q.push({"event": "setSiteType", "type": deviceType, "ecpplugin": "magento-1.6.4"});
    window.criteo_q.push({"event": "setAccount", "account": "48663"}, {
        "event": "setEmail",
        "email": ""
    }, {"event": "viewHome"});
</script>
</html>