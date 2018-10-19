<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/timer.css" rel="stylesheet">
    <link href="/css/googlePC_index.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/swiper-3.4.2.min.css"/>
    <script type="text/javascript" src="/js/resizeDIV.js"></script>
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div id="page">
        <div></div>
        <div></div>
        <div class="content">
            <div class="pc_main">
                <div class="pc_head">
                    <div class="pc_head_left">
                        @if(in_array('broadcast',$templets))
                            <!-- <div class="banner">
                                <div class="swiper-container" id="mySwiper1">
                                    <div class="swiper-wrapper">
                                        @if($goods->goods_fm_video!=null&&$goods->goods_fm_video!='')
                                        <div class="swiper-slide" id="swiper-slide">
                                            <video id="divVideo" x5-video-player-type="h5" x5-video-player-fullscreen="true" controls="controls" webkit-playsinline="webkit-playsinline" playsinline="playsinline"  muted="muted" preload="true" autoplay="true" loop="loop" style="object-fit: fill;">
                                                <source src="{{$goods->goods_fm_video}}" type="video/mp4">
                                            </video>
                                        </div>
                                        @endif
                                        @foreach($imgs as $key)
                                                    <div class="swiper-slide"><img class="banner-img" src="{{$key->img_url}}"  style="width: 100%;"  alt="" /></div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <ul class="bannerq">
                                    <li class="bannerqli bactive">视频</li>
                                    <li class="bannerqli">图片</li>
                                </ul>
                            </div> -->
                            <div class="pc-slide">
                                <div class="view">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            @if($goods->goods_fm_video!=null&&$goods->goods_fm_video!='')
                                            <div class="swiper-slide" id="swiper-slide">
                                                <video id="divVideo" x5-video-player-type="h5" x5-video-player-fullscreen="true" controls="controls" webkit-playsinline="webkit-playsinline" playsinline="playsinline"  muted="muted" preload="true" autoplay="true" loop="loop" style="object-fit: fill;">
                                                    <source src="{{$goods->goods_fm_video}}" type="video/mp4">
                                                </video>
                                            </div>
                                            @endif
                                            @foreach($imgs as $key)
                                            <div class="swiper-slide">
                                                <img src="{{$key->img_url}}" alt="">
                                            </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="preview">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            @if($goods->goods_fm_video!=null&&$goods->goods_fm_video!='')
                                            <div class="swiper-slide slide6" id="output">
                                                    <!-- <img src="/images/ydzs.png" alt=""> -->
                                            </div>
                                            @endif
                                            @foreach($imgs as $key)
                                            <div class="swiper-slide slide6">
                                                    <img src="{{$key->img_url}}" alt="">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="pc_head_right">
                        <h1>{{$goods->goods_name}}</h1>
                        <div class="pc_status">
                            <div class="timebox">
                                <div class="text">Stock:<span>{{$goods->goods_num}}</span></div>
                                <div class="boxtime">
                                    <div class="time" id="timer"><span id="h" class="colon"></span>h<span id="m" class="colon"></span>m<span id="s" class="colon"></span>s</div>
                                    <font>End:</font>
                                </div>
                            </div>
                        </div>
                        <div class="pc_operation">
                            <div class="pc_money">
                                @if(in_array('original',$templets))
                                <span class="title"><strong>Original price</strong></span>
                                <span class="money">
                                   {{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}{{$goods->goods_real_price}}     
                                </span>
                                @else
                                <span class="money">{{$goods->goods_name}}</span>
                                @endif

                            </div>
                            <div class="pc_money_1">
                                <span class="title"><strong>Price</strong></span>
                                <span class="money">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}{{$goods->goods_price}}</span>
                            </div>
                            <div class="pc_submit">
                                <a href="#" class="pc_button">
                                    <span class="img"><img src="/images/buy2.png"></span>
                                    <span>Buy Now</span>
                                </a>
                            </div>
                        </div>
                        <div class="pc_activity">
                            <div class="pc_activity_title">@if(!empty($goods->goods_cuxiao_name))<strong>【{{$goods->goods_cuxiao_name}}】</strong>@endif</div>
                            <div class="pc_activity_content">
                                <div>
                                    {!! $goods->goods_msg !!}
                                </div>
                            </div>
                        </div>
                        <div class="pc_service">
                            <div class="detail-7day" style="height:auto; overflow:hidden;font-size: 16px;margin-top: 10px;">
                                @if(in_array('express',$templets))
                                <span style="font-size:14px;color:#333;line-height:22px;padding:2px 0 2px 30px; background:url(/img/DHL.png) 2px center no-repeat;background-size:34px 18px;"> &nbsp;&nbsp;&nbsp;DHL</span>
                                @endif
                            </div>
                                
                            <div style="height: 27px;margin-top: 5px;line-height: 27px">
                                <div class="detail-context" style="">
                                        
                                        @if(in_array('free_freight',$templets))
                                        <span class="flag" style="font-size: 14px;">Free shipping</span>&nbsp;&nbsp;
                                        @endif
                                        @if(in_array('cash_on_delivery',$templets))
                                        <span class="flag" style="font-size: 14px;">Cash on delivery</span>&nbsp;&nbsp;
                                        @endif
                                        @if(in_array('seven_days',$templets))
                                        <span class="flag" style="font-size: 14px;">14 days appreciation period</span>
                                        @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pc_body">
                    <div class="pc_flow">
                        <img src="/img/pc_kuaidi.jpg" alt="">
                    </div>
                    <div class="pc_addition">
                        {{--中部导航--}}
                        @if(in_array('center_nav',$templets))
                        <ul class="detail_bars"> 
                            @if(in_array('introduce',$templets))
                                <li id="tab1"class="current">Overview</li>
                            @endif
                            @if(in_array('specifications',$templets))
                                <li id="tab2">Details</li>
                            @endif
                            @if(in_array('evaluate',$templets))
                            <li id="tab3">Reviews({{$goods->goods_comment_num}}+)</li>
                            @endif
                        </ul>
                        @endif
                        <div class="pc_detail_tab">
                            <div class="pc_detail_tab_1" id="detial-context" style="">
                                @if(in_array('video',$templets) && !empty($goods->goods_video))
                                <p style="text-align: center;"><video class="edui-upload-video  vjs-default-skin    video-js" controls="" autoplay="autoplay" preload="auto" width="520" height="380" src="{{$goods->goods_video}}" data-setup="{}"><source src="" type="video/mp4"/></video>
                                </p>
                                @endif
                                <p  style="text-align: center;">
                                    
                                    {!!$goods->goods_des_html!!}
                                    
                                </p>
                            </div>
                            <div class="pc_detail_tab_2"style="display: none;">
                                <p>
                                    {!!$goods->goods_type_html!!}     
                                </p>
                            </div>
                            <div class="pc_detail_tab_3"style="display: none;">
                                    {{-- @if($goods->goods_comment_num!=0||$goods->goods_comment_num!=''||$goods->goods_comment_num!=null)--}}
                                    @if(in_array('commit',$templets))
                                    <!-- <h4>最新评价</h4> -->
                                    <div id="mq">
                                        <div id="mq1">        
                                            @foreach($comment as $v)
                                                <div class="appr-title mqc">
                                                    <span style="color:red">*****{{substr($v->com_phone,-4)}}</span>
                                                    <span style="color:red; margin:0px 3px">{{$v->com_name}}</span>
                                                    <span>Rating:<font color="red"> @for($i=0;$i<$v->com_star;$i++)★@endfor</span>
                                                    <span style="margin-left:3px; font-size:12px">{{$v->com_time}}</span>
                                                </div>
                                                <div class="mqc">
                                                    <p>
                                                        <p>{{$v->com_msg}}</p>
                                                        <p>
                                                            @if(!empty($v->com_img))
                                                            @foreach($v->com_img as $kk => $val)
                                                            <img src="{{$val->com_url}}" title="客户图片" alt="客户图片"/>  
                                                            @endforeach
                                                            @endif                         
                                                        </p> 
                                                    </p>
                                                </div>
                                                @endforeach 
                                            </div>
                                            <div id="mq2">
                        
                                            </div> 
                                        </div>
                                       @endif
                                    <div class="go-appraise" style=" background:#fff; border:none;">
                                        <a id="btnAppr" style=" color:#fff; width:300px;">
                                          @if($goods->goods_comment_num!=0||$goods->goods_comment_num!=''||$goods->goods_comment_num!=null)    我要评价     @else 给我们留言   @endif        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pc_sub">
                <div class="pc_query">
                    <h4>Order Inquiry</h4>
                    <p style="padding: 0 4px;font-size: 12px;">Order Number/Logistics Order Number (please fill in for query)</p>
                    <div>
                        <div class="textbox">
                            <form id="queryForm" action="/product/trackingform" method="post">
                                <input name="queryNo" value="" id="txtkey" class="" placeholder="" type="text">
                            </form>
                            <a id="btnQuery">Query</a>
                        </div>
                    </div>
                    <div class="pc_query_content">
                        <div class="pc_query_content_1">
                                <div class="product_image">
                                        <!-- <img src=""> -->
                                    </div>
                                    <div class="check_show">
                                        <h4>Product Name:</h4>
                                        <p>&nbsp;</p>
                                        <h4><b>Your order number:</b></h4>
                                        <p>&nbsp;</p>
                                        <h4><b>Your order status:</b></h4>
                                        <p>&nbsp;</p>
                                        <h4><b>Logistics Company:</b></h4>
                                        <p>&nbsp;</p>
                                        <h4><b>Order number / Logistics order number (please fill in one entry for enquiries):</b></h4>
                                        <p>&nbsp;</p>
                                    </div>
                        </div>

                        <div class="tihsi">
                            <strong>Kindly Reminder:</strong>
					        If you have any questions about our product, please contact our online Customer Service Team or send email to hyfhdcjn@gmail.com attached your name, contacts and order number. We will process it ASAP. Wish you a pleasant shopping here.
                        </div>
                    </div>
                </div>
                <div class="liuyan">
                    <form action="/comment" method="post" id="apprForm">
                        <input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
                        {{csrf_field()}}
                        <div class="buyinfo_table">
                        <hr class="seperator">
                            <div class="buyinfo_hd">
                                Online message                
                            </div>
                            
                            <div class="buyinfo_table_box">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="table_td">
                                                <span class="require">
                                                    *
                                                </span>
                                                Name:
                                            </td>
                                            <td class="table_cell">
                                                <input type="text" placeholder="Name" class=" input01"
                                                name="name" maxlength="10">
                                            </td>
                                        </tr>
                                                                    <tr>
                                            <td class="table_td">
                                                <span class="require">
                                                    *
                                                </span>
                                                Email:
                                            </td>
                                            <td class="table_cell">
                                                <input type="text" placeholder="required:Please fill in email" class="input01" name="phone"
                                                maxlength="20">
                                                <input type="hidden" name="vis_id" value="{{$vis_id}}">
                                            </td>
                                        </tr>
                                                                    <tr>
                                            <td class="table_td">
                                                Rating:
                                            </td>
                                            <td class="table_cell">
                                                <div class="star" id="stars">
                                                    <span class="star-item" data-id="1">
                                                        ★
                                                    </span>
                                                    <span class="star-item" data-id="2">
                                                        ★
                                                    </span>
                                                    <span class="star-item" data-id="3">
                                                        ★
                                                    </span>
                                                    <span class="star-item" data-id="4">
                                                        ★
                                                    </span>
                                                    <span class="star-item" data-id="5">
                                                        ★
                                                    </span>
                                                </div>
                                                <input type="hidden" name="level" value="5">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table_td">
                                                leave word:
                                            </td>
                                            <td class="table_cell">
                                                <textarea placeholder="Online message " name="content" class="textarea_style"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="tc">
                                                <input id="btnAppraise" type="button" name="Submit" class="input_btn01"
                                                value="Submit" style="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        <div class="pc_bottom">
                <div class="pc_bottom_logo">
                        <img src="/img/pc_fuwu.jpg" alt="">
                </div>
                <div  class="AfterSale">
                    <div class="AfterSale_1">
                        @if(in_array('user_help',$templets))
                            @if(in_array('user_know',$templets))
                                <div>
                                    <h4>Contact Us</h4>
                                    <p> 24H Online Customer Service: <a href="javascript:void(0);"><img src="https://d1lnephkr7mkjn.cloudfront.net/skin/image/service.png" style=" width:15px; height:auto;"></a>
                <br>Email:

                                <a  href="mailto:isnfclpo@gmail.com" style="color:#F8770E">isnfclpo@gmail.com</a>
                                <br>
                                Questions, comments and requests regarding the website policies are welcomed and should be addressed to isnfclpo@gmail.com. Please feel free to contact our Customer Care Team for assistance. </p>
                                </p></div>
                            @endif
                            @if(in_array('apply_goods',$templets))
                                <!-- <div>
                                    <h4>如何申请退换货</h4>
                                    <p>1.由于个人原因产生的退换货：至收到商品起7天内，在不影响二次销售的情况下请联系我们的在线客服或发邮件至
                                            <a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>
                                            ，售后客服会在收到消息后的1-3个工作日内受理您的请求，退换货所产生的运费需自行承担。
                                    </p>
                                    <p>
                                    2.由于质量原因产生的退换货：至收到商品之日起7天内，向售后服务中心发送邮件至
                                                            <a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>
                                                            ，售后客服会在收到消息后的1-3个工作日内受理您的请求，退换货所产生的运费由我方承担。
                                    </p>
                                </div> -->
                            @endif
                            @if(in_array('exchange_of_goods',$templets))
                                <div>
                                    <h4>RETURENS POLICY </h4>
                                    <p>Receipt confirmation—Apply for returns/exchanges—Confirmation by customer service-Ship the item back-Delivered to warehouse—Inspection--- Refund/Exchange.
                                    </p>
                                    <p>Please attach with the Order No., Contact No., and Customer name.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="footer">
                    <img src="/images/ydzs.png" alt="">
                    <p>ZSSHOP, known as "Strictly Selected Mall", insists on its usual precise attitude for selection of products origin, workmanship and raw materials of all goods adhering to strict criteria including clothing, shoes, bags, houseware, kitchenware and sportswear in order to satisfy our customers with the best products pursuing to the excellent quality.</p>
                </div>
            </div>
    </div>
    <div class="to_top" onclick="totop()">
        Top
    </div>
