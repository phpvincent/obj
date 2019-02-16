@extends('home.ydzshome.header')
@section('content')
    <div class="std"><p>
        </p></div>
    @if(count($banners)>0)
        <div class="addWrap">
            <div class="swipe" id="mySwipes" style="visibility: visible;">
                <div class="swipe-wrap">
                    @foreach($banners as $banner)
                        <div>
                            <a @if($banner->site_goods_id) href="{{ url('/index/site_goods/') .'/'.$banner->site_goods_id }}"
                               @else href="" @endif><img class="img-responsive"
                                                         src="{{ url($banner->site_img) }}"
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
    @if(count($cates) > 0)
        <div class="static_nav">
            <div class="ind-nav" style="visibility: visible;">
                <ul class="li_nav">
                    @foreach($cates as $key=>$cate)
                        @if($key < 9)
                            <li style="position:relative;">
                             <div>
                             <a href="{{ url('/cate/') .'/'.$cate->site_goods_type_id  }}">
                                    <img class="img-responsive" src="{{ url('') }}/{{ $cate->goods_type_img }}" alt="{{ $cate->site_class_show_name }}">
                                </a>
                                <span style="position:absolute;bottom:0;width:100%;text-align:center;font-size: 12px;line-height: 14px;"><b>{{$cate->site_class_show_name}}</b></span>
                             </div>
                            </li>
                        @endif
                    @endforeach
                        <li style="position:relative;">
                            <div>
                            <a href="{{ url('/cate/') .'/'.$cates[0]->site_goods_type_id  }}">
                                <img class="img-responsive" src="{{ asset('img/site_img/more.jpg') }}">
                            </a>
                              <span style="position:absolute;bottom:0;width:100%;text-align:center;font-size: 12px;line-height: 14px;"><b>More</b></span>
                            </div>
                        </li>
                </ul>
            </div>
        </div>
