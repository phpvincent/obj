<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="ui-mobile">
<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>[ydzsshop]404</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="YDZSSHOP"/>
    <meta name="keywords" content=YDZSSHOP"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link rel="icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="shortcut icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="alternate" media="only screen and (max-width: 640px)" href="/">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/site_css/default.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/site_css/iconfont.css') }}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/site_css/style.css') }}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/site_css/swiper.min.css') }}" media="all"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/site_css/public.css') }}" media="all"/>
    <script type="text/javascript" src="{{ asset('js/site_js/prototype.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/jquery-1.10.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/noconflict.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/validation.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/js.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/translate.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/cookies.') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/simple-share.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/total.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/base.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/hhswipe.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/site_js/swiper-3.4.0.jquery.min.js') }}"></script>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
<body style="padding-top: 50px;">
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p>
                <strong>You must enable JavaScript in your browser to use the functionality of this site.</strong><br/>
            </p>
        </div>
    </div>
</noscript>
<div class="layercengtop"></div>
<header class="maintop">
    <div class="header">
        <a href="javascript:void(0);" id="cd-menu-trigger"><span class="cd-menu-icon"></span></a>
        <a href="/"><img alt="YDZSSHOP" src="picture/logo.png"/></a>
        <a href="#" class="seach newiconfont newicon-sousuotiaofangdajingqz11" data-animation="fade"
           data-reveal-id="myModal"></a>
    </div>
</header>
<nav id="cd-lateral-nav" class="">
    <div class="nav-container">
        <ul id="nav">
            <li class="level0 nav-1 level-top"><a href="{{ url('/active/') .'/1'  }}" class="level-top"><span>Recommended Goods</span></a></li>
            <li class="level0 nav-1 level-top"><a href="{{ url('/active/') .'/2'  }}" class="level-top"><span>Flash Sale</span></a></li>
            <li class="level0 nav-1 level-top"><a href="{{ url('/active/') .'/3'  }}" class="level-top"><span>Hot Sales</span></a></li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    jQuery(function () {
        jQuery('.seach').click(function () {
            jQuery('.reveal-modal').slideDown();
        });
    })
</script>
<div class="reveal-modal" id="review-form" style="display: none;">
    <div class="return-icon"><img src="{{ asset('img/site_img/return.svg') }}"></div>
    <form id="top-search" action="https://www.vivishop.tw/catalogsearch/result/" method="get">
        <div class="search">
            <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" placeholder="search">
            <button type="submit" title="search" class="button"><span><span>search</span></span></button>
            <div id="search_autocomplete" class="search-autocomplete"></div>
        </div>
    </form>
    <div class="hot">
       
    </div>
</div>
<div style="display:none">
    <section style="position: fixed;top:50px;left: 0;right: 0;z-index:2;" id="top-banner-fix">
        <p><a href="customer/account/login/"><img src="https://vivishop.looaon.com/wysiwyg/wap/670-60_labor-day.jpg"
                                                  alt=""></a><span class="ibox"></span></p>
        <img id="top-close" src="https://www.vivishop.tw//skin/frontend/yisainuo/wap/images/close.png"
             style="position: absolute; right: 4px; top: 80px; width: 20px;">
    </section>
    <script type="text/javascript">var bH = jQuery('html,body').width() / 640 * 60;
        jQuery('body').css('padding-top', 50);
        jQuery('#top-close').css('top', (bH - 20) / 2)
        jQuery('#top-close').click(function (e) {
            jQuery('#top-banner-fix').hide();
            jQuery('body').css('padding-top', 120);
            e.stopPropagation()
        });
        jQuery(function () {
            jQuery('.return-icon').click(function () {
                jQuery('.reveal-modal').slideUp();
            });
            jQuery.ajax({
                url: '/customshippingmethod/cartcount/index', type: 'post', success: function (data) {
                    jQuery('.newicon-gouwudai i').html(data);
                }
            });
        });</script>
</div>
<main class="cd-main-content">
    <div class="std"><div class="xf-list">
    <div class="empty_cart">
    <img src="{{ asset('/img/site_img/errorpage.png')}}" alt="404" />
    <p><a href="/" class="org_btnb index_btn">return home</a></p>
    </div>
    </div>
    <style>.empty_cart,.empty_cart img{width:100%}.empty_cart{position:relative;}.index_btn{background:#e40681;height:32px;line-height:32px;padding:0 25px;}.empty_cart p{position:absolute;left:50%;top:60%;}</style></div>
</main>
<div class="footer4">
    <div class="baozhang">
        <div class="buy-logo"><img src="{{asset('img/site_img/buy-logo.png')}}"></div>
        <div class="buy-p">
              {!! config("language.footer-promess.English") !!}
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
                <li>© 2019 <a href="/" title="">ydzsshop.tw</a>. All rights reserved</li>
            </ul>
        </div>
    </div>
</div>
<ul class="rightmenu">
    <li id="go_top" style="display: block;"></li>
</ul>
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
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