</body>
<script type="text/javascript" src="/js/swiper-3.4.2.jquery.min.js" ></script>
<script src='/js/client.js'></script>
<script type="text/javascript" src="/js/video.js"></script>
<script>
(function(){
    var video, output;
    var scale = 0.8;
    var initialize = function() {
    output = document.getElementById("output");
    video = document.getElementById("divVideo");
    video.addEventListener('loadeddata',captureImage);
    };

    var captureImage = function() {
            var canvas = document.createElement("canvas");
            canvas.width = video.videoWidth * scale;
            canvas.height = video.videoHeight * scale;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            var img = document.createElement("img");
            img.src = canvas.toDataURL("image/png");
            output.appendChild(img);
    };

    initialize();
})();
    // 轮播图
var viewSwiper = new Swiper('.view .swiper-container', {
	onSlideChangeStart: function() {
		    updateNavPosition()
	}
})

$('.view .arrow-left,.preview .arrow-left').on('click', function(e) {
	e.preventDefault()
	if (viewSwiper.activeIndex == 0) {
		viewSwiper.slideTo(viewSwiper.slides.length - 1, 1000);
		return
	}
	viewSwiper.slidePrev()
})
$('.view .arrow-right,.preview .arrow-right').on('click', function(e) {
	e.preventDefault()
	if (viewSwiper.activeIndex == viewSwiper.slides.length - 1) {
		viewSwiper.slideTo(0, 1000);
		return
	}
	viewSwiper.slideNext()
})

