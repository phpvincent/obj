<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="https://cdn.uudobuy.com/ueditor/image/20171019/1508385777747154.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>{{$goods->goods_name}}</title>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link href="/css/mui.min.css" rel="stylesheet">
        <link href="/css/iconfont.css" rel="stylesheet">
        <link href="/css/base.css" rel="stylesheet">
        <link href="/css/component.css" rel="stylesheet">
        <link href="/css/detail.css" rel="stylesheet">
     <!--    <link href="/css/new.css?v=6" rel="stylesheet">
        <link href="/css/shop.css" rel="stylesheet"> -->
       <!--  <link href="/css/total.css" rel="stylesheet">
        <link href="/css/temporary.css" rel="stylesheet"> -->
        <link href="/css/obj.css" rel="stylesheet">
        <link href="/css/timer.css" rel="stylesheet">
<!-- Facebook Pixel Code -->
<!-- End Facebook Pixel Code -->
        <link href="/css/JS5.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/mui.min.js" type="text/javascript"></script>
        <script src="/js/base.js" id="baseScript" path="http://oatsbasf.3cshoper.com"></script>
        <!-- <script src="/js/mui.lazyload.js"></script> -->
        <!-- <script src="/js/shop5.js"></script>
        <script src="/js/ytc.js" async=""></script>
        <script src="/js/bat.js" async=""></script>
        <script async="" src="/js/analytics.js"></script> -->

        <!--产品页轮播-->
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="/js/yxMobileSlider.js"></script>
        <script type="text/javascript" src="/js/icheck.min.js"></script>
        <script type="text/javascript" src="/js/conversion.js"></script>
       <script type="text/javascript" src="/js/resizeDIV.js"></script>
        <script type="text/javascript" src="/js/global.js?v=1.0"></script>
        <script>
        jQuery(function(){setFrom();});
        </script>

        <!-- Facebook Pixel Code -->
        @if($goods->goods_pix!=null&&$goods->goods_pix!='')
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
         fbq('init', '{{$goods->goods_pix}}'); 
        fbq('track', 'PageView');
        </script>
        <noscript>
         <img height="1" width="1" 
        src="https://www.facebook.com/tr?id={{$goods->goods_pix}}&ev=PageView
        &noscript=1"/>
        </noscript>
        @endif
        <!-- End Facebook Pixel Code -->
         <!-- YaHoo Pixel Code -->
        @if($goods->goods_yahoo_pix!=null&&$goods->goods_yahoo_pix!='')
        <script type="application/javascript">(function(w,d,t,r,u){w[u]=w[u]||[];w[u].push({'projectId':'10000','properties':{'pixelId':'{{$goods->goods_yahoo_pix}}'}});var s=d.createElement(t);s.src=r;s.async=true;s.onload=s.onreadystatechange=function(){var y,rs=this.readyState,c=w[u];if(rs&&rs!="complete"&&rs!="loaded"){return}try{y=YAHOO.ywa.I13N.fireBeacon;w[u]=[];w[u].push=function(p){y([p])};y(c)}catch(e){}};var scr=d.getElementsByTagName(t)[0],par=scr.parentNode;par.insertBefore(s,scr)})(window,document,"script","https://s.yimg.com/wi/ytc.js","dotq");</script>
        <script>
            window.dotq = window.dotq || [];
            window.dotq.push(
            {
            'projectId':'10000',
            'properties':{
                'pixelId':'{{$goods->goods_yahoo_pix}}',
                'qstrings':{
                'et':'custom',
                'ea':'ViewProduct',
                'product_id': '{{$goods->goods_id}}',
                }
            }});
        </script>
        @endif
        <!-- End YaHoo Pixel Code -->
        <!-- Global site tag (gtag.js) - Google Analytics -->
          @if($goods->goods_google_pix!=null&&$goods->goods_google_pix!='')
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$goods->goods_google_pix}}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{$goods->goods_google_pix}}');
        </script>
        @endif 
        <!-- End Google Pixel Code -->
        <script>
        jQuery(function(){setFrom();});
        </script>

	</head>
	<body style="">
	<script>
	jQuery(function(){
	   // jQuery.get('/index/swt',function(html){
	    //    var txt = html || '';
	    //   jQuery('body').after(txt); 
	   // });
	var u = "/pay";
	var param = getQueryParam();  
	if(u.indexOf('?')!='-1')
	{
	    if(param != '') u += '&' + param;        
	}   
	else
	{        
	    if(param != '') u += "?" + param;                    
	}  
	jQuery("#payForm").attr('action', u);
	});
	</script>

    <input type="hidden" name="id" value="{{$goods->goods_id}}">
    <div class="mui-content">
    <!--有的地区轮播图需要上传视频，把轮播图抽象到 carousel_figure中 -->
    <link rel="stylesheet" type="text/css" href="/css/swiper-3.4.2.min.css"/>
