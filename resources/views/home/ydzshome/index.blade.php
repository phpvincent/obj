@extends('home.ydzshome.header')
@section('content')
<div class="std"><p>
</p></div>
@if(count($banners)>0)
<div class="addWrap">
<div class="swipe" id="mySwipes" style="visibility: visible;">
<div class="swipe-wrap">
    @foreach($banners as $banner)
    <div><a @if($banner->site_goods_id) href="/goods/{{ $banner->site_goods_id }}" @else href="" @endif><img class="img-responsive" src="{{ $banner->site_img }}" alt=""></a></div>
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
<li><a href="/women-dress.html"><img class="img-responsive" src="picture/jog-150x168.jpg" alt=""></a></li>
<li><a href="/lady-bags.html"><img class="img-responsive" src="picture/wer-150x168.jpg" alt=""></a></li>
<li><a href="/women-shoes.html"><img class="img-responsive" src="picture/kuiui-150x168.jpg" alt=""></a></li>
<li><a href="/underwear.html"><img class="img-responsive" src="picture/twny-150x168.jpg" alt=""></a></li>
<li><a href="/3c.html"><img class="img-responsive" src="picture/asd-150x168.jpg" alt=""></a></li>
<li><a href="/men-wear.html"><img class="img-responsive" src="picture/jgui-150x168.jpg" alt=""></a></li>
<li><a href="/m-package.html"><img class="img-responsive" src="picture/yuh-150x168.jpg" alt=""></a></li>
<li><a href="/new-men-shoes.html"><img class="img-responsive" src="picture/jguk-150x168.jpg" alt=""></a></li>
<li><a href="/kitchen-supplies.html"><img class="img-responsive" src="picture/jiaju-150x168.jpg" alt=""></a></li>
<li><a href="/women-dress.html"><img class="img-responsive" src="picture/eew-150x168.jpg" alt=""></a></li>
</ul>
</div>
</div>
<div class="djs">
<div class="djstu1">
<a href="/cate/">
<img src="{{  }}" width="308" height="380">
</a>
</div>
<div class="djstu2">
<div class="djs01">
<a href="/best-selling.html">
<img src="picture/jop2.jpg" width="308" height="190">
</a>
</div>
<div class="djs02">
<a href="/new-product.html ">
<img src="picture/jop1.jpg" width="308" height="190">
</a>
</div>
</div>
</div><div class="cp_fl">
</div>
<div class="newsale-title">
<div class="newsale_r">
限量搶購中
</div>
</div>
<div class="new-sale-big">
<a href="/tooxie.html"><img src="picture/xinpin.jpg" /></a>
</div> <div class="clear"></div>
<div class="home_category_list">
<ul class="prolist">
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/xiushen-niuzaiku.html"><img src="picture/2_1_8.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/xiushen-niuzaiku.html">新款女修身小腳牛仔褲 【加$400再來一件】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,298</span>
<span class="oldprice">NT$ 3,998</span>
</div>
</div>
</li>
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/500-59678.html"><img src="picture/711ok51h722k55y9g2gu981p281_1_.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/500-59678.html">韓版氣質針織網紗拼接連衣裙【第二件僅$500】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,380</span>
<span class="oldprice">NT$ 2,760</span>
</div>
</div>
</li>
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/v-1381.html"><img src="picture/4n15t515op76t4g83wt1uui1b601.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/v-1381.html">【爆紅款】時尚V領長袖針織開衫【第二件僅需$300】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,380</span>
<span class="oldprice">NT$ 3,998</span>
</div>
</div>
</li>
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/poscilla-500.html"><img src="picture/o15ww9w6o17m55oz071uqwr658banner2.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/poscilla-500.html">POSCILLA針織拼接連衣裙【第二件僅售$500】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,360</span>
<span class="oldprice">NT$ 3,620</span>
</div>
</div>
</li>
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/400-59657.html"><img src="picture/006a73f19cd4614d8b1f9643cd91f57b.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/400-59657.html">高腰甜美雪紡網紗百褶裙【第二件僅400】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,260</span>
<span class="oldprice">NT$ 4,200</span>
</div>
</div>
</li>
<li>
<div class="pro-tu">
<a href="https://www.vivishop.tw/cotton-and-linen-pants.html"><img src="picture/f70a2dfc933f46cd13be90160b55b6e3.jpg" width="400" height="400" alt=""/></a>
</div>
<div class="pro-tex">
<h3><a href="https://www.vivishop.tw/cotton-and-linen-pants.html">日系薄款冰絲棉麻小脚褲，視覺增高5cm！【三色可選】</a></h3>
<div class="p3">
<span class="newprice">NT$ 1,280</span>
<span class="oldprice">NT$ 1,880</span>
</div>
</div>
</li>
</ul>
<div class="clear"></div>
</div>
<div class="hsale-title">
<div class="timer" id="timer">
</div>
</div>
<script language="javascript">
    (function($){
        var endtime = '24:00:00';
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

            $("#timer").html('<span>倒数</span><span id="h" class="timerk">' + h + '</span>:<span id="m" class="timerk">' + m + '</span>:<span id="s" class="timerk">' + s + '</span>结束');

            setTimeout(function(){
                countDown(datetime-1);
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
<a href="https://www.vivishop.tw/xichenqi.html"><img src="picture/xcq-1.jpg" width="400" height="400" alt=""/></a>
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
<a href="https://www.vivishop.tw/lipstick-microphone.html"><img src="picture/g15s4ys17u64v3bpgphi60z5r275001.jpg" width="400" height="400" alt=""/></a>
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
</div>
<div id="load" style="width:100%;text-algin:center;height:40px;padding:8px 0;"><img src="picture/loading.gif" style="width:auto;margin:0 auto;display:none;"></div>

<style>#descDiv .prolist li{padding:5px;box-sizing:border-box;border:0;box-shadow:none;display:none;}#descDiv .prolist li .newprice{font-weight:normal;}#descDiv .prolist li .newprice .fprice{font-style:normal;font-size:18px;}</style>

<script type="text/javascript" src="js/ld.js" async="true"></script>

<script type="text/javascript">window.dataLayer =window.dataLayer ||[];window.dataLayer.push({"event":"crto_homepage","crto":{"email":""}
});</script>
<script type="text/javascript">
try{var searchForm =new Varien.searchForm('search_mini_form','search','在這裡搜索整個商店...');searchForm.initAutocomplete('https://www.vivishop.tw/catalogsearch/ajax/suggest/','search_autocomplete');}
catch(e){}
</script>

<script>
var bullets=document.getElementById('position').getElementsByTagName('li');var banner=Swipe(document.getElementById('mySwipes'),{auto:4000,continuous:true,disableScroll:false,callback:function(pos){var i=bullets.length;while(i--){bullets[i].className=' ';}bullets[pos].className='cur';}})
</script>
<script>
jQuery(document).ready(function(){var state=true;var linum =jQuery("#descDiv ul li").length;jQuery("#descDiv ul li:lt(4)").show();jQuery(window).scroll(function(){var scrot=jQuery(document).scrollTop()+100;if (scrot >=jQuery(document).height() - jQuery(window).height()) {if(state==true){state=false;jQuery("#load img").css("display","block");setTimeout(function(){jQuery("#load img").css("display","none");var lilen =jQuery("#descDiv ul li:visible").length;var lilent =lilen + 4;jQuery("#descDiv ul li:lt("+lilent+")").show();if(lilent >=linum){jQuery("#load").html("<p style='text-align:center;line-height:30px;font-size:14px;'>已經到最底端了</p>").css({"margin-top":"1px"});}else{state=true;}
},1000);}
}
});});
</script>
@endsection