var previewSwiper = new Swiper('.preview .swiper-container', {
	//visibilityFullFit: true,
	slidesPerView: 'auto',
	allowTouchMove: false,
	onTap: function() {
		    viewSwiper.slideTo(previewSwiper.clickedIndex)
	}
})

function updateNavPosition() {
		$('.preview .active-nav').removeClass('active-nav')
		var activeNav = $('.preview .swiper-slide').eq(viewSwiper.activeIndex).addClass('active-nav')
		if (!activeNav.hasClass('swiper-slide-visible')) {
			if (activeNav.index() > previewSwiper.activeIndex) {
				var thumbsPerNav = Math.floor(previewSwiper.width / activeNav.width()) - 1
				previewSwiper.slideTo(activeNav.index() - thumbsPerNav)
			} else {
				previewSwiper.slideTo(activeNav.index())
			}
		}
	}
    (function($){
        var startDate = new Date('2018/07/16 09:41:27');
        var endDate = new Date('2018/07/16');
        var time=	{{$goods->goods_end}} * 1000;
        endDate.setDate(endDate.getDate() + 1);
        countDown();
        function countDown(){
            times = Math.floor(time/1000);
            var h = Math.floor(times/3600);
            var m = Math.floor((times%3600)/60);
            var s = (times%3600)%60;
			
            if(h<10) h = "0" + h;
            if(m<10) m = "0" + m;
            if(s<10) s = "0" + s;
            
            $("#timer").html('<span id="h" class="colon">' + h + '</span>'+"h"+'<span id="m" class="colon">' + m + '</span>'+"m"+'<span id="s" class="colon">' + s + '</span>'+"s");
           time=time-1000;
            setTimeout(function(){
                countDown();
            }, 1000);
        }
    })(jQuery);
    var nav=$(".detail_bars");
    var win=$(window);
    var sc=$(document);
    win.scroll(function(){
        if(sc.scrollTop()>=$(".pc_addition").offset().top+45){
            nav.addClass("fixed");
        }else{
            nav.removeClass("fixed");
        }
    });
    (function(){
        /* 图片显示画面 */
        function captureImage(a) {
            a.pause();       
        };
        var videos=$("#detial-context video");
        for(var i=0;i<videos.length;i++){
            videos[i].setAttribute("autoplay","autoplay");
            videos[i].setAttribute("preload","auto");
            videos[i].addEventListener('canplay',captureImage(videos[i]));
        }
    })();
    $(function(){
        $('#detial-context p a').each(function(index,ele){
            var con_a = $(this).attr('href');
            if(con_a.length>0){
                if(con_a.indexOf("http://") ==-1){
                    $(this).attr('href','http://'+con_a);
                }
            }
        });
    });
    $("#tab1").on("click",function(){
        $(".detail_bars li").removeClass("current");
        $(this).addClass("current");
        $(".pc_detail_tab_1").show();
        $(".pc_detail_tab_2").hide();
        $(".pc_detail_tab_3").hide();
    })
    $("#tab2").on("click",function(){
        $(".detail_bars li").removeClass("current");
        $(this).addClass("current");
        $(".pc_detail_tab_2").show();
        $(".pc_detail_tab_1").hide();
        $(".pc_detail_tab_3").hide();
    })
    $("#tab3").on("click",function(){
        $(".detail_bars li").removeClass("current");
        $(this).addClass("current");
        $(".pc_detail_tab_3").show();
        $(".pc_detail_tab_2").hide();
        $(".pc_detail_tab_1").hide();
    });
    // 评论提交
    $(".star-item").bind("click",
    function(){
            var level = $(this).attr("data-id");
            $("input[name='level']").val(level);
            $(this).text("★");
            $(this).nextAll().each(function(index, element) {
                $(this).text("☆");
            });

            $(this).prevAll().each(function(index, element) {
                $(this).text("★");
            });
    });
    $("#btnQuery").bind("click",
        function() {
            // window.location.href = 'query.jsp';
        });

        $("#btnAppr").bind("click",
        function() {
            $("#apprbg").show();
            $("#apprDialog").show();
        });

        $(".closeBtn").bind("click",
        function() {
            $("#apprbg").hide();
            $("#apprDialog").hide();
        });
    $("#btnAppraise").bind("click",
        function() {
            if ($("input[name='name']").val() == '') {
                alert("Name cannot be empty");
                
                return false;
            }
            var res = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;//邮箱
            if(!res.test($("input[name='phone']").val())){
                alert("Please enter your email address.");
                return false;
            }
            var data = {};
            data.level = $("input[name='level']").val();
            data.product_id = '103107897';
            data.name = $("input[name='name']").val();
            data.phone = $("input[name='phone']").val();
            data.options = $("input[name='options']").val();
            data.content = $("textarea[name='content']").val();
            data._token = $("input[name='_token']").val();
            data.goods_id = $("input[name='goods_id']").val();
            data.vis_id=$("input[name='vis_id']").val();
            var url = $("#apprForm").attr("action");

            jQuery.post(url,data,function(html){
                /*var arr = jQuery.parseJSON(html);*/
                if(html.status==true)
                {
                    alert("Thanks For Your Review！");
                }
                else
                {
                    alert("Submission fails！");
                }
                $("#apprbg").hide();
                $("#apprDialog").hide(500);
            });
        });
    //页面置顶
    function totop(){
        document.documentElement.scrollTop = document.body.scrollTop =0;
    }
    // 查询订单
    $("#btnQuery").click(function(e) {
			if($("input[name='queryNo']").val()==''){
				alert('Order number / Logistics order number (please fill in one entry)');
				return;
			}
            $("#queryForm").submit();
    });
    $('#queryForm').bind('submit',function(){
        	 $.ajax({
                url:"{{url('/getsendmsg')}}",
                type:'post',
                data:{'msg':$("input[name='queryNo']").val(),'_token':"{{csrf_token()}}"},
                datatype:'html',
                success:function(msg){

                	if(msg!='false'){
                		  $('.pc_query_content_1').html(msg);
                	}else{
                		  $('.pc_query_content_1').html("<span style='color:#f00;'>Order number error, no corresponding information, please re-enter</span>");
                	}
                    // window.setTimeout("window.location='{{url('admin/contro/index')}}'",2000);       
                }
            })
        	 return false;
    })
</script>
</html>