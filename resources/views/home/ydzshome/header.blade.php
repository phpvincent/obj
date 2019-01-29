<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="ui-mobile">
<head>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title}}</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content=" {{ $description }}"/>
    <meta name="keywords" content="{{ $keywords }}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link rel="icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="shortcut icon" href="https://vivishop.looaon.com/favicon/default/logo-159t2ljb68a6xlehh7s62t79r1.png"
          type="image/x-icon"/>
    <link rel="alternate" media="only screen and (max-width: 640px)" href="https://m.vivishop.tw/">
    <link rel="stylesheet" type="text/css" href="css/site_css/default.css"/>
    <link rel="stylesheet" type="text/css" href="css/site_css/iconfont.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="css/site_css/style.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="css/site_css/swiper.min.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="css/site_css/public.css" media="all"/>
    {{--<script type="text/javascript" src="js/site_js/require.js"></script>--}}
    <script type="text/javascript" src="js/site_js/prototype.js"></script>
    <script type="text/javascript" src="js/site_js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/site_js/noconflict.js"></script>
    <script type="text/javascript" src="js/site_js/validation.js"></script>
    <script type="text/javascript" src="js/site_js/js.js"></script>
    <script type="text/javascript" src="js/site_js/form.js"></script>
    <script type="text/javascript" src="js/site_js/translate.js"></script>
    <script type="text/javascript" src="js/site_js/cookies.js"></script>
    <script type="text/javascript" src="js/site_js/simple-share.js"></script>
    <script type="text/javascript" src="js/site_js/total.js"></script>
    <script type="text/javascript" src="js/site_js/main.js"></script>
    <script type="text/javascript" src="js/site_js/base.js"></script>
    <script type="text/javascript" src="js/site_js/index.js"></script>
    <script type="text/javascript" src="js/site_js/hhswipe.js"></script>
    <script type="text/javascript" src="js/site_js/swiper-3.4.0.jquery.min.js"></script>
    <!--<script type="text/javascript">Mage.Cookies.path = '/';-->
    <!--Mage.Cookies.domain = '.www.vivishop.tw';</script>-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <script type="text/javascript">optionalZipCountries = ["MO", "HK", "PA", "IE"];</script>
    <script type="text/javascript">
        var Translator = new Translate({
            "HTML tags are not allowed": "\u4e0d\u5141\u8a31HTML\u6a19\u7c64",
            "Please select an option.": "\u8acb\u9078\u64c7\u4e00\u500b\u9078\u9805\u3002",
            "This is a required field.": "\u9019\u662f\u5fc5\u586b\u5340\u57df\u3002",
            "Please enter a valid number in this field.": "\u8acb\u5728\u6b64\u5340\u57df\u8f38\u5165\u6709\u6548\u7684\u6578\u5b57\u3002",
            "The value is not within the specified range.": "\u6578\u503c\u4e0d\u5728\u6307\u5b9a\u7bc4\u570d\u5167\u3002",
            "Please use numbers only in this field. Please avoid spaces or other characters such as dots or commas.": "\u8acb\u5728\u8a72\u6b04\u4f4d\u4e2d\u53ea\u4f7f\u7528\u6578\u5b57\u3002\u8acb\u4e0d\u8981\u4f7f\u7528\u7a7a\u683c\u6216\u5176\u5b83\u5b57\u7b26\uff0c\u4f8b\u5982\u53e5\u9ede\u6216\u9017\u865f\u3002",
            "Please use letters only (a-z or A-Z) in this field.": "\u5728\u8a72\u6b04\u4f4d\u4e2d\u8acb\u53ea\u4f7f\u7528\u5b57\u6bcd\uff08a-z\u6216A-Z\uff09",
            "Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.": "\u8a72\u6b04\u4f4d\u4e2d\u8acb\u53ea\u4f7f\u7528\u5b57\u6bcd\uff08a-z\uff09\u3001\u6578\u5b57\uff080-9\uff09\u4ee5\u53ca\u4e0b\u5283\u7dda\uff08_\uff09\uff0c\u7b2c\u4e00\u500b\u5b57\u7b26\u61c9\u70ba\u5b57\u6bcd\u3002",
            "Please use only letters (a-z or A-Z) or numbers (0-9) only in this field. No spaces or other characters are allowed.": "\u8a72\u6b04\u4f4d\u4e2d\u8acb\u53ea\u4f7f\u7528\u5b57\u6bcd\uff08a-z \u6216 A-Z\uff09\u6216\u6578\u5b57\uff080-9\uff09\uff0c\u4e0d\u80fd\u4f7f\u7528\u7a7a\u683c\u6216\u5176\u5b83\u5b57\u7b26\u3002",
            "Please use only letters (a-z or A-Z) or numbers (0-9) or spaces and # only in this field.": "\u8a72\u6b04\u4f4d\u4e2d\u53ea\u80fd\u4f7f\u7528\u5b57\u6bcd\uff08a-z \u6216 A-Z\uff09\u6216\u6578\u5b57\uff080-9\uff09\u6216\u7a7a\u683c\uff0c\u6216 # \u3002",
            "Please enter a valid phone number. For example (123) 456-7890 or 123-456-7890.": "\u8acb\u8f38\u5165\u6709\u6548\u7684\u96fb\u8a71\u865f\u78bc\u3002\u4f8b\u5982 (123) 456-7890 \u6216 123-456-7890\u3002",
            "Please enter a valid fax number. For example (123) 456-7890 or 123-456-7890.": "\u8acb\u8f38\u5165\u6709\u6548\u50b3\u771f\u865f\u78bc\uff0c\u4f8b\u5982 (123) 456-7890 \u6216 123-456-7890\u3002",
            "Please enter a valid date.": "\u8acb\u8f38\u5165\u6709\u6548\u65e5\u671f",
            "Please enter a valid email address. For example johndoe@domain.com.": "\u8acb\u8f38\u5165\u6709\u6548\u90f5\u4ef6\u5730\u5740\u3002\u4f8b\u5982johndoe@domain.com\u3002",
            "Please use only visible characters and spaces.": "\u8acb\u53ea\u4f7f\u7528\u53ef\u898b\u5b57\u7b26\u548c\u7a7a\u683c\u3002",
            "Please enter 7 or more characters. Password should contain both numeric and alphabetic characters.": "\u8acb\u8f38\u5165\u81f3\u5c117\u500b\u5b57\u7b26\u3002\u5bc6\u78bc\u61c9\u5305\u542b\u6578\u5b57\u8207\u5b57\u6bcd\u3002",
            "Please make sure your passwords match.": "\u8acb\u78ba\u4fdd\u5bc6\u78bc\u5339\u914d\u3002",
            "Please enter a valid URL. Protocol is required (http:\/\/, https:\/\/ or ftp:\/\/)": "\u8acb\u8f38\u5165\u6709\u6548URL\u3002\u5354\u8b70\u540d\u662f\u5fc5\u9808\u7684\uff08http:\/\/\u3001https:\/\/\uff0c\u6216ftp:\/\/\uff09",
            "Please enter a valid URL. For example http:\/\/www.example.com or www.example.com": "\u8acb\u8f38\u5165\u6709\u6548\u7684URL\uff0c\u4f8b\u5982http:\/\/www.example.com \u6216 www.example.com",
            "Please enter a valid URL Key. For example \"example-page\", \"example-page.html\" or \"anotherlevel\/example-page\".": "\u8acb\u8f38\u5165\u6709\u6548\u7684 URL \u5bc6\u9470\u3002\u4f8b\u5982\uff0c \"example-page\"\u3001\"example-page.html\"\uff0c\u6216 \"anotherlevel\/example-page\"\u3002",
            "Please enter a valid XML-identifier. For example something_1, block5, id-4.": "\u8acb\u8f38\u5165\u6709\u6548\u7684XML\u6a19\u8b58\u7b26\u3002\u4f8b\u5982\uff0c\u985e\u4f3csomething_1\u3001block5\u3001id-4\u3002",
            "Please enter a valid social security number. For example 123-45-6789.": "\u8acb\u8f38\u5165\u6709\u6548\u793e\u6703\u5b89\u5168\u865f\u78bc\uff0c\u4f8b\u5982123-45-6789\u3002",
            "Please enter a valid zip code. For example 90602 or 90602-1234.": "\u8acb\u8f38\u5165\u6709\u6548\u90f5\u7de8\uff0c\u4f8b\u598290602\u621690602-1234\u3002",
            "Please enter a valid zip code.": "\u8acb\u8f38\u5165\u6709\u6548\u7684\u90f5\u653f\u7de8\u78bc\u3002",
            "Please use this date format: dd\/mm\/yyyy. For example 17\/03\/2006 for the 17th of March, 2006.": "\u8acb\u4f7f\u7528\u9019\u6a23\u7684\u65e5\u671f\u683c\u5f0f\uff1add\/mm\/yyyy\u3002\u4f8b\u598217\/03\/2006\u4ee3\u88682006\u5e743\u670817\u65e5\u3002",
            "Please enter a valid $ amount. For example $100.00.": "\u8acb\u8f38\u5165\u6709\u6548\u7684\u91d1\u984d\uff0c\u4f8b\u5982$100.00\u3002",
            "Please select one of the above options.": "\u8acb\u9078\u64c7\u4e0a\u5217\u9078\u9805\u4e2d\u7684\u4e00\u500b\u3002",
            "Please select one of the options.": "\u8acb\u9078\u64c7\u4e0b\u5217\u4e00\u500b\u9078\u9805\u3002",
            "Please select State\/Province.": "\u8acb\u9078\u64c7\u5dde\/\u7701\u3002",
            "Please enter a number greater than 0 in this field.": "\u8acb\u5728\u8a72\u6b04\u4f4d\u4e2d\u8f38\u5165\u5927\u65bc0\u7684\u6578\u5b57\u3002",
            "Please enter a number 0 or greater in this field.": "\u8acb\u5728\u8a72\u6b04\u4f4d\u4e2d\u8f38\u5165\u6578\u5b570\u6216\u66f4\u5927\u503c\u3002",
            "Please enter a valid credit card number.": "\u8acb\u8f38\u5165\u6709\u6548\u7684\u4fe1\u7528\u5361\u5361\u865f\u3002",
            "Credit card number does not match credit card type.": "\u4fe1\u7528\u5361\u7de8\u865f\u8207\u4fe1\u7528\u5361\u985e\u578b\u4e0d\u5339\u914d\u3002",
            "Card type does not match credit card number.": "\u4fe1\u7528\u5361\u985e\u578b\u8207\u4fe1\u7528\u5361\u865f\u4e0d\u5339\u914d\u3002",
            "Incorrect credit card expiration date.": "\u932f\u8aa4\u7684\u4fe1\u7528\u5361\u5230\u671f\u65e5\u3002",
            "Please enter a valid credit card verification number.": "\u8acb\u8f38\u5165\u6709\u6548\u7684\u4fe1\u7528\u5361\u9a57\u8b49\u78bc\u3002",
            "Please use only letters (a-z or A-Z), numbers (0-9) or underscore(_) in this field, first character should be a letter.": "\u8acb\u4f7f\u7528\u5b57\u6bcd\uff08az\u6216AZ\uff09\uff0c\u6578\u5b57\uff080-9\uff09\u6216\u4e0b\u5283\u7dda\uff08_\uff09\uff0c\u5728\u9019\u65b9\u9762\uff0c\u7b2c\u4e00\u500b\u5b57\u7b26\u5fc5\u9808\u662f\u5b57\u6bcd\u3002",
            "Please input a valid CSS-length. For example 100px or 77pt or 20em or .5ex or 50%.": "\u8acb\u8f38\u5165\u6709\u6548 CSS\u9577\u5ea6\u3002\u4f8b\u5982\uff0c 100px \u6216 77pt \u6216 20em \u6216 .5ex \u6216 50%\u3002",
            "Text length does not satisfy specified text range.": "\u6587\u672c\u9577\u5ea6\u4e0d\u7b26\u5408\u6307\u5b9a\u7684\u6587\u672c\u9577\u5ea6\u7bc4\u570d\u3002",
            "Please enter a number lower than 100.": "\u8acb\u8f38\u5165\u4e0d\u8d85\u904e100\u500b\u6578\u5b57\u3002",
            "Please select a file": "\u8acb\u9078\u64c7\u4e00\u500b\u6587\u4ef6",
            "Please enter issue number or start date for switch\/solo card type.": "\u8acb\u8f38\u5165Switch\/Solo\u985e\u5361\u7684\u9812\u767c\u865f\u6216\u958b\u59cb\u65e5\u671f\u3002",
            "Please wait, loading...": "\u8acb\u7a0d\u5019\uff0c\u6b63\u5728\u8f09\u5165...",
            "This date is a required value.": "\u8a72\u65e5\u671f\u70ba\u5fc5\u9700\u503c\u3002",
            "Please enter a valid day (1-%d).": "\u8acb\u8f38\u5165\u6709\u6548\u5929\u6578\uff081-%d\uff09\u3002",
            "Please enter a valid month (1-12).": "\u8acb\u8f38\u5165\u6709\u6548\u6708\u4efd\uff081-12\uff09\u3002",
            "Please enter a valid year (1900-%d).": "\u8acb\u8f38\u5165\u6709\u6548\u5e74\u4efd\uff081900-%d\uff09\u3002",
            "Please enter a valid full date": "\u8acb\u8f38\u5165\u6709\u6548\u5b8c\u6574\u65e5\u671f",
            "Please enter a valid date between %s and %s": "\u8acb\u5728 %s \u8207 %s \u4e4b\u9593\u8f38\u5165\u6709\u6548\u65e5\u671f\u3002",
            "Please enter a valid date equal to or greater than %s": "\u8acb\u8f38\u5165\u7b49\u65bc\u6216\u5927\u65bc %s \u7684\u6709\u6548\u65e5\u671f",
            "Please enter a valid date less than or equal to %s": "\u8acb\u8f38\u5165\u5c0f\u65bc\u6216\u7b49\u65bc %s \u7684\u6709\u6548\u65e5\u671f",
            "Complete": "\u5b8c\u6210",
            "Add Products": "\u65b0\u589e\u7522\u54c1",
            "Please choose to register or to checkout as a guest": "\u8acb\u9078\u64c7\u8a3b\u518a\u6216\u7d50\u7b97\u4f5c\u70ba\u5609\u8cd3",
            "Your order cannot be completed at this time as there is no shipping methods available for it. Please make necessary changes in your shipping address.": "\u60a8\u7684\u8a02\u55ae\u7121\u6cd5\u5b8c\u6210\uff0c\u5728\u9019\u500b\u6642\u5019\uff0c\u6709\u6c92\u6709\u53ef\u7528\u7684\u904b\u8f38\u65b9\u6cd5\u3002\u8acb\u5728\u60a8\u7684\u9001\u8ca8\u5730\u5740\u9032\u884c\u5fc5\u8981\u7684\u4fee\u6539\u3002",
            "Please specify shipping method.": "\u8acb\u6307\u5b9a\u7684\u904b\u8f38\u65b9\u5f0f\u3002",
            "Your order cannot be completed at this time as there is no payment methods available for it.": "\u60a8\u7684\u8a02\u55ae\u7121\u6cd5\u5b8c\u6210\uff0c\u5728\u9019\u500b\u6642\u5019\uff0c\u6709\u6c92\u6709\u53ef\u7528\u7684\u4ed8\u6b3e\u65b9\u5f0f\u3002",
            "Please specify payment method.": "\u8acb\u8a3b\u660e\u4ed8\u6b3e\u65b9\u5f0f\u3002",
            "Add to Cart": "\u65b0\u589e\u5230\u8cfc\u7269\u8eca",
            "In Stock": "\u6709\u8ca8",
            "Out of Stock": "\u7121\u8ca8"
        });</script>
    <script type='text/javascript'>
   window.__lo_site_id = 98327;
    (function () {
    var wa = document.createElement('script');
    wa.type = 'text/javascript';
    wa.async = true;
    wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wa, s);
    })();</script>

    <!--<script type="text/javascript">var _paq = _paq || [];-->
    <!--_paq.push(['trackPageView']);-->
    <!--_paq.push(['enableLinkTracking']);-->
    <!--(function () {-->
    <!--var u = "//mo11shop.com/total/";-->
    <!--_paq.push(['setTrackerUrl', u + 'piwik.php']);-->
    <!--_paq.push(['setSiteId', '218']);-->
    <!--var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];-->
    <!--g.type = 'text/javascript';-->
    <!--g.async = true;-->
    <!--g.defer = true;-->
    <!--g.src = u + 'piwik.js';-->
    <!--s.parentNode.insertBefore(g, s);-->
    <!--})();</script>-->
