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
    <style>
    @media screen and (min-width: 780px){
.nav-container {
    width: 1200px;
    margin: 0 auto;
}}
.nav-9999 div ul {
    display: none;
    position: absolute;
    width: 100%;
    top: 36px;
    left:0;
    z-index: 9999999999999;
    background-color: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 6px;
}
/* .nav-9999 a:hover ul{display:block;} */
@media screen and (min-width: 780px){
#cd-lateral-nav .level-top>div {
    width: 150px;
    padding: 0 10px;
    text-align: center;
}
}
#cd-lateral-nav .level-top>div {
    display: block;
    line-height: 28px;
    cursor: pointer;
    padding: 5px 0px 5px 20px;
    font-size: 16px;
    color: #333;
    float: left;
}
    </style>
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
            @if($cates)
            @foreach($cates as $cate)
                <li class="level0 nav-{{$cate->site_class_id}} level-top"><a
                            href="{{ url('/cate/') .'/'.$cate->site_goods_type_id  }}"
                            class="level-top"><span>{{ $cate->site_class_show_name }} </span></a></li>
            @endforeach
            @endif
            <li class="level0 nav-9999 level-top">
                <div style="    position: relative;"class="level-top">
                    <span>Q & A </span>
                    <ul>
                    <li>
                            <a href="/footer/about">{!! config("language.footer-name.about.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                        </li>
                        <li>
                        <a href="/footer/shipping">{!! config("language.footer-name.shipping.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                        </li>
                        <li>
                        <a href="/footer/return">{!! config("language.footer-name.return.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                        </li>
                        <li>
                        <a href="/footer/privacy">{!! config("language.footer-name.privacy.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                        </li>
                        <li>
                        <a href="/footer/contact">{!! config("language.footer-name.contact.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
                        </li>
                    </ul>
                </div>
                
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
    jQuery(function () {
        jQuery('.seach').click(function () {
            jQuery('.reveal-modal').slideDown();
        });
        // jQuery(".nav-9999 a").mouseover(function(e){
        //     // jQuery(".nav-9999 a ul").hide(400);  //隐藏
        //     e.stopPropagation();
        //     console.log(2)
        // })
        // jQuery(".nav-9999 a").mouseout(function(e){
        //     // jQuery(".nav-9999 a ul").show(400);  //显示
        //     e.stopPropagation();
        //     console.log(1)
        // })
        jQuery('.nav-9999>div').hover(function() {
            jQuery(".nav-9999 div ul").css('display', 'block');
        }, function() {
            jQuery(".nav-9999 div ul").css('display', 'none');
        });
        jQuery(".nav-9999 div ul").hover(function() {
            jQuery(this).css('display', 'block');;
        }, function() {
            jQuery(this).css('display', 'none');
        })
    })

</script>
<div class="reveal-modal" id="review-form" style="display: none;">
    <div class="return-icon"><img src="{{ asset('img/site_img/return.svg') }}"></div>
    <form id="top-search" action="{{ url('/search') }}" method="get">
        <div class="search">
            <input id="search" type="text" name="q" value="" class="input-text" maxlength="128"
                   placeholder="{!! config("language.index.input_keyworks.".\App\goods::get_language($site->sites_blade_type)) !!}">
            <button type="submit"
                    title="{!! config("language.index.search.".\App\goods::get_language($site->sites_blade_type)) !!}"
                    class="button">
                <span><span>{!! config("language.index.search.".\App\goods::get_language($site->sites_blade_type)) !!}</span></span>
            </button>
            <div id="search_autocomplete" class="search-autocomplete"></div>
        </div>
    </form>
    <div class="hot">
        <div class="title">{!! config("language.index.hot_search.".\App\goods::get_language($site->sites_blade_type)) !!}</div>
        <ul class="hot-left">
            @if($hot_search['left'])
                @foreach($hot_search['left'] as $hot)
                    <li><a href="{{ url('/search/') .'?q=' .$hot }}">{{ $hot }}</a></li>
                @endforeach
            @endif
        </ul>
        <ul class="hot-right">
            @if($hot_search['right'])
            @foreach($hot_search['right'] as $hot)
                <li><a href="{{ url('/search/') .'?q=' .$hot }}">{{ $hot }}</a></li>
            @endforeach
            @endif
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