<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/timer.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/swiper-3.4.2.min.css"/>
    
    <script type="text/javascript" src="/js/resizeDIV.js"></script>
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <style>
        .fixed {
            position: fixed !important;
            z-index: 999999999 !important;
            top: 0px !important;
        }
        body{
            max-width: 100%;
        }
        .content{
            margin: 0 auto;
            width: 1190px;
            position: relative;
            zoom: 1;
            overflow: hidden;
        }
        .pc_main {
            color: #666;
            width: 940px;
            float: left;
            margin-top: 20px;
        }
        .pc_sub {
            float: left;
            width: 249px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-left-width: 0;
            background: #f0f0f0;
            color:#333;
        }
        .pc_main .pc_body{
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }
        .pc_head{
            border: 1px solid #ccc;
            zoom: 1;
            overflow: hidden;
        }
        .pc_head_left{
            margin-left: 20px;
            width: 400px;
            float: left;
        }
        .pc_head_right{
            float: left;
            width: 518px;
        }
        /* 轮播图 */
        .pc_slide {
            margin-top: 20px;
            width: 400px;
        }
        .view .swiper-container {
            width: 400px;
            height: 400px;
        }
        .view .swiper-container img {
            width: 400px;
            height: 400px;
        }
        .preview {
            margin: 20px 0 25px 0;
            position: relative;
        }
        .preview .swiper-container {
            margin-left: 35px;
        }
        .preview .swiper-slide {
            width: 50px;
            height: 50px;
            cursor:pointer;
            margin-right: 10px;
        }
        .preview .swiper-slide img{
            width: 50px;
            height: 50px;
        }
        .preview .slide6 {
            width: 50px;
        }
        .preview img {
            padding: 1px;
        }

        .preview .active-nav img {
            padding: 0;
            border: 1px solid #F00;
        }

        .pc_main h1 {
            margin-top: 25px;
            margin-bottom: 7px;
            margin-left: 20px;
            width: 450px;
            line-height: 24px;
            font-size: 14px;
            font-weight: 700;
            color: #1b1b1b;
        }
        .pc_main .pc_status {
            position: relative;
            margin-left: 20px;
        }
        .timebox {
            margin: 0px;
            overflow: hidden;
            line-height: 36px;
            background: #fff;
            border-top: none;
            font-family: "微软雅黑";
            font-size: 14px;
            color: #333333;
            padding-right: 20px;
        }
        .timebox .text {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            float: left;
            padding: 0 10px;
            background: #ff5500;
            text-align: center;
            height: 36px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 100px;
            border-top-left-radius: 0;
            border-top-right-radius: 100px;
        }
        .boxtime font{
            font-size: 14px;
        }
        #timer{
            font-size: 14px;
        }
        .pc_main .pc_operation {
            position: relative;
            margin-top: 20px;
            padding: 5px 20px 20px;
            min-height: 167px;
            margin-bottom: 13px;
            background: url("/img/pc_bg.png") no-repeat right bottom #eee;
            background-size: 100%;
        }
        .pc_money{
            overflow: hidden;
        }
        .pc_money >span{
            float: left;
        }
        .pc_money_1 .title, .pc_money .title {
            margin-right: 10px;
            margin-left: 50px;
            line-height: 46px;
            width: 110px;
            display: inline-block;
            text-align: right;
        }
        .pc_money_1 .title{
            line-height: 49px;
        }
        .pc_operation .pc_money .money {
            font-size: 30px;
            color: #1b1b1b;
            font-weight: 700;
            position: relative;
            top: 5px;
            font-family: Tahoma;
            vertical-align: middle;
        }
        .pc_operation .pc_money_1 .money {
            font-size: 32px;
            color: #8e011d;
            font-weight: 700;
            font-family: Tahoma;
            vertical-align: middle;
        }
        .pc_operation .pc_money_1{
            margin-top: 11px;
            margin-bottom: 15px;
        }
        .pc_main .pc_submit .pc_button span img{
            width: 20px;
            height: 20px;
        }
        .pc_main .pc_submit .pc_button {
            display: inline-block;
            color: #fff;
            background-color: #C41B36;
            border: 1px solid #C41B36;
            width: 240px;
            height: 44px;
            line-height: 44px;
            text-align: center;
            margin-left: 50px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 27px;
            text-decoration: none;
        }
        .pc_button .img{
            position: absolute;
            left: 132px;
            bottom: 16px;
        }
        .pc_activity_title{
            margin: 10px 20px 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #EEE;
            font-size: 20px;
        }
        .pc_activity_content{
            margin: 10px 20px 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            height: 60px;   
        }
        .pc_activity_content div{
            height: 60px;
            text-indent: 2em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .pc_service{
            margin-left: 20px;
        }



        .pc_body .pc_flow {
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid #ccc;
            bottom: -1px;
            z-index: 12;
            height: 55px;
        }
        .pc_body .pc_addition {
            position: relative;
        }
        .pc_addition .detail_bars{
            height: 61px;
            z-index: 161;
            width: 938px;
            background-color: #f6f6f6;
            border-bottom: 1px solid #e6e6e6;
            border-top: 1px solid #e6e6e6;
        }
        .pc_body .detail_bars li {
            float: left;
            display: inline;
            position: relative;
            top: 1px;
            font-weight: 700;
            font-size: 14px;
            padding: 20px 35px;
            border-right: 1px solid #e6e6e6;
            cursor: pointer;
        }
        .pc_body .detail_bars li.current {
            background-color: #fff;
            color: #7f0019;
            border-top: 2px solid #7f0019;
            box-sizing: border-box;
        }
        .pc_body #tab1:hover,.pc_body #tab2:hover,.pc_body #tab3:hover{
            background-color: #fff;
            color: #7f0019;
            border-top: 2px solid #7f0019;
            box-sizing: border-box;
        }
        .pc_body #tab3  {
            background-image: url(//img.alicdn.com/tps/i4/TB1Bin3HXXXXXbRXXXXdyKUFVXX-27-20.gif);
            background-repeat: no-repeat;
            background-position: right 2px;
        }
        .pc_body .pc_detail_tab{
            padding: 0 20px 20px;
        }
        .pc_detail_tab_1 p{
            text-align: center;
        }
        .pc_bottom_logo{
            margin: 0 auto;
            height: 95px;
            width: 990px;
        }
        .pc_bottom_logo img{
            height: 100%;
            width: 100%;
        }
        .footer{
            width: 1190px;
            margin: 0 auto;
            height: 80px;
        }
        .AfterSale{
            background-color: #e8e8e8;
        }
        .AfterSale_1{
            width: 1190px;
            margin: 0 auto;
            
            padding: 20px 60px;
            box-sizing: border-box;
        }
        .AfterSale h4{
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
            color: #C41B36
        }
        .AfterSale p{
            text-align: center;
            line-height: 26px;
        }
        .pc_bottom{
            border-top: 3px solid #808080;
            margin-top: 35px;
            color:#333;
        }
        .footer{
            position: relative;
        }
        .footer img{
            width: 60px;
            margin-top: 10px;
        }
        .footer p{
            position: absolute;
            top: 10px;
            left: 74px;
            line-height: 26px;
            font-size: 12px;
        }


        .pc_sub .pc_query>h4 {
            padding: 12px 0;
            text-align: center;
            font-size: 20px
        }
        .pc_sub input{
            float: left;
            padding: 4px 4px;
            font-size: 12px;
        }
        .pc_sub .textbox{
            overflow: hidden;
            padding: 10px;
            padding-left: 12px;
            padding-right: 0;
        }
        .pc_sub .textbox a{
            float: left;
            display: block;
            height: 26px;
            line-height: 26px;
            text-align:center;
            width: 56px;
            background-color: #C41B36;
            border-radius: 10px;
            color:#fff;
            font-size: 12px;
            margin-left: 10px;
        }
        .pc_query_content{
            padding: 10px;
            /* height: 572px; */
        }
        .pc_query_content h4{
            font-size: 14px
        }
        .pc_query_content p{
            font-size: 12px;
            padding: 6px 0;
        }
        .pc_query_content .product_image{
            width: 130px;
            height: 130px;
            margin: 0 auto;
        }
        .pc_query_content .product_image img{
            width: 130px;
            height: 130px;
        }
        .tihsi{
            margin-top: 14px
        }
        .pc_sub .liuyan{
            padding: 12px;
        }
        .pc_sub .buyinfo_hd{
            font-size: 20px;
            text-align: center;
            font-weight: 900;
            padding-bottom: 6px;
        }
        .pc_sub #stars span{
            color: #f00;
            font-size: 20px;
            cursor: pointer
        }
        .pc_sub .require{
            color: #f00;
        }
        .pc_sub .input01{
            margin-bottom: 14px
        }
        .pc_sub .table_td,.pc_sub #stars{
            padding-bottom: 14px;
        }
        .pc_sub .input_btn01{
            margin-left: 74px;
        }
        .pc_sub .buyinfo_table_box{
            padding-top: 10px;
        }
        .to_top{
            position: fixed;
            bottom: 120px;
            margin-left: auto!important;
            z-index: 11000;
            background-color: #f5f5f5;
            border: 1px solid #ebebeb;
            color: red;
            cursor: pointer;
            display: block;
            width: 38px;
            line-height: 38px;
            text-align: center;
            right: 288px;
        }
        .pc_query_content_1{
            /* height: 384px; */
        }
    </style>
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
                            <!-- <li id="tab3">Reviews({{$goods->goods_comment_num}}+)</li> -->
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