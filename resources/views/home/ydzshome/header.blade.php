<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="ui-mobile">
<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $site->sites_name }}</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content=" {{ $site->sites_name }}"/>
    <meta name="keywords" content="{{ $site->sites_name }}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link rel="icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="shortcut icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="alternate" media="only screen and (max-width: 640px)" href="{{ $site->url }}">
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
    {{--    <script type="text/javascript" src="{{ asset('js/site_js/cookies.') }}"></script>--}}
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
        <a href="/"><img alt="{{ $site->sites_name }}" src="{{ asset('img/site.png') }}"/></a>
        <a href="#" class="seach newiconfont newicon-sousuotiaofangdajingqz11" data-animation="fade"
           data-reveal-id="myModal"></a>
    </div>
</header>
<nav id="cd-lateral-nav" class="">
    <div class="nav-container">
        <ul id="nav">
            @foreach($cates as $cate)
                <li class="level0 nav-{{$cate->site_class_id}} level-top"><a
                            href="{{ url('/cate/') .'/'.$cate->site_goods_type_id  }}"
                            class="level-top"><span>{{ $cate->site_class_show_name }} </span></a></li>
            @endforeach
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
            <input id="search" type="text" name="q" value="" class="input-text" maxlength="128" placeholder="請輸入關鍵字或品牌">
            <button type="submit" title="搜索" class="button"><span><span>搜索</span></span></button>
            <div id="search_autocomplete" class="search-autocomplete"></div>
        </div>
    </form>
    <div class="hot">
        <div class="title">熱門搜尋</div>
        <ul class="hot-left">
            <li><a href="/catalogsearch/result/?q=塑身褲">塑身褲</a></li>
            <li><a href="/catalogsearch/result/?q=收腹褲">收腹褲</a></li>
            <li><a href="/catalogsearch/result/?q=牛仔褲">牛仔褲</a></li>
            <li><a href="/catalogsearch/result/?q=運動鞋">運動鞋</a></li>
            <li><a href="/catalogsearch/result/?q=按摩棒">按摩棒</a></li>
            <li><a href="/catalogsearch/result/?q=休閒皮鞋">休閒皮鞋</a></li>
            <li><a href="/catalogsearch/result/?q=藍牙音響">藍牙音響</a></li>
            <li><a href="/catalogsearch/result/?q=as快眠枕">as快眠枕</a></li>
            <li><a href="/catalogsearch/result/?q=單肩斜挎包">單肩斜挎包</a></li>
            <li><a href="/catalogsearch/result/?q=車用吸塵器">車用吸塵器</a></li>
            <li><a href="/catalogsearch/result/?q=多功能錢包">多功能錢包</a></li>
        </ul>
        <ul class="hot-right">
            <li><a href="/catalogsearch/result/?q=麥飯石炒鍋">麥飯石炒鍋</a></li>
            <li><a href="/catalogsearch/result/?q=無痕殺菌內褲">無痕殺菌內褲</a></li>
            <li><a href="/catalogsearch/result/?q=OKO蜂巢不沾鍋">OKO蜂巢不沾鍋</a></li>
            <li><a href="/catalogsearch/result/?q=優奇仕钛鑽鍍膜">優奇仕钛鑽鍍膜</a></li>
            <li><a href="/catalogsearch/result/?q=骨傳導藍牙耳機">骨傳導藍牙耳機</a></li>
            <li><a href="/catalogsearch/result/?q=INTEX懶人充氣沙發">INTEX懶人充氣沙發</a></li>
            <li><a href="/catalogsearch/result/?q=CoolBell防盜後背包">CoolBell防盜後背包</a></li>
            <li><a href="/catalogsearch/result/?q=Rontion磁懸浮地球儀">Rontion磁懸浮地球儀</a></li>
            <li><a href="/catalogsearch/result/?q=Maidini油蠟牛皮托特包">Maidini油蠟牛皮托特包</a></li>
        </ul>
    </div>
</div>
<div style="display:none">

    <script type="text/javascript">
        var bH = jQuery('html,body').width() / 640 * 60;
        jQuery('body').css('padding-top', 50);
        jQuery(function () {
            jQuery('.return-icon').click(function () {
                jQuery('.reveal-modal').slideUp();
            });
        });
    </script>
</div>
<main class="cd-main-content">
    @yield('content')
</main>
@include('home.ydzshome.footer')