<!--产品轮播-->
@if(in_array('broadcast',$templets))
<div class="banner">
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
                        <div class="swiper-slide"><img class="banner-img" src="{{$key->img_url}}" style="width: 100%;"  alt="" /></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <ul class="bannerq">
        <li class="bannerqli bactive">視頻</li>
        <li class="bannerqli">圖片</li>
    </ul>
</div>
@endif

<div class="divVideoc1"></div>
<!--产品轮播-->
<script type="text/javascript" src="/js/swiper-3.4.2.jquery.min.js" ></script>
<script src='/js/client.js'></script>
<script type="text/javascript" src="/js/video.js"></script>
        <!--把商品描述部分内容抽象到detail_content中-->
        <div class="clear"></div>

{{--价格栏位--}}
@if(in_array('price',$templets))
<div class="detail-context" style="border-bottom: 1px dashed #dcdcdc;padding:10px 2px;height:50px;">
<div class="dc-price" style="background:#fff;">
        <span class="s-price" style="font-size:24px">
            {{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}{{$goods->goods_price}}        </span>
        @if(in_array('original',$templets))
        <span class="o-price" style="font-size:12px">
            {{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}{{$goods->goods_real_price}}        </span>
        @endif
    </div>
    @if(in_array('free_freight',$templets))
        <span class="flag" style="font-size: 12px;">Gratis biaya pengiriman</span>
    @endif
    @if(in_array('cash_on_delivery',$templets))
        <span class="flag" style="font-size: 12px;">Cash on delivery</span>
    @endif
    @if(in_array('seven_days',$templets))
        <span class="flag" style="font-size: 12px;background:#000;">7 hari masa garansi</span>
    @endif
</div>
@endif
<div class="clear"></div>

{{--快递栏位--}}
@if(in_array('express',$templets))
<div class="detail-7day" style="height:auto; overflow:hidden;padding:8px 5px;border-bottom: 1px dashed #dcdcdc;">
   <span style="font-size:14px;color:#333;line-height:23px;padding:2px 0 2px 30px; background:url(/img/DHL.jpg) 2px center no-repeat;background-size:28px 18px;">DHL</span>
</div>
@endif

{{--抢购模块--}}
@if(in_array('count_down',$templets))
<div class="timebox">
    <div class="text"> Hitung mundur:<span>{{$goods->goods_num}}grup</span></div>
    <div class="boxtime">
        <div class="time" id="timer"><span id="h" class="colon"></span>Jam<span id="m" class="colon"></span>menit<span id="s" class="colon"></span>detik</div>
        <font>Batas akhir:</font>
    </div>
</div>
@endif
<div class="clear"></div>

{{--活动描述--}}
@if(in_array('description',$templets))
<div class="detail-profile">
	<!-- 商品小标题 -->
	<span style="color: rgb(255, 0, 0);">@if(!empty($goods->goods_cuxiao_name))<strong>【{{$goods->goods_cuxiao_name}}】</strong>@endif</span><p style="display: inline-block;">{!! $goods->goods_msg !!}</p>
</div>
@endif

{{--中部导航--}}
@if(in_array('center_nav',$templets))
<ul class="detail-bars">
    @if(in_array('introduce',$templets))
    <li>
        <span href="#detial-context" class="scrollBar" scroll-y="0">Penjelasan produk</span>
    </li>
    @endif
    @if(in_array('specifications',$templets))
    <li>
        <span href="#detial-params" class="scrollBar" scroll-y="50">Spesifikasi produk</span>
    </li>
    @endif
    @if(in_array('evaluate',$templets))
    <li>
        <span href="#detial-appraise" class="scrollBar" scroll-y="85">
        ulasan ({{$goods->goods_comment_num}}+)
        </span>
    </li>
    @endif
</ul>
@endif
        <div class="clear"></div>
        <div class="detail-block" id="detial-context" style="padding-top:10px">
            @if(in_array('video',$templets) && !empty($goods->goods_video))
            <p><video class="edui-upload-video  vjs-default-skin    video-js" controls="" autoplay="autoplay" preload="auto" width="420" height="280" src="{{$goods->goods_video}}" data-setup="{}"><source src="" type="video/mp4"/></video>
            	
			</p>
            @endif
            <p>
               
               {!!$goods->goods_des_html!!}
              
			</p>
        </div>
        <div class="detail-block" id="detial-params">
            <p>
               
               {!!$goods->goods_type_html!!}
              
           </p>
           
        </div>
        <div class="clear">
        </div>
        <div class="detail-block" style="position:relative;padding-bottom:0px;" id="detial-appraise">
            {{--@if($goods->goods_comment_num!=0||$goods->goods_comment_num!=''||$goods->goods_comment_num!=null)--}}
            @if(in_array('commit',$templets))
                        <h4>Ulasan terakhir</h4>
                            <div id="mq">
                    <div id="mq1">        
                    	@foreach($comment as $v)
                                                <div class="appr-title mqc">
                            <span style="color:red">
                                *****{{substr($v->com_phone,-4)}}	                            </span>
                            <span style="color:red; margin:0px 3px">
                                {{$v->com_name}}                            </span>
                            <span>
                            evaluate:
                                <font color="red">
                                    @for($i=0;$i<$v->com_star;$i++)★@endfor                                 </font>
                            </span>
                            <span style="margin-left:3px; font-size:12px">
                                {{$v->com_time}}                            </span>
                        </div>
                        <div class="mqc">
                            <p>
                                <p>{{$v->com_msg}}</p><p>
                                @if(!empty($v->com_img))
                                    @foreach($v->com_img as $kk => $val)
                                <img src="{{$val->com_url}}" title="ClientImages" alt="客户图片"/>  
                                    @endforeach
								@endif                         </p> </p>
                        </div>
                        @endforeach 
                                            </div>
                    <div id="mq2">

                    </div> 
                </div>
               @endif
                        <div class="go-appraise" style=" background:#fff; border:none;">
                <a id="btnAppr" style=" color:#fff; width:300px;">
                  @if($goods->goods_comment_num!=0||$goods->goods_comment_num!=''||$goods->goods_comment_num!=null)    Ulasan Saya    @else Pesan   @endif        </a>
            </div>
                    </div>
        <!--div class="f-adv-img"><img src="http://oatsbasf.3cshoper.com/mobile/images/footer.png"></div-->
        <div class="clear">
        </div>
<div style="padding:0px;padding-bottom: 10px;" class="table_details" id="detial-table">
<table class="data-table">
    {{--用户帮助模块--}}
    @if(in_array('user_help',$templets))
    <tbody>
        @if(in_array('user_know',$templets))
        <tr class="first odd">
            <th colspan="2" style="background-color: #d2d2d2;text-align: left;">·Informasi</th>
        </tr>
        <tr class="first odd">
            <td colspan="2">
                <p>
                Hasil dari penggunaan produk ini sesuai dengan kondisi masing-masing pelanggan dan tidak menjamin bahwa setiap pelanggan dapat mencapai hasil sesuai di promosi. Jika Anda memiliki pertanyaan, silakan hubungi layanan pelanggan online kami atau hubungi kami melalui e-mail(
                                        <a href="mail:rbzjlpra@gmail.com" style="color:#F8770E">rbzjlpra@gmail.com</a>
                                        ) perusahaan kami memiliki hak interpretasi akhir.</p>
            </td></tr>
        @endif
        @if(in_array('apply_goods',$templets))
        <tr class="first odd">
            <th colspan="2" style="background-color: #d2d2d2;text-align: left;">.Cara mengajukan pengambalian barang</th>
        </tr>
        <tr class="first odd">
            <td colspan="2">
            <p>
            1. Pengembalian karena alasan pribadi: dalam 7 hari dari tanggal penerimaan barang silakan hubungi layanan pelanggan online kami atau kirim email ke <a  href="mail:rbzjlpra@gmail.com" style="color:#F8770E">rbzjlpra@gmail.com</a> tanpa mempengaruhi penjualan kedua. Permintaan Anda akan diterima dalam waktu 1-3 hari kerja oleh bagian layanan customer service dan biaya pengiriman yang dikenakan akan ditanggung oleh pelanggan.<br>


             2.Pengembalian karena alasan kualitas: dalam 7 hari dari tanggal penerimaan barang silahkan mengirim email ke ke pusat layanan customer service kami <a href="mail:rbzjlpra@gmail.com" style="color:#F8770E">rbzjlpra@gmail.com</a>, Customer service kami akan merespon permintaan Anda dalam waktu 1-3 hari, biaya pengiriman atas pengembalian barang akan ditanggung oleh pihak kami.</p>
                <!-- <p>1.由於個人原因
                    需自行承擔。</p>產生的退換貨：至收到商品之日起7天內，在不影響二次銷
                    售的情況下請聯繫我們的在線客服或發郵件至
                                        <a href="mail:rbzjlpra@gmail.com" style="color:#F8770E">rbzjlpra@gmail.com</a>
                                        ，售後

                    客服會在收到消息後的1-3個工作日內受理您的請求，退換貨所產生的運費

                <p>
                    2.由於質量原因產生的退換貨：至收到商品之日起7天內，向售後服務中心

                    發送郵件至
                                        <a href="mail:rbzjlpra@gmail.com" style="color:#F8770E">rbzjlpra@gmail.com</a>
                                        ，客服會在收到郵件後的1-3個工作日內受

                    理您的請求，退換貨所產生的運費由我方承擔。
                </p> -->
            </td></tr>
        @endif
        <tr class="first odd">
            <th colspan="2" style="background-color: #d2d2d2;text-align: left;">.Alur Pengembalian barang</th>
        </tr>
        <tr class="first odd">
            <td style="width: 30%;height: 80px;margin: 0px;padding: 0px;"> <p style=""><img src="/images/ydzs.png"></p></td>
            <td colspan="2">
               
               
                <p>Konfirmasi penerimaan barang – Pengajuan pengembalian barang – Berhasil verifikasi – pelanggan mengirim produk return – Produk return diterima di gudang – verfikasi produk return – Pengembalian dana / penggantian produk</p>
                <p>Pengembalian atau penggantian produk silahkan mengisi : Nomor Order, nama lengkap dan nomor HP.</p>
                
            </td>

        </tr>
                <tr class="first odd"></tr>
            </tbody>
        @endif
</table>
<style>
    .footer2{
        display:none;
    }
</style>           <div class="Product_assurance" style="padding:0px; text-align:center; margin-bottom:15px;font-size: 14px; background:#3d69a6; color:#fff; height:40px; line-height:40px; ">
               <a href="javascript:;" style="color:#fff">Product Assurance</a>
           </div>
        </div>
        <div class="clear"></div>
       <!--  <div style="padding:0px;padding-bottom: 40px;">
            <div class="shipping" style="width:100%; background:white;">
                <img src="https://d1lnephkr7mkjn.cloudfront.net/skin/default/images/shipping.jpg" width="100%">
            </div>
            <div style="width:100%; margin-bottom:15px;">
	<img src="https://d1lnephkr7mkjn.cloudfront.net/skin/image/footer.jpg" width="100%" class="footer2">
</div>

<script type="text/javascript" charset="utf-8">
var nav=$2(".detail-bars");var win=$2(window);var sc=$2(document);win.scroll(function(){if(sc.scrollTop()>=$2(".detail-profile").offset().top+45){nav.addClass("fixed")}else{nav.removeClass("fixed")}});		
</script>  -->           <!--line的地址信息-->
                        <!--line的地址信息-->
             <!--  <div class="foot_png" style="width:100%; background:#3d69a6; margin-bottom:15px; padding-top:20px; padding-bottom:20px;">
                <img src="https://d1lnephkr7mkjn.cloudfront.net/skin/default/images/foot.png" width="100%">
              </div>

            <div style="padding:0px; text-align:center;  display:none">
                <a href="http://oatsbasf.3cshoper.com/mobile/page/shop/protocol.jsp" style="color:#666">
                    Privacy protocols                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="http://oatsbasf.3cshoper.com/mobile/page/shop/service.jsp" style="color:#666">
                    Terms of service                </a>
            </div>
        </div>
    </div> -->
    <!--下方三个按钮的样式，抽象到home_bottom_button中-->
@if(in_array('order_nav',$templets))
<div class="mui-bar" style="box-shadow: 0px -1px 1px #dad8d8;margin:0 auto;max-width:640px;">
    @if(in_array('order_select',$templets))
    <span class="query" id="track_online" onclick="location.href='/send?goods_id={{$goods->goods_id}}'" style="width: {{in_array('now_buy',$templets) ? '30%' : '100%'}};background-color: #fff;">
      <img src="/images/filter-2.png" style="">
      <a href="javascript:void(0);">
        <span style="line-height:14px;">Pesanan<br>Cari</span>
      </a>
    </span>
    @endif
    @if(in_array('now_buy',$templets))
    <span class="purchase" data-id="19288071" id="btnPay" style="width: {{in_array('order_select',$templets) ? '68%' : '100%'}};">
		<a href="javascript:void(0);">
			<img src="/images/buy2.png">
			<span>Beli sekarang</span>
		</a>
	</span>
    @endif
	<!-- <span class="service"  id="btnOnline" data-id="19288071">
		<img src="/images/service.png" style="">
		<a href="javascript:void(0);">
			<span style="line-height:14px;">在線<br>客服</span>
		</a>
	</span> -->
</div>
@endif
<!-- <script>
	document.getElementById("LINE").onclick=function(){
		window.location="https://line.me/R/ti/p/%40ajw0872j";
	}
</script> -->
<div style="display:none; position:fixed;z-index:199998; width:100%;text-align:center; height:100%;background: rgba(0, 0, 0, 0.58); padding:0px; bottom:0px; margin:0px;max-width: 640px; " id="imgbg">
    <img style="width:80%; margin:0 auto; vertical-align:middle" id="bigimg">
</div>
<div style="display:none; position:fixed;z-index:99998; width:100%; height:100%; background:black; padding:0px; bottom:0px; margin:0px; opacity:0.7; max-width: 640px;" id="apprbg">
</div>
<div style="width: 100%;max-width:640px;clear: both;position: relative;">
    <div style="display:none; position: fixed; z-index: 99999; width: 90%; height: 500px; padding:0 5%; top: 16%; max-width: 640px;" id="apprDialog">
        <form action="/comment" method="post" id="apprForm">
        	<input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
        	{{csrf_field()}}
            <div class="buyinfo_table">
                <div class="closeBtn">
                    <img src="/img/close.png">
                </div>
                <div class="buyinfo_hd">
                Pesan online                </div>
                <hr class="seperator">
                <div class="buyinfo_table_box">
                    <table>
                        <tbody>
                            <tr>
                                <td class="table_td">
                                    <span class="require">
                                        *
                                    </span>
                                    Nama:
                                </td>
                                <td class="table_cell">
                                    <input type="text" placeholder="Name" class="mui-input-clear input01"
                                    name="name" maxlength="10">
                                </td>
                            </tr>
                                                        <tr>
                                <td class="table_td">
                                    <span class="require">
                                        *
                                    </span>
                                    No. Hanphone:
                                </td>
                                <td class="table_cell">
                                    <input type="text" placeholder="No. Hanphone" class="input01" name="phone"
                                    maxlength="20">
                                    <input type="hidden" name="vis_id" value="{{$vis_id}}">
                                </td>
                            </tr>
                                                        <tr>
                                <td class="table_td">
                                Tingkat kepuasan:
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
                                Pesan:
                                </td>
                                <td class="table_cell">
                                    <textarea placeholder="Pesan online" name="content" class="textarea_style">
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="tc">
                                    <input id="btnAppraise" type="button" name="Submit" class="input_btn01"
                                    value="Kirim ulasan" style="color:white">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script language="javascript">
    function captureImage(a) {
    a.pause(); 
    };
    var videos=$("#detial-context video");
    for(var i=0;i<videos.length;i++){
    videos[i].setAttribute("autoplay","autoplay");
    videos[i].setAttribute("preload","auto");
    videos[i].addEventListener('canplay',captureImage(videos[i]));
    }
    (function($){
        var startDate = new Date('2018/07/16 09:41:27');
        var endDate = new Date('2018/07/16');
        var time=	{{$goods->goods_end}} * 1000;
        endDate.setDate(endDate.getDate() + 1);
        countDown();
        function countDown(){
//var time = endDate.getTime() - startDate.getTime();
            times = Math.floor(time/1000);
            var h = Math.floor(times/3600);
            var m = Math.floor((times%3600)/60);
            var s = (times%3600)%60;
			
            if(h<10) h = "0" + h;
            if(m<10) m = "0" + m;
            if(s<10) s = "0" + s;
            
            $("#timer").html('<span id="h" class="colon">' + h + '</span>'+"h"+'<span id="m" class="colon">' + m + '</span>'+"m"+'<span id="s" class="colon">' + s + '</span>'+"s");
           time=time-1000;
            /*startDate.setTime(startDate.getTime() + 1000);
            if(startDate.getTime()==endDate.getTime()){
                //endDate.setDate(endDate.getDate() + 1);
                return;
            }*/
//            $(".flashprice").html($(".flashprice").html().replace("<i>$</i>", "$"));
            setTimeout(function(){
                countDown();
            }, 1000);
        }
    })(jQuery);
</script>
<script>
$(function(){
    $('#btnPay').on('click',function(){
        try{fbq('track', 'AddToCart');}catch(e){};
    })
        //获取用户浏览记录
        var tjSecond = 0;
        var tjRandom = 0;
        window.setInterval(function () {
            tjSecond ++;
                
        }, 1000);
    // 随机数
    tjRandom = (new Date()).valueOf();
    window.onload = function () {
        var tjArr = localStorage.getItem("jsArr") ? localStorage.getItem("jsArr") : '[]';
        var dataArr = {
            'tjRd' : tjRandom,
            'url' : location.href,
            'refer' : getReferrer()
        };
        tjArr = eval('(' + tjArr + ')');
        tjArr.push(dataArr);
        var tjArr1= JSON.stringify(tjArr);
        localStorage.setItem("jsArr", tjArr1);
    }
    // 用户继续访问根据上面提供的key值补充数据
    window.onbeforeunload = function() {
        var tjArrRd = eval('(' + localStorage.getItem("jsArr") + ')');
        var tjI = tjArrRd.length - 1;
        if(tjArrRd[tjI].tjRd == tjRandom){
            tjArrRd[tjI].time = tjSecond;
            tjArrRd[tjI].timeIn = Date.parse(new Date()) - (tjSecond * 1000);
            tjArrRd[tjI].timeOut = Date.parse(new Date());
            var tjArr1= JSON.stringify(tjArrRd);
            localStorage.setItem("jsArr", tjArr1);
            $.ajax({url:"{{url('/visfrom/settime')}}"+"?id="+{{$vis_id}},async:false});
        }
    };
         function getReferrer() {
            var referrer = '';
            try {
                referrer = window.top.document.referrer;
            } catch(e) {
                if(window.parent) {
                    try {
                        referrer = window.parent.document.referrer;
                    } catch(e2) {
                        referrer = '';
                    }
                }
            }
            if(referrer === '') {
                referrer = document.referrer;
            } 

            return referrer;
        } 
        var from =getReferrer();
        $.ajax({url:"{{url('/visfrom')}}"+"?id="+{{$vis_id}}+"&from="+from,async:false});
    })
  
</script>
<script type="text/javascript" charset="utf-8">
    $2(function() {
        //$2("img").lazyload({effect: "fadeIn"});
        //点击购买
        $2("#btnPay").click(function() {
            try {
                
               
            } catch(e) {}

            var action ='/pay';
           /* var tjArr = localStorage.getItem("jsArr");
            var tjI = tjArrRd.length - 1;*/
            var btime=getNowDate();
            $.ajax({url:"{{url('/visfrom/setbuy')}}"+"?id="+{{$vis_id}}+"&date="+btime,async:false});
            location.href=action;
        });
/*
        $2("#btnOnline").bind(_ONCLICK,
        function() {
            if (fbTrackCart) fbTrackCart();
            openZoosUrl('chatwin');
        });
*/
        $2("#btnQuery").bind(_ONCLICK,
        function() {
            window.location.href = 'query.jsp';
        });

        $2("#btnAppr").bind(_ONCLICK,
        function() {
            $2("#apprbg").show();
            $2("#apprDialog").show();
        });

        $2(".closeBtn").bind(_ONCLICK,
        function() {
            $2("#apprbg").hide();
            $2("#apprDialog").hide();
        });

        $2(".star-item").bind(_ONCLICK,
        function() {
            var level = $2(this).attr("data-id");
            $2("input[name='level']").val(level);
            $2(this).text("★");
            $2(this).nextAll().each(function(index, element) {
                $2(this).text("☆");
            });

            $2(this).prevAll().each(function(index, element) {
                $2(this).text("★");
            });
        });
        function getNowDate() {
         var date = new Date();
         var sign1 = "-";
         var sign2 = ":";
         var year = date.getFullYear() // 年
         var month = date.getMonth() + 1; // 月
         var day  = date.getDate(); // 日
         var hour = date.getHours(); // 时
         var minutes = date.getMinutes(); // 分
         var seconds = date.getSeconds() //秒
         var weekArr = ['星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期天'];
         var week = weekArr[date.getDay()];
         // 给一位数数据前面加 “0”
         if (month >= 1 && month <= 9) {
          month = "0" + month;
         }
         if (day >= 0 && day <= 9) {
          day = "0" + day;
         }
         if (hour >= 0 && hour <= 9) {
          hour = "0" + hour;
         }
         if (minutes >= 0 && minutes <= 9) {
          minutes = "0" + minutes;
         }
         if (seconds >= 0 && seconds <= 9) {
          seconds = "0" + seconds;
         }
         var currentdate = year + sign1 + month + sign1 + day + " " + hour + sign2 + minutes + sign2 + seconds;
         return currentdate;
        }
        $2("#btnAppraise").bind(_ONCLICK,
        function() {
            if ($2("input[name='name']").val() == '') {
                $2.toast("Nama tidak boleh kosong");
                return false;
            }
            if ($2("input[name='phone']").val() == '') {
                $2.toast("No. Handphone tidak boleh kosong");
                return false;
            }
            // var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
            // if (!myreg.test($2("input[name='phone']").val())) {
            //     $2.toast("手機格式错误");
            // }
            var data = {};
            data.level = $2("input[name='level']").val();
            data.product_id = '103107897';
            data.name = $2("input[name='name']").val();
            data.phone = $2("input[name='phone']").val();
            data.options = $2("input[name='options']").val();
            data.content = $2("textarea[name='content']").val();
            data._token = $2("input[name='_token']").val();
            data.goods_id = $2("input[name='goods_id']").val();
            data.vis_id=$2("input[name='vis_id']").val();
            var url = $2("#apprForm").attr("action");

            jQuery.post(url,data,function(html){
                /*var arr = jQuery.parseJSON(html);*/
                if(html.status==true)
                {
                    $2.toast("Terima kasih atas pendapat Anda");
                }
                else
                {
                    $2.toast("gagal dikirim");
                }
                $2("#apprbg").hide();
                $2("#apprDialog").hide(500);
            });
        });

        $2(".mqc img").bind(_ONCLICK,
        function() {
            $2("#bigimg").attr("src", $2(this).attr("src"));
            $2("#imgbg").show();
        });

//                $2(".product_discuss img").bind(_ONCLICK,
//                function() {
//                    $2("#bigimg").attr("src", $2(this).attr("src"));
//                    $2("#imgbg").show();
//                });

        $2("#imgbg").bind(_ONCLICK,
        function() {
            $2("#imgbg").hide();
        });

        $2(".scrollBar").bind(_ONCLICK,
        function() {
            var y = $2(this).attr("scroll-y");
            $2('html, body').animate({
                scrollTop: $2($2(this).attr("href")).offset().top - y
            },
            1000);
        });

        var nav = $2(".detail-bars"); //得到导航对象
        var win = $2(window); //得到窗口对象
        var sc = $2(document); //得到document文档对象。
        /*
        win.scroll(function() {
            if (sc.scrollTop() >= $2(".detail-profile").offset().top + 45) {
                nav.addClass("fixed");
            } else {
                nav.removeClass("fixed");
            }
        });*/
        try{
            var speed = 35; //数字越大速度越慢
            var tab = document.getElementById("mq");
            var tab1 = document.getElementById("mq1");
            var tab2 = document.getElementById("mq2");

            tab2.innerHTML = tab1.innerHTML; //克隆demo1为demo2
            function Marquee() {
                if (tab2.offsetTop - tab.scrollTop <= 0) { //当滚动至demo1与demo2交界时
                    tab.scrollTop -= tab1.offsetHeight; //demo跳到最顶端
                } else {
                    tab.scrollTop++;
                }
            }
        }
        catch(e){}

        var MyMar = setInterval(Marquee, speed);
        var isrun = true;
        $2("#mq").bind(_ONCLICK,
        function() {
            if (isrun) {
                clearInterval(MyMar);
            } else {
                MyMar = setInterval(Marquee, speed);
            }
            isrun = !isrun;
        });

        $2(".edui-upload-video").each(function(index, element) {
            if ($2("#videoPoster").length > 0) {
                $2(this).attr("poster", $2("#videoPoster").attr("href"));
                $2(this).height($2(this).width() / 640 * 360);
                //alert($2("#videoPoster").height());
                //$2(this).height($2("#videoPoster").height());
                $2("#videoPoster").remove();
            }
        });
    });
</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = '';
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    if ('' != '') {
        google_conversion_id = parseInt('');
    }
    /* ]]> */
</script>
<script>
        /*(function(w, d, t, r, u) {
            var f, n, i;
            w[u] = w[u] || [],
            f = function() {
                var o = {
                    ti: ""
                };
                o.q = w[u],
                w[u] = new UET(o),
                w[u].push("pageLoad")
            },
            n = d.createElement(t),
            n.src = r,
            n.async = 1,
            n.onload = n.onreadystatechange = function() {
                var s = this.readyState;
                s && s !== "loaded" && s !== "complete" || (f(), n.onload = n.onreadystatechange = null)
            },
            i = d.getElementsByTagName(t)[0],
            i.parentNode.insertBefore(n, i)
        })(window, document, "script", "//bat.bing.com/bat.js", "uetq");*/
</script>
<div style="width:0px; height:0px; display:none; visibility:hidden;" id="batBeacon0.49706517370977843">
</div>
<div class="sogoutip" style="z-index: 2147483645; visibility: hidden; display: none;">
</div>
<div class="sogoubottom" id="sougou_bottom" style="display: none;">
</div>
<div id="ext_stophi" style="z-index: 2147483647;">
    <div class="extnoticebg">
    </div>
</div>
<div id="ext_overlay" class="ext_overlayBG" style="display: none; z-index: 2147483646;">
</div>
<!--商品介绍  商品参数处按钮的固定-->
<script type="text/javascript" charset="utf-8">
    var nav=$2(".detail-bars");var win=$2(window);var sc=$2(document);win.scroll(function(){if(sc.scrollTop()>=$2(".detail-profile").offset().top+45){nav.addClass("fixed")}else{nav.removeClass("fixed")}});
</script>
<script>
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
</script>
<script src="/js/Validform.min.js"></script>
<script>
    var form=jQuery("form").Validform({
        tiptype:function(msg){
            $2.toast(msg);
        },
        datatype:{
            "z6-18": /^[\S\s]{6,18}$/,
        },
        beforeSubmit:function(){
            if(jQuery("input[name='data']").val() == undefined){
                alert('Incomplete data,Form validation error!');
                return false;
            }
            				var vname = /先生|小姐|太太|男士|女士|退貨|換貨|退货|换货|(^.$)/;
				if(vname.test(jQuery("input[name='firstname']").val())){
					alert("請填寫您的真實姓名");
					return false;
				}
				if(_checkBlackName(jQuery("input[name='firstname']").val())){
					alert("無效的名字");
					return false;
				}
			            if(jQuery("select[name='state6']").val()==""){
                alert('請選取縣市');
                return false;
            }
            jQuery('#pay').attr('disabled',true);
            return true;
        },
        tipSweep:true
    });
    form.tipmsg.r="訂單提交中...";


jQuery('input[name=pay_type]').change(function(){
    var id = jQuery('input[name=pay_type]:checked').val() || 0;
    //stripe是ajax支付
    if(id == 10 || id == 11 || id==13)
    {
        _data = '';
        form.config({
            ajaxPost:true,
            callback:function(data){
                _data = data;
                if( id==10 || id==13)
                {
                    var token = data.stripeToken || '';
                    jQuery("#pay").show();
                    jQuery("#applepay").hide();
                    jQuery.post('/stripe/callback?stripeToken='+token,data,function(html){
                            var res = jQuery.parseJSON(html);
                            if(res.status=='ok')
                            {
                                location.href = res.url;
                            }
                            else
                            {
                                $2.toast(res.errormsg);
                                jQuery("#pay").removeAttr('disabled');
                            }
                    });
                }
                if( id==11 )
                {
                    jQuery('input[type=text]').change(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('input[type=text]').focus(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('input[type=text]').blur(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery('.mui-btn').click(function(){
                            jQuery("#pay").show();
                            jQuery("#applepay").hide();
                    });
                    jQuery("#pay").hide();
                    jQuery("#applepay").show();
                    _data = data;
                }
            },
        });
    }
    //其他的正常请求
    else
    {
        jQuery("#pay").show();
        jQuery("#applepay").hide();
        form.config({
            ajaxPost:false
        });
    }
});
</script>
<style>
    .detail-bars li {
        width: {{$center_nav==1 ? '100%' : ($center_nav==2 ? '50%' : '32%') }} !important;
    }
</style>
<!-- <script language="javascript" src="/js/LsJS.aspx"></script> --></body>
</html>