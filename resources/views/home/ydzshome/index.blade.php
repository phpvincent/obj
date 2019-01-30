@extends('home.ydzshome.header')
@section('content')
    <div class="std"><p>
        </p></div>
    @if(count($banners)>0)
        <div class="addWrap">
            <div class="swipe" id="mySwipes" style="visibility: visible;">
                <div class="swipe-wrap">
                    @foreach($banners as $banner)
                        <div><a @if($banner->site_goods_id) href="{{ url('goods/') .'/'.$banner->site_goods_id }}"
                                @else href="" @endif><img class="img-responsive" src="{{ url($banner->site_img) }}"
                                                          alt=""></a></div>
                    @endforeach
                </div>
            </div>
            <ul id="position">
                @foreach($banners as $banner)
                    <li class=" "></li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="static_nav">
        <div class="ind-nav" style="visibility: visible;">
            <ul class="li_nav">
                <li><a href="/women-dress.html"><img class="img-responsive" src="picture/jog-150x168.jpg" alt=""></a>
                </li>
                <li><a href="/lady-bags.html"><img class="img-responsive" src="picture/wer-150x168.jpg" alt=""></a></li>
                <li><a href="/women-shoes.html"><img class="img-responsive" src="picture/kuiui-150x168.jpg" alt=""></a>
                </li>
                <li><a href="/underwear.html"><img class="img-responsive" src="picture/twny-150x168.jpg" alt=""></a>
                </li>
                <li><a href="/3c.html"><img class="img-responsive" src="picture/asd-150x168.jpg" alt=""></a></li>
                <li><a href="/men-wear.html"><img class="img-responsive" src="picture/jgui-150x168.jpg" alt=""></a></li>
                <li><a href="/m-package.html"><img class="img-responsive" src="picture/yuh-150x168.jpg" alt=""></a></li>
                <li><a href="/new-men-shoes.html"><img class="img-responsive" src="picture/jguk-150x168.jpg" alt=""></a>
                </li>
                <li><a href="/kitchen-supplies.html"><img class="img-responsive" src="picture/jiaju-150x168.jpg" alt=""></a>
                </li>
                <li><a href="/women-dress.html"><img class="img-responsive" src="picture/eew-150x168.jpg" alt=""></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="djs">
        @if($activitie1)
            <div class="djstu1">
                <a href="{{ url('activity/1') }}">
                    <img src="{{ url($activitie1->site_active_img) }}" width="308" height="380">
                </a>
            </div>
        @endif
        @if($activities)
            <div class="djstu2">
                @foreach($activities as $key=>$activity)
                    <div class="djs0{{ $key }}">
                        <a href="{{ url('activity/') . '/' . $activity->site_active_type }}">
                            <img src="{{ url($activity->site_active_img) }}" width="308" height="190">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="cp_fl">
    </div>
    <div class="newsale-title">
        <div class="newsale_r">
            限量搶購中
        </div>
    </div>
    <div class="new-sale-big">
        <a href="/tooxie.html"><img src="img/zlt.jpg"/></a>
    </div>
    <div class="clear"></div>
    <div class="home_category_list">
        <ul class="prolist active_type1">
            
        </ul>
        <div class="clear"></div>
    </div>
    <!-- <div class="hsale-title">
        <div class="timer" id="timer">
        </div>
    </div>
    <script language="javascript">
        (function ($) {
            var endtime = '24:00:00';
            $.ajax({
                type: 'post',
                url: '/customshippingmethod/countdown/index',
                data: {'endtime': endtime},
                success: function (datetime) {
                    if (datetime) {
                        countDown(datetime);
                    }
                }
            });

            function countDown(datetime) {
                var h = Math.floor(datetime / 3600);
                var m = Math.floor((datetime % 3600) / 60);
                var s = (datetime % 3600) % 60;

                if (h < 10) h = "0" + h;
                if (m < 10) m = "0" + m;
                if (s < 10) s = "0" + s;

                $("#timer").html('<span>倒数</span><span id="h" class="timerk">' + h + '</span>:<span id="m" class="timerk">' + m + '</span>:<span id="s" class="timerk">' + s + '</span>结束');

                setTimeout(function () {
                    countDown(datetime - 1);
                }, 1000);
            }

        })(jQuery);
    </script>
    <div class="clear"></div>
    </div>
    <div class="home_category_list">
        <ul class="prolist">
            <li>
                <div class="pro-tu">
                    <a href="https://www.vivishop.tw/xichenqi.html"><img src="img/zlt.jpg" width="400"
                                                                         height="400" alt=""/></a>
                </div>
                <div class="pro-tex">
                    <h3><a href="https://www.vivishop.tw/xichenqi.html">四合一乾濕兩用車用吸塵器【三折激殺】</a></h3>
                    <div class="p3">
                        <span class="newprice">NT$ 1,180</span>
                        <span class="oldprice">NT$ 5,000</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="pro-tu">
                    <a href="https://www.vivishop.tw/lipstick-microphone.html"><img
                                src="img/zlt.jpg" width="400" height="400" alt=""/></a>
                </div>
                <div class="pro-tex">
                    <h3><a href="https://www.vivishop.tw/lipstick-microphone.html">mr.leaf迷你口紅唱吧麥克風【第二隻僅需300！】</a></h3>
                    <div class="p3">
                        <span class="newprice">NT$ 1,280</span>
                        <span class="oldprice">NT$ 2,980</span>
                    </div>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
    </div> -->
    <div id="load" style="width:100%;text-algin:center;height:40px;padding:8px 0;"><img src="images/loading.gif" style="width:30px;margin:0 auto;display:none;">
    </div>

    <style>#descDiv .prolist li {
            padding: 5px;
            box-sizing: border-box;
            border: 0;
            box-shadow: none;
            display: none;
        }

        #descDiv .prolist li .newprice {
            font-weight: normal;
        }

        #descDiv .prolist li .newprice .fprice {
            font-style: normal;
            font-size: 18px;
        }</style>

    <script type="text/javascript" src="{{ asset('js/site_js/ld.js') }}" async="true"></script>

    <script type="text/javascript">window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            "event": "crto_homepage", "crto": {"email": ""}
        });</script>
    <script type="text/javascript">
        try {
            var searchForm = new Varien.searchForm('search_mini_form', 'search', '在這裡搜索整個商店...');
            searchForm.initAutocomplete('https://www.vivishop.tw/catalogsearch/ajax/suggest/', 'search_autocomplete');
        }
        catch (e) {
        }
    </script>

    <script>
        var bullets = document.getElementById('position').getElementsByTagName('li');
        var banner = Swipe(document.getElementById('mySwipes'), {
            auto: 4000,
            continuous: true,
            disableScroll: false,
            callback: function (pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = ' ';
                }
                bullets[pos].className = 'cur';
            }
        })
    </script>
    <script>
        var site_id = {{ $site->sites_id }}
        jQuery(document).ready(function ($) {
            var state = true;
            var page =1;
            // var linum = jQuery("#descDiv ul li").length;
            // jQuery("#descDiv ul li:lt(4)").show();
            jQuery(window).scroll(function () {
                var scrot = jQuery(document).scrollTop() + 100;
                if (scrot >= jQuery(document).height() - jQuery(window).height()) {
                    if (state == true) {
                        state = false;
                        jQuery("#load img").css("display", "block");
                        $.ajax({
                            type:'get',
                            url:'/index/get_site_goods?site_id='+site_id+'&page='+page+'&active_type=1',
                            success:function(data){
                                var addli = '';
                                $.each(JSON.parse(data),function(i,item){
                                    addli += '<li><div class="pro-tu">'
                                           + '<a href="http://'+item.goods_url+'"><img src="'+item.site_active_img+'" width="400" height="400" alt=""/></a>'
                                        +'</div>'
                                        +'<div class="pro-tex">'
                                            +'<h3><a href="http://'+item.goods_url+'">'+item.goods_name+'</a></h3>'
                                            +'<div class="p3">'
                                                +'<span class="newprice">NT$ '+item.goods_real_price+'</span>'
                                                +'<span class="oldprice">NT$ '+item.goods_real_price+'</span>'
                                            +'</div>'
                                        +'</div></li>'
                                })
                                $('.active_type1').append(addli);
                                // jQuery("#load img").css("display", "none");
                                if(data.length<6){
                                    jQuery("#load").html("<p style='text-align:center;line-height:30px;font-size:14px;'>已經到最底端了</p>").css({"margin-top": "1px"});
                                }else{
                                  state = true;
                                  page++;
                                }
                            }
                        });
                        // setTimeout(function () {
                        //     jQuery("#load img").css("display", "none");
                        //     var lilen = jQuery("#descDiv ul li:visible").length;
                        //     var lilent = lilen + 4;
                        //     jQuery("#descDiv ul li:lt(" + lilent + ")").show();
                        //     if (lilent >= linum) {
                        //         jQuery("#load").html("<p style='text-align:center;line-height:30px;font-size:14px;'>已經到最底端了</p>").css({"margin-top": "1px"});
                        //     } else {
                        //         state = true;
                        //     }
                        // }, 1000);
                    }
                }
            });
        });
    </script>
@endsection

