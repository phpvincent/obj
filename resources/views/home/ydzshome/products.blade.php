@extends('home.ydzshome.header')
@section('content')
    <div class="breadcrumbs">
        <a href="/" title="home" style="width: 3%;height: 3%"><img src="/img/home.jpg"></a>
        <span></span>
        {{ $position }}
    </div>
    <div class="category-products">
        <div class="content padtb padzy cate">
            <ul class="prolist active_type1">
            </ul>
        </div>
        <div class="toolbar-bottom" style="display: none;">
            <div class="dialog_link">
                <button class="filer" data-dialog-close="">精選</button>
                <div class="sortby">
                    <select>

                    </select>
                </div>
            </div>
            <div class="limiter" style="display: none;">
                <label>顯示</label>
                <select onchange="setLocation(this.value)">

                </select>
            </div>
            <div style="display: none;">
            </div>
        </div>
    </div>
    <div id="load" style="width:100%;text-algin:center;padding:8px 0;"><img
                src="{{ asset('images/loading.gif')}}" style="width:30px;margin:0 auto;display:none;"></div>
    <style>body, html {
            height: 100%;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        #show_nav {
            width: 80px;
            height: 100%;
            overflow-y: auto;
            position: fixed;
            left: 0;
            z-index: 0;
            background-color: #f7f7f7;
            padding-top: 5px;
        }

        #show_nav #nav1 li {
            width: 100%;
            font-size: 18px;
        }

        #show_nav #nav1 li a {
            display: block;
            width: 100%;
            line-height: 46px;
            height: 46px;
            text-decoration: none;
            padding-left: 10px;
            color: #333;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border-bottom: 1px solid #fefefe;
        }

        #show_nav #nav1 li a.selected {
            color: #e61d8d;
        }

        #show_nav .selected {
            border-left: 3px solid #e61d8d;
            color: #e61d8d;
            box-sizing: border-box;
            background-color: #fff;
        }

        .category-products {
            position: relative;
        }

        .current {
            color: #d00 !important;
        }

        .category-products .cate {
            display: flex;
            height: 100%;
            overflow-y: auto;
            padding-top: 0px;
        }

        .category-products .cate {
            flex-grow: 1;
            height: auto;
            padding-left: 85px;
        }

        .category-products .cate {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .category-products .cate ul li {
            flex-grow: 1;
        }

        #show_nav.fixed {
            position: fixed;
            top: 45px;
            z-index: 2;
            width: 80px;
            float: none;
            right: auto;
            left: 0;
        }

        @media screen and (max-width: 414px) {
            #show_nav, #show_nav.fixed {
                width: 70px;
            }

            #show_nav #nav1 li {
                font-size: 14px;
            }

            #show_nav #nav1 li a {
                height: 40px;
                line-height: 40px;
                padding-left: 5px;
            }

            .category-products .cate {
                padding-left: 75px;
            }
        }

        @media screen and (max-width: 374px) {
            #show_nav, #show_nav.fixed {
                width: 63px;
            }

            #show_nav #nav1 li {
                font-size: 12px;
            }

            #show_nav #nav1 li a {
                height: 36px;
                line-height: 36px;
                padding-left: 4px;
            }

            .category-products .cate {
                padding-left: 65px;
            }
        }</style>
    <script type="text/javascript">jQuery(function () {
            var nt = !1;
            jQuery(window).bind("scroll", function () {
                var st = jQuery(document).scrollTop();
                nt = nt ? nt : jQuery("#show_nav").offset().top;
                var sel = jQuery("#show_nav");
                if (nt < st) {
                    sel.addClass("fixed");
                } else {
                    sel.removeClass("fixed");
                }
                var rt = jQuery(document).scrollTop();
                var qt = jQuery(".baozhang").offset().top;
                var num = qt - jQuery(window).scrollTop() - 50;
                var mrh = jQuery(window).height() - 50;
                if (rt <= qt) {
                    jQuery("#show_nav").height(num);
                } else {
                    jQuery("#show_nav").css("height", mrh);
                }
            });
        });
    </script>
    <div id="show_nav">
        <ul id="nav1">
            @if(count($cates) > 0)
                @foreach($cates as $cate)
                    <li class="level0 nav-{{$cate->site_class_id}} first level-top @if($type == 'cate' && $active_type == $cate->site_goods_type_id) selected @endif">
                        <a href=" {{ url('/cate/') .'/'.$cate->site_goods_type_id  }}"
                           class="level-top"><span>{{ $cate->site_class_show_name }}</span></a></li>
                @endforeach
            @endif
        </ul>
    </div>
    <script>
        var site_id = {{ $site->sites_id }}
        var type = '{{ $type }}'
        var active_type = '{{ $active_type}}'
        if (type == 'cate') {
            var url = '/index/get_goods_by_cate'
        } else if (type == 'activity') {
            var url = '/index/get_site_goods'
        } else if (type == 'search') {
            var url = '/index/get_goods_by_search'
            var q = '{{ $active_type}}'
        }

        jQuery(document).ready(function ($) {
            var state = true;
            var page = 1;
            var addprodu = function () {
                $.ajax({
                    type: 'get',
                    url: url + '?site_id=' + site_id + '&page=' + page + '&active_type=' + active_type + '&q=' + q + '&limit=4',
                    success: function (data) {
                        var addli = '';
                        datas = JSON.parse(data)
                        $.each(datas, function (i, item) {
                            addli += '<li style="height: 245px;"><div class="pro-tu"><a href="http://' + item.goods_url + '"><img alt="[' + item.goods_name + ']" src="http://' + item.img_url + '" width="400" height="400"></a></div>'
                                + '<div class="pro-tex">'
                                + '<h3><a href="http://' + item.goods_url + '">' + item.goods_name + '</a></h3>'
                                + '<div class="p3">'
                                + '<div class="price-box"><p class="special-price">'
                                + '<span class="price" id="product-price-46198">' + item.currency + item.goods_real_price + ' </span></p>'
                                + '<p class="old-price">'
                                + '<span class="price" id="old-price-46198">' + item.currency + item.goods_price + ' </span></p>'
                                + '</div>'
                                + '</div>'
                                + '</div></li>'
                        })
                        $('.active_type1').append(addli);
                        jQuery("#load img").css("display", "none");
                        console.log('pr', datas.length)
                        if (datas.length < 4) {
                            console.log('after', datas.length)
                            state = false
                            var bottom = '{!! config("language.index.alreay_bottom.".\App\goods::get_language($site->sites_blade_type)) !!}';
                            jQuery('#load').append("<p style='text-align:center;line-height:25px;font-size:14px;'>" + bottom + "</p>").css({"margin-top": "1px"});
                            console.log("22")
                        } else {
                            state = true;
                            page++;
                        }
                    }
                });
            }
            addprodu()
            jQuery(window).scroll(function () {
                var scrot = jQuery(document).scrollTop() + 100;
                if (scrot >= jQuery(document).height() - jQuery(window).height()) {
                    if (state == true) {
                        state = false;
                        jQuery("#load img").css("display", "block");
                        addprodu()
                    }
                }
            });
        });
    </script>
@endsection