</head>
<body style="padding-top: 50px;">
<noscript>
    <div class="global-site-notice noscript">
        <div class="notice-inner">
            <p>
                <strong>JavaScript的似乎要在您的瀏覽器禁用。</strong><br/>
                您必須在瀏覽器中啟用JavaScript才能使用本網站的功能。 </p>
        </div>
    </div>
</noscript>
<div class="layercengtop"></div>
<header class="maintop">
    <div class="header">
        <a href="javascript:void(0);" id="cd-menu-trigger"><span class="cd-menu-icon"></span></a>
        {{--<a href="https://www.vivishop.tw/customer/account/"><span--}}
                    {{--class="yh-icon newiconfont newicon-yonghu3"></span></a>--}}
        <a href="https://www.vivishop.tw/"><img alt="VIVISHOP嚴選品牌旗艦店" src="picture/logo.png"/></a>
        <a href="#" class="seach newiconfont newicon-sousuotiaofangdajingqz11" data-animation="fade"
           data-reveal-id="myModal"></a>
        {{--<a id="bag" class="cat newiconfont newicon-gouwudai" href="https://www.vivishop.tw/checkout/cart/">--}}
            {{--<i data-number="0">0</i>--}}
        {{--</a>--}}
    </div>
</header>
<nav id="cd-lateral-nav" class="">
    <div class="nav-container">
        <ul id="nav">
            <li class="level0 nav-1 first active selected level-top"><a href="https://www.vivishop.tw/women-dress.html"
                                                                        class="level-top"><span>潮流女裝 </span></a></li>
            <li class="level0 nav-2 level-top"><a href="https://www.vivishop.tw/women-shoes.html"
                                                  class="level-top"><span>時尚女鞋</span></a></li>
            <li class="level0 nav-3 level-top"><a href="https://www.vivishop.tw/lady-bags.html" class="level-top"><span>百搭女包</span></a>
            </li>
            <li class="level0 nav-4 level-top"><a href="https://www.vivishop.tw/new-men-shoes.html"
                                                  class="level-top"><span>新品男鞋</span></a></li>
            <li class="level0 nav-5 level-top"><a href="https://www.vivishop.tw/men-wear.html" class="level-top"><span>精品男裝</span></a>
            </li>
            <li class="level0 nav-6 level-top"><a href="https://www.vivishop.tw/m-package.html" class="level-top"><span>精選男包</span></a>
            </li>
            <li class="level0 nav-7 level-top"><a href="https://www.vivishop.tw/underwear.html" class="level-top"><span>性感內衣</span></a>
            </li>
            <li class="level0 nav-8 level-top"><a href="https://www.vivishop.tw/3c.html"
                                                  class="level-top"><span>樂享3C</span></a></li>
            <li class="level0 nav-9 level-top"><a href="https://www.vivishop.tw/household.html" class="level-top"><span>家居用品</span></a>
            </li>
            <li class="level0 nav-10 level-top"><a href="https://www.vivishop.tw/baby-products.html"
                                                   class="level-top"><span>母嬰用品</span></a></li>
            <li class="level0 nav-11 last level-top"><a href="https://www.vivishop.tw/kitchen-supplies.html"
                                                        class="level-top"><span>廚房用品</span></a></li>
        </ul>
    </div>
    <ul class="cd-navigation" style="display:none">
        <li class="item-has-children currency-select">
            <a href="#">幣種</a><span class="rightico"><i class="gw-i"></i></span>
            <ul class="sub-menu">
                <li>
                    <a class="TWD"
                       href="https://www.vivishop.tw/directory/currency/switch/currency/TWD/uenc/aHR0cHM6Ly93d3cudml2aXNob3AudHcvd29tZW4tZHJlc3MuaHRtbA,,/"
                       title="TWD"><span></span> TWD</a>
                </li>
                <li>asd</li>
                <li>
                    <a class="JPY"
                       href="https://www.vivishop.tw/directory/currency/switch/currency/JPY/uenc/aHR0cHM6Ly93d3cudml2aXNob3AudHcvd29tZW4tZHJlc3MuaHRtbA,,/"
                       title="JPY"><span></span> JPY</a>
                </li>
                <li>asd</li>
                <li>
                    <a class="EUR"
                       href="https://www.vivishop.tw/directory/currency/switch/currency/EUR/uenc/aHR0cHM6Ly93d3cudml2aXNob3AudHcvd29tZW4tZHJlc3MuaHRtbA,,/"
                       title="EUR"><span></span> EUR</a>
                </li>
                <li>asd</li>
                <li>
                    <a class="THB"
                       href="https://www.vivishop.tw/directory/currency/switch/currency/THB/uenc/aHR0cHM6Ly93d3cudml2aXNob3AudHcvd29tZW4tZHJlc3MuaHRtbA,,/"
                       title="THB"><span></span> THB</a>
                </li>
                <li>asd</li>
            </ul>
        </li>
    </ul>
</nav>
<script type="text/javascript">
    jQuery(function () {
        jQuery('.seach').click(function () {
            jQuery('.reveal-modal').slideDown();
        });
    })
</script>
<div class="reveal-modal" id="review-form" style="display: none;">
    <div class="return-icon"><img src="https://www.vivishop.tw//skin/frontend/yisainuo/wap/images/return.svg"></div>
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
    @yield('content')
</main>
@include('home.site.footer')