@endif
                                            <div class=" djs">
                                    @if($activitie1)
                                        <div class="djstu1">
                                            <a href="{{ url('activity/2') }}">
                                                <img src="{{ url($activitie1->site_active_img) }}" width="308"
                                                     height="380">
                                            </a>
                                        </div>
                                    @endif
                                    @if($activities)
                                        <div class="djstu2">
                                            @foreach($activities as $key=>$activity)
                                                <div class="djs0{{ $key }}">
                                                    <a href="{{ url('activity/') . '/' . $activity->site_active_type }}">
                                                        <img src="{{ url($activity->site_active_img) }}" width="308"
                                                             height="190">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                @endif
            </div>
            <div class="cp_fl">
            </div>
            <div class="STPRY">
                <div></div>
                <span>
                    OUR STPRY
                </span>
            </div>
            <div class="new-sale-big tu" style="margin-bottom:10px">
                <a href="/footer/about"><img src="img/site_img/ourstory.jpg"/></a>
            </div>
            <div class="newsale-title">
                <div class="newsale_r">
                    {!! config("language.index.new.".\App\goods::get_language($site->sites_blade_type)) !!}
                </div>
            </div>
            <div class="home_category_list">
                <ul class="prolist active_type1">

                </ul>
                <div class="clear"></div>
            </div>
            <div class="newsale-title">
               <!--  <div class="timer" id="timer"><span></span><span id="h" class="timerk">09</span>:<span id="m" class="timerk">02</span>:<span id="s" class="timerk">46</span></div> -->
                <div class="newsale_r">
                    {!! config("language.index.seckill.".\App\goods::get_language($site->sites_blade_type)) !!}
                </div>
            </div>
            
            <div class="clear"></div>
            <div class="home_category_list">
                <ul class="prolist active_type2">

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
            <div id="load" style="width:100%;text-algin:center;height:40px;padding:8px 0;"><img src="images/loading.gif"
                                                                                                style="width:30px;margin:0 auto;display:none;">
            </div>
            <div class="new-sale-big">
                <a href="/"><img src="img/zlt.jpg"/></a>
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
                }
                @media screen and (min-width: 780px){
                    .new-sale-big.tu {
                        max-width: 80%;
                    }}
                .prolist li:hover{
                    box-shadow: 3px 3px 10px rgba(0,0,0,.15)!important;
                }
                .prolist li img:hover{
                    opacity: 0.3
                }
                .djs img:hover,.tu img:hover{
                    opacity: 0.3
                }
                .STPRY{
                    height:20px;
                    margin-bottom:6px;
                    line-height: 20px;
                    position: relative;
                    text-align: center;
                }
                .STPRY div{
                    position: absolute;
                    top: 9px;
                    border-top: 2px solid #000;
                    width: 80%;
                    left: 10%;
                }
                .STPRY span{
                    background: #fff;
                    position: absolute;
                    left: 50%;
    transform: translateX(-50%);
                }
                </style>


            <script type="text/javascript">window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    "event": "crto_homepage", "crto": {"email": ""}
                });</script>


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
                    var page = 1;
                    //新品推荐不用懒加载
                    $.ajax({
                        type: 'get',
                        url: '/index/get_site_goods?site_id=' + site_id + '&active_type=2',
                        success: function (data) {
                            var addli = '';
                            datas = JSON.parse(data)
                            $.each(datas, function (i, item) {
                                var dspnone = '';
                                if(item.goods_price >= item.goods_real_price) {
                                    dspnone = 'dspnone'
                                }
                                addli += '<li>'
                                    +'<div class="pro-tu" style="text-align: center;">'
                                    + '<a href="http://' + item.goods_url + '"><img src="http://' + item.img_url + '" style=""/></a>'
                                    + '</div>'
                                    + '<div class="pro-tex">'
                                    + '<h3><a href="http://' + item.goods_url + '">' + item.goods_name + '</a></h3>'
                                    + '<div class="p3">'
                                    + '<span class="newprice">' + item.currency + item.goods_price  + '</span>&nbsp;'
                                    + '<span class="oldprice '+dspnone+'">' + item.currency + item.goods_real_price + '</span>'
                                    + '</div>'
                                    + '</div></li>'
                            })
                            $('.active_type1').append(addli);
                        }
                    });

                    jQuery(window).scroll(function () {
                        var scrot = jQuery(document).scrollTop() + 500;
                        if (scrot >= jQuery(document).height() - jQuery(window).height()) {
                            if (state == true) {
                                state = false;
                                jQuery("#load img").css("display", "block");
                                $.ajax({
                                    type: 'get',
                                    url: '/index/get_site_goods?site_id=' + site_id + '&page=' + page + '&active_type=1&limit=4',
                                    success: function (data) {
                                        var addli = '';
                                        datas = JSON.parse(data)
                                        $.each(datas, function (i, item) {
                                            var dspnone = '';
                                             if(item.goods_price >= item.goods_real_price) {
                                                 dspnone = 'dspnone'
                                             }
                                            addli += '<li>'
                                                +'<div class="pro-tu" style="text-align: center;">'
                                                + '<a href="http://' + item.goods_url + '"><img src="http://' + item.img_url + '" style=""/></a>'
                                                + '</div>'
                                                + '<div class="pro-tex">'
                                                + '<h3><a href="http://' + item.goods_url + '">' + item.goods_name + '</a></h3>'
                                                + '<div class="p3">'
                                                + '<span class="newprice">' + item.currency + item.goods_price + '</span>&nbsp;'
                                                + '<span class="oldprice '+dspnone+'">' + item.currency + item.goods_real_price + '</span>'
                                                + '</div>'
                                                + '</div></li>'
                                        })
                                        $('.active_type2').append(addli);
                                        jQuery("#load img").css("display", "none");
                                        if (datas.length < 4) {
                                            var bottom = '{!! config("language.index.alreay_bottom.".\App\goods::get_language($site->sites_blade_type)) !!}';
                                            jQuery("#load").append("<p style='text-align:center;line-height:30px;font-size:14px;'>" + bottom + "</p>").css({"margin-top": "1px"});
                                        } else {
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
            <script language="javascript">
                /*(function($){
                    var endtime = '24:00:00';
                     $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                    });
                    $.ajax({
                        type:'post',
                        url:'/customshippingmethod/countdown/index',
                        data:{'endtime':endtime},
                        success:function(datetime){
                            if(datetime){
                                countDown(datetime);
                            }
                        }
                    });
                    function countDown(datetime){
                        var h = Math.floor(datetime/3600);
                        var m = Math.floor((datetime%3600)/60);
                        var s = (datetime%3600)%60;

                        if(h<10) h = "0" + h;
                        if(m<10) m = "0" + m;
                        if(s<10) s = "0" + s;

                        $("#timer").html('<span></span><span id="h" class="timerk">' + h + '</span>:<span id="m" class="timerk">' + m + '</span>:<span id="s" class="timerk">' + s + '</span>');

                        setTimeout(function(){
                            countDown(datetime-1);
                        }, 1000);
                    }

                })(jQuery);*/
            </script>
@endsection

