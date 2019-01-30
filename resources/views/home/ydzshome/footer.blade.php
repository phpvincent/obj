<div class="footer4">
    <div class="baozhang">
        <div class="buy-logo"><img src="{{asset('img/site_img/buy-logo.png')}}"></div>
        <div class="buy-p">
           {!! config("language.footer-promess.".\App\goods::get_language($site->sites_blade_type)) !!}
        
        
        </div>
    </div>
    <div class="footmenu">
        <div class="fot-zf"><img src="{{asset('img/site_img/zhifuyinh02.png')}}" alt=""></div>
        <div class="footmenu-list">
            <ul class="f-list">
                <li>
                    <a href="/footer/about">{!! config("language.footer-name.about.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                    <a href="/footer/shipping">{!! config("language.footer-name.shipping.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                    <a href="/footer/return">{!! config("language.footer-name.return.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                    <a href="/footer/privacy">{!! config("language.footer-name.privacy.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                </li>
                <li>© 2019 <a href="/" title="">ydzsshop.tw</a>. All rights reserved</li>
            </ul>
        </div>
    </div>
</div>
<ul class="rightmenu">
    <li id="go_top" style="display: block;"></li>
</ul>
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