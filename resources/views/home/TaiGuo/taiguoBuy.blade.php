<!DOCTYPE html>
<html>
    <head>
                <link rel="shortcut icon" href="https://cdn.uudobuy.com/ueditor/image/20171019/1508385777747154.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>[zsshop]{{$goods->goods_name}}</title>
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
        <link href="/css/new.css" rel="stylesheet">
        <link href="/css/shop.css" rel="stylesheet">
        <link href="/css/total.css" rel="stylesheet">
        <link href="/css/temporary.css" rel="stylesheet">
        <link href="/css/pay.css" rel="stylesheet">
        <link href="/css/JS5.css" rel="stylesheet" type="text/css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/mui.min.js" type="text/javascript"></script>
        <script src="/js/base.js" id="baseScript" path="http://oatsbasf.3cshoper.com"></script>
        <script src="/js/mui.lazyload.js"></script>
        <script src="/js/shop5.js"></script>
        <script src="/js/ytc.js" async=""></script>
        <script src="/js/bat.js" async=""></script>
        <script async="" src="/js/analytics.js"></script>
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="/layer/layer.js"></script>


        <style type="text/css">
            .radio{
                display: inline-block;
                position: relative;
                line-height: 18px;
                margin-right: 10px;
                cursor: pointer;
            }
            .radio input{
                display: none;
            }
            .radio .radio-bg{
                display: inline-block;
                height: 18px;
                width: 18px;
                margin-right: 5px;
                padding: 0;
                background-color: #45bcb8;
                border-radius: 100%;
                vertical-align: top;
                box-shadow: 0 1px 15px rgba(0, 0, 0, 0.1) inset, 0 1px 4px rgba(0, 0, 0, 0.1) inset, 1px -1px 2px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .radio .radio-on{
                display: none;
            }
            .radio input:checked + span.radio-on{
                width: 10px;
                height: 10px;
                position: absolute;
                border-radius: 100%;
                background: #FFFFFF;
                top: 4px;
                left: 4px;
                box-shadow: 0 2px 5px 1px rgba(0, 0, 0, 0.3), 0 0 1px rgba(255, 255, 255, 0.4) inset;
                background-image: linear-gradient(#ffffff 0, #e7e7e7 100%);
                transform: scale(0, 0);
                transition: all 0.2s ease;
                transform: scale(1, 1);
                display: inline-block;
            }
        
        </style>
        <!--产品页轮播-->
        <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="/js/yxMobileSlider.js"></script>
        <script type="text/javascript" src="/js/icheck.min.js"></script>
        <script type="text/javascript" src="/js/conversion.js"></script>
        <script type="text/javascript" src="/js/global.js?v=1.0"></script>
        <!--地区实现三级联动的脚本-->
        <!--引入不同地区的脚本文件，默认引入阿联酋的文件，其它地区的文件，在自定义block中设置-->
        <script src="/js/diqu/taiguo.js"></script>
        <script src="/js/Validform.min.js"></script>
        <script src="/js/Validform.min.js"></script>
        <script src="/js/moudul/functMoudul.js"></script>
        <link href="/css/addcart.css" rel="stylesheet">


         <!-- <script src="/js/addcart.js"></script> -->
         <!--gleepay-->
        <script type="text/javascript" src="/js/broser.js"></script>
        <style type="text/css">
            	.chose_cart{
            		background-color: red;
            		color: white !important;
            		border:1px dashed #ccc !important;
            	}
            	.unchose_cart{
            		background-color: white;
            		color: black !important;
            		border:1px dashed #ccc !important;
            	}
                .size span{
                display: inline-block;
                padding: 2px 4px;
                border: 1px solid #999;
                border-radius: 12px;
            }
            .size img{
                width: 28px;
                margin-top: -5px;
                vertical-align: text-top;
            }
            .size_img{
                display: none;
                position:fixed;
                width:100%;
                height:100%;
                background:rgba(0,0,0,0.3);
                z-index:999999999999999999999999999999;
                max-width: 640px;
            }
            .size_img img{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translateX(-50%) translateY(-50%);
                width: 100%;
                max-width: 640px;
            }
        </style>
        

        

        @if($goods->goods_pix!=null&&$goods->goods_pix!='')
        <!-- Facebook Pixel Code -->
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
        <!-- End Facebook Pixel Code -->
        @endif
          <!-- YaHoo Pixel Code 代码迁移至667addCart行 -->

        <!-- End YaHoo Pixel Code -->
    <!-- Global site tag (gtag.js) - Google Analytics 代码迁移至675addCart行-->

        <!-- End Google Pixel Code -->

</head>
<body style="">
@if(trim($goods->size_photo)!='')
<div class="size_img">
    <img src="{{$goods->size_photo}}" alt="">
</div>
@endif
<div id="orderlog" class="Popup">
        <div>
            <div>
                <h3>ยืนยันการสั่งซื้อ</h3><img style="top:5px;right:5px;position: absolute;z-index: 9;padding-left: 10px; width: 35px;" src="/img/close.png" onclick="(function(){$('#orderlog').hide()})()">
                <div id="orderlogConten">
                </div>
                <div id="orderlogConten2"></div>

            </div>
            <button id="payOk" style="width:60%;color:white;background-color:red;position: absolute;margin-left: 20%;bottom: 0px;">การยืนยัน</button>
        </div>
    </div>

<!--gleepay-->
<!--国内网站需修改导航内容，把头部导航抽象到 nav_checkout中 -->
<header class="mui-bar mui-bar-nav" style="background:#fff;">
    <a class=" mui-icon mui-icon-left-nav mui-pull-left" style="color:#333" onclick="javascript :location.href= 'http://{{ $home_url }}'"></a>
    <h1 class="mui-title">ยืนยันคำสั่งซื้อ</h1>
</header>

<div class="mui-content">


<!--product info begin-->
<div class="pro_info">
    <div class="ctxthead">
{{--        <div class="limgbox"><img src="{{App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}"/></div>--}}
        @if($goods->img)
        <div class="limgbox"><img src="{{$goods->img}}"/></div>
        @endif
        <div class="rpricebox" style="{{$goods->img ? '' : 'margin-top:60px;'}}">{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="price">{{$goods->goods_price}}</span></div>
    </div>

    <div class="ctxtbox" style="{{$goods->img ? '' : 'position: absolute;z-index: 1000;left: 10px;'}}">
        <h1>{{$goods->goods_name}}</h1>
        <h2><span style="color: rgb(255, 0, 0);"><strong>@if(trim($goods->goods_cuxiao_name)!='')【{{$goods->goods_cuxiao_name}}】@endif</strong></span><p style="display: inline-block;">{!!$goods->goods_msg!!}</p></h2>
            </div>
</div>
@if(trim($goods->size_photo)!='')
<div class="size">
    <img src="/img/size.jpg" alt="">
    <span>ขนาดผู้ช่วย</span>
</div>
@endif
<!--product info end-->
<!--size begin-->  
<div id="goods_config_div">

</div>
<div id="addcart">
   
</div>
<form class="mui-content" id="save" >
    <input type="hidden" name="cuxiao_id" @if($goods->goods_cuxiao_type=='2') value="{{\App\cuxiao::where('cuxiao_goods_id',$goods->goods_id)->first()->cuxiao_id}}" @endif >
<input type='hidden' name='_auth_token_' value='1531802224'><input type="hidden" name="coll_id" id="coll_id" value=""/>
<input type="hidden" id="from" name="from" value=""/>
{{ csrf_field()}}

<!-- <script src="/js/buy.js"></script> -->

<!--iframe id="storage" src="http://feilm.top/index/storage?url=http://tw.5ittbat.com" height="0px" frameborder="0"></iframe-->

<div id="loading" style="display: none;">
    <center>Submiting</center>
</div>
<!--qty total end-->
<!--table begin-->
    <div class="secure secure_03"><img src="/images/secure_03.jpg" /></div>
<div class="mui-input-group">
    
    <div class="mui-input-row">
        <label><span class="require">*</span>ชื่อ-นามสกุล:</label>
        <input type="text" name="firstname" datatype="s1-30" placeholder="กรุณาระบุชื่อ-นามสกุลของผู้รับของ" nullmsg="กรุณากรอกชื่อ" class="mui-input-clear">
    </div>
    <!-- <div class="mui-input-row">
        <label><span class="require">*</span>Last name:</label>
        <input type="text" name="lastname" placeholder="required,Please enter your last name" class="mui-input-clear">
    </div> -->
    <div class="mui-input-row">
        <label><span class="require">*</span>บอร์โทรศัพท์:</label>
        <input type="text" datatype="/^\d+$/" placeholder="กรุณาระบุ เบอร์โทรศัพท์ของผู้รับของ" nullmsg="คุณยังไม่ได้กรอกข้อมูลหมายเลขโทรศัพท์มือถือ" errormsg="คุณยังไม่ได้กรอกข้อมูลหมายเลขโทรศัพท์มือถือ" name="telephone" class="mui-input-clear">
    </div>
    <!-- <div class="" style="padding:0;margin:0;line-height: 16px;color: red;padding-left: 23%; ">
    โปรดตรวจสอบว่าเบอร์โทรศัพท์รึเปล่า ถูกต้องไหม และถูกต้องไหม เพื่อให้เราสามารถติดต่อคุณและส่งถูกต้องสินค้า 
    </div> -->
    <!--<div class="mui-input-row" style="display:none;">-->
        <!--<label>Country / Region:</label>-->
        <!---->
    <!--</div>-->
    <div class="mui-input-row" style="display:none;">
        <label>State:</label>
        <!--<input type="text" datatype="z1-300" nullmsg="state_not_correct" errormsg="state_not_correct" name="state" class="mui-input-clear">-->
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>City:</label>
        <!--<input type="text" name="city" datatype="z1-300" nullmsg="city_not_correct" errormsg="city_not_correct" class="mui-input-clear">-->
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>จังหวัด อำเภอ/เขต :</label>
        <div id="twzipcode"></div>
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>ที่อยู่:</label>
        <input type="text" datatype="z1-300" placeholder="กรุณาระบุที่อยู่บ้านเลขที่ ถนน ตำยล" nullmsg="เขต/อำเภอ" errormsg="address_not_correct" name="address1" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>Address Line2:</label>
        <input type="text" name="address2" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="">
        <label><span class="require">*</span>รหัสไปรษณีย์:</label>
        <input type="text" name="zip" placeholder="กรุณาระบุรหัสไปรษณีย์ของผู้รับ" class="mui-input-clear">
    </div>
        <div class="mui-input-row need_email">
        <label><span class="require">*</span>อีเมล:</label>
        <!--<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" datatype="/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" class="mui-input-clear">-->
        <input type="text" name="email"errormsg="อีเมลที่ไม่ถูกต้อง" placeholder=" ทางเราจะใช้E-Mailนี้มาแจ้งข้อมูลการสั่งซื้อ" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style=" height:66px">
        <label>ฝากข้อความ:</label>
        <textarea name="notes" placeholder="ข้อความต้องการที่ให้ทางเราทราบ(ถ้ามี) เช่นหมายเลขโทรศัพท์ สเปคสินค้าที่ต้องการหรือนัดเวลาการจัดส่งสินค้า"></textarea>
    </div>

</div>
<!--table end-->

<input type="hidden" name="id" value="103107897"/>
<input type="hidden" name="poid" value=""/>
<input type="hidden" name="append" value="0"/>
<input type="hidden" name="salerule_id" value="0"/>
<input type="hidden" name="currency_code" value="NTD"/>
<input type="hidden" name="currency_id" value="1"/>
<input type="hidden" name="amount" value="0"/>
</form>

<!--paypal begin-->
<div class="paymentbox">
    <ul>

        <li>
            @if(in_array('0',$goods->goods_pay_type))
          <div class="mui-input-row mui-radio mui-left cash-on-delivery" style="display: inline-block">
              <input checked="" name="pay_type" id="pay_1" value="1" type="radio">
            <label>
            เก็บเงินปลายทาง             </label>
              <span style="width:100px;">
                                    <img src="/images/cash.jpg" alt="" id="cash"/>
                                                  </span>
          </div>
          @endif
          @if(in_array('1',$goods->goods_pay_type))
          <div class="mui-input-row mui-radio mui-left cash-on-delivery" style="display: inline-block">
            <input name="pay_type"  id="pay_2" value="2" type="radio">
              <label>
              PayPal            </label>
            <span style="width:100px;">
                                  <img src="/images/paypalbtn.png" style="border-radius: 35px;"alt="" id="cash"/>
                                                </span>
          </div>
          @endif
        </li>
            </ul>
</div>
<!--paypal end-->
<!--把货到付款费用添加抽象到cash_on_delivery中-->
<div class="mui-input-row" style="padding:0;margin:0;line-height: 16px;color: red; font-size: 16px;">
เราสัญญาว่าข้อมูลส่วนบุคคลของคุณจะถูกเก็บไว้เป็นความลับโดยข้างต้นไหมอะไรถูกเปิดเผย
</div>
<!--button begin-->
<div class="btndiv">
    <button id="pay" type="button" class="btnstyle01" style="">ส่งคำสั่งซื้อ</button>
</div>
<!--button end-->
<!--footer begin-->
    <!--把最下方的底部内容抽象到newfooter中-->
    <div class="newfooter">
    
    คำเตือน ก็บเงินปลายทางได้+ฟรีค่าขนส่ง+รับคืนหรือเปลี่ยนสินค้าภายใน7วันหลังจากได้รับสินค้าถ้าลูกค้าได้รับสินค้าแล้วมีคำถามหรือข้อสงสัยกับสินค้า สามารถติดต่อสอบถามผ่านระบบบริการลูกค้าออนไลน์หรือส่งอีเมลไปถึงที่

        <a href="mailto:uoewtnxj@gmail.com" style="color:#F8770E">uoewtnxj@gmail.com</a>.
    </div><!--footer end-->
    <div id="couponbg" style="display:none; position:fixed;z-index:99998; width:100%; height:100%; background:black; padding:0px; bottom:0px; margin:0px; opacity:0.7; max-width: 640px;">       
</div>
<div id="couponcontent" style="display:none;width: 100%;max-width:640px;clear: both;position: relative;">
  <div style="position: fixed; z-index: 99999; width: 90%; height: 500px; padding:0 5%; top: 16%; max-width: 640px;">
    <div class="mui-card">
      <div class="closeBtn">
        <img src="/img/close.png">
      </div>
	  <div class="mui-card-content">
      <ul id="contentop">
			<li class="action">

			</li>
		</ul>
      </div>
    </div>
</div>
</div>

<script>
    //第几件翻译
    function jianshu(a){
    return 'รายการที่ '+a
  }
  var cuxiao_num={!!$cuxiao_num!!};  //如果有默认数量；
  var a={!!$goods_config_arr!!};
  var moneycoin="{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}";
  var issubmit=true;
  var formnum=1; //商品属性组数计数；
  var basePrice=0;
  var realPrice='';
  addAttribu(cuxiao_num,a);
  var  addClickEven= function (){
         $("#goods_config_div").on('click',"input.radio",function(){
            $(this).parent().parent().find('label[for]').attr('class','uncheck') ;
         $(this).next().attr("class",'ischeck');  
         countDiff(a,basePrice-0,moneycoin,realPrice)  //更换属性计算差价；
          })

           $("#goods_config_div").on('click',"a.mui-navigate-right",function(){
            if($(this).parent().hasClass("mui-active")){
                $(this).parent().removeClass("mui-active")
            }else{
                $(this).parent().addClass("mui-active") 
            }
           })
        }
         addClickEven();
    var form=jQuery("form").Validform({
        tiptype:function(msg){
            $2.toast(msg);
        },
        datatype:{
            "z6-18": /^[\S\s]{6,18}$/,
        },
        beforeSubmit:function(){
            /*if(jQuery("input[name='data']").val() == undefined){
                console.log(jQuery("input[name='data']").val());
                alert('Incomplete data,Form validation error!');
                return false;
            }*/
                var vname = /先生|小姐|太太|男士|女士|退貨|換貨|退货|换货|(^.$)/;
                if(vname.test(jQuery("input[name='firstname']").val())){
                    /*layer.msg("請填寫您的真實姓名");
                    return false;*/
                }
                if(_checkBlackName(jQuery("input[name='firstname']").val())){
                    layer.msg("無效的名字");
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


layer.load(2);
layer.closeAll();
var datasObj={};
    datasObj.goods_id = {{$goods->goods_id}};
var layerMsg= function(){ layer.msg('กรุณากรอกข้อมูลที่เป็นคุณลักษณะที่สมบูรณ์ของสินค้า');}
var payFun=function (){
     
    //整理表单数据；
    var dataArr=$("form#f1").serializeArray();
    var dataObj={};

    var fromArr=$("#goods_config_div").find("form").serializeArray();

    $.each(dataArr,function(i,val){
        dataObj[val.name]=[];
    })
    // console.log(dataObj);
    $.each(fromArr,function(j,item){
        $.each(dataObj,function(k,tol){
          if(item.name==k){
              tol.push(item.value)
          }
        })
   })

    console.log(dataObj);
    var fromArr2=$("form#save").serializeArray();
    $.each(fromArr2,function(i,val){
        datasObj[val.name]=val.value;
    })
    datasObj.specNumber=$("#addcart-quantity-val").val();  //商品件数
    datasObj.goodsAtt=dataObj;                             //商品属性；
    console.log('zuihou',datasObj);
    /*$('#save').submit();*/
    if(datasObj.address1==null||datasObj.address1==''){
        layer.msg('ช่องที่อยู่ไม่สามารถเว้นว่างได้');
        return false;
    }
    if(datasObj.city==null||datasObj.city==''){
        layer.msg('ช่องข้อมูลภูมิภาคไม่สามารถเว้นว่างได้');
        return false;
    }
    if(datasObj.firstname==null||datasObj.firstname==''){
        layer.msg('ช่องชื่อ-นามสกุลไม่สามารถเว้นว่างได้');
        return false;
    }
    if(datasObj.telephone==null||datasObj.telephone==''){
        layer.msg('ช่องเบอร์โทรศัพท์ไม่สามารถเว้นว่างได้');
        return false;
    }
    if(datasObj.zip==null||datasObj.zip==''){
        layer.msg("กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง");
        return false;
    }
    var res = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;//邮箱
    if(!res.test(datasObj.email)){
        layer.msg("โปรดป้อนที่อยู่อีเมลที่ถูกต้อง");
        return false;
    }
    //判断用户是否选择了商品属性；
    var aNumer=Object.keys(a).length;
    var cuntNumer=$("#addcart-quantity-val").val()-0;
    var attFlag=true;
    $.each(datasObj.goodsAtt,function(i,value){
        if(value.length != cuntNumer){
            attFlag=false;
        }
    });
    if(aNumer != Object.keys(datasObj.goodsAtt).length || !attFlag){
        layer.msg('กรุณากรอกข้อมูลที่เป็นคุณลักษณะที่สมบูรณ์ของสินค้า');
        return false;
    };
    // var zipre = /^[0-9]{5}$/;//判断马来西亚邮政编码五位正整数；
    // if(!zipre.test(datasObj.zip)){
    //     layer.msg('กรุณากรอกรหัสไปรษณีย์ที่ถูกต้อง');
    //     return false;
    // }
    // var re = /^[0-9]+.?[0-9]*/;//判断字符串是否为数字//判断正整数/[1−9]+[0−9]∗]∗/  
    // if(!re.test(datasObj.telephone)){
    //     layer.msg('คุณยังไม่ได้กรอกข้อมูลหมายเลขโทรศัพท์มือถือ');
    //     return false;
    // }
    datasObj.address1=datasObj.address1+"(Zip:"+datasObj.zip+")";//后台不想多加字段，把邮政编码加在地址后面；
    // layer.msg("ำลังยื่นเสนอคำสั่งซื้อ กรุณารอสักครู่");
    $("#orderlog").show();
    payFunMessage()
            
}
var payFunGo= function (){
    $("#orderlog").hide()
    var index = layer.load(2, {shade: [0.15, '#393D49'],content:"ำลังยื่นเสนอคำสั่งซื้อ กรุณารอสักครู่",success: function(layero){
        layero.find('.layui-layer-content').css({'padding-top':'40px','width': '245px',  'text-align': 'center', 'color': 'red', 'margin-left':' -80px','background-position-x': '106px'});
    }})
    var payType=$(".paymentbox input:checked").val();

    if(issubmit){
        issubmit=false;
        if(payType==1){
            $.ajax({
           type: "POST",    
           url: "/saveform",
           data:datasObj,
           success: function (data) {
               layer.close(index);
            var btime=getNowDate();
                    try{fbq('track', 'InitiateCheckout')}catch(e){};
                            $.ajax({url:"{{url('/visfrom/setorder')}}"+"?id="+{{$vis_id}}+"&date="+btime,async:false});   
                            window.parent.location.href=data.url; //这个页面可能是iframe嵌套的子页面；所以从父页面跳
                       },
          
                    
           error: function(data) {
               layer.close(index);
               layer.msg('ยื่นคำสั่งซื้อผิดพลาด โปรดตรวจสอบสถานะเครือข่าย');
           }
        }) 
        }else{
               // location.href="/paypal_pay?datas="+JSON.stringify(datasObj);
               $.ajax({
               type: "POST",
               url: "/paypal_pay",
               data:datasObj,
               success: function (data) {
                   layer.close(index);
                   if(data.err=='0'){
                       layer.msg('การชำระเงินผ่าน Paypal ล้มเหลว โปรดเลือกวิธีการชำระเงินอื่น!');
                        issubmit=true;
                   }else{
                       var btime=getNowDate();
                       try{fbq('track', 'InitiateCheckout')}catch(e){};
                       $.ajax({url:"{{url('/visfrom/setorder')}}"+"?id="+{{$vis_id}}+"&date="+btime,async:false});
                       window.parent.location.href=data.url; //这个页面可能是iframe嵌套的子页面；所以从父页面跳
                   }
               },
 
 
               error: function(data) {
                   layer.close(index);
                   layer.msg('ยื่นคำสั่งซื้อผิดพลาด โปรดตรวจสอบสถานะเครือข่าย');
                 }
             }) ;
        }
; 
        
    }else{
        layer.close(index);
        layer.msg('คุณได้ยื่นคำสั่งซื้อเรียบร้อยแล้ว ไม่ต้องยื่นซ้ำ');
    }
   
    
            //记录购买事件
            
}
$('#pay').bind('click',payFun);//封装订单提交函数；
$('#payOk').bind('click',payFunGo);//封装订单提交
var cheapWord = 'คูปอง';
var cheapSatisfy = 'คูปองราคาต่ำสุด:';
var cheapSatisfyNone = 'ไม่จำกัดการใช้';
var cheapLose = 'คูปองหมดอายุ:';
var cheapMsg = 'คุณมีคูปองที่คุณสามารถใช้ได้!';
var cheapSa='โปรดทราบวงเงินการใช้คูปอง!';
   window.onbeforeunload = function() {
            $.ajax({url:"{{url('/visfrom/settime')}}"+"?id="+{{$vis_id}},async:false});
   }
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
</script>

<script>
    $(document).scroll(function () {
        $("#navigationBox").css('top', $(document).scrollTop());
    });
</script><script>
jQuery(function(){
    jQuery("#coll_id").val(getQueryString('coll_id'));
});
</script>

    <script>
    jQuery(function(){
        jQuery("#pay_1").click();                                        
    });
    </script>

<script type="text/javascript">
    jQuery(document).ready(function(e) {
        jQuery('#twzipcode').twzipcode();
        jQuery('input[name="zipcode"]').attr('style','display:none;');
        jQuery('#twzipcode').find("[name='state']").attr('style','margin-right:4.7%;width: 40%;');
        jQuery('#twzipcode').find("[name='state']").change(function(){
            var county = jQuery(this).val();
            var district = jQuery('#twzipcode').find("[name='city']").val();
            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all').val(message_info);
        });

        jQuery('#twzipcode').find("[name='city']").change(function(){
            var county = jQuery('#twzipcode').find("[name='state']").val();
            district = jQuery(this).val();


            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all').val(message_info);
        });

        jQuery('.gw_address_message_info').change(function(){
            var county = jQuery('#twzipcode').find("[name='state']").val();
            var district = jQuery('#twzipcode').find("[name='city']").val();
            //alert(district);
            var message_info = county + " " +  district;
            jQuery('#gw_address_message_all ').val(message_info);
        });

    });
</script>

<script>
//     jQuery(function(){
//         var html1 ='';
// //        html +='<div class="mui-input-row need_email">';
//         html1 += ' <label><span style="color:red;">*</span>อีเมล:</label>';
//         html1 +='<input type="text" placeholder=" ทางเราจะใช้E-Mailนี้มาแจ้งข้อมูลการสั่งซื้อ" nullmsg="กรอกอีเมลผู้รับ" errormsg="email_not_correct" datatype="/^([0-9A-Za-z\-_\.]+)@([0-9a-z\.]+)$/g" name="email" class="mui-input-clear"></div>';
//         var html2 = '';
//         html2 += "<label>อีเมล:</label>";

//         html2 += '<input type="text" name="email" placeholder=" ทางเราจะใช้E-Mailนี้มาแจ้งข้อมูลการสั่งซื้อ" class="mui-input-clear">';

//         var payty =  jQuery('input[name=pay_type]:checked').val();
//         if(payty==7||payty==2){
//             jQuery('.need_email').children().remove();
//             jQuery('.need_email').append(html1);
//         }else{
//             jQuery('.need_email').children().remove();
//             jQuery('.need_email').append(html2);
//         }
//         jQuery('input[name=pay_type]').click(function(){
//             if(jQuery(this).val()==7 || jQuery(this).val()==2){
//                 jQuery('.need_email').children().remove();
//                 jQuery('.need_email').append(html1);
//             }else{
//                 jQuery('.need_email').children().remove();
//                 jQuery('.need_email').append(html2);
//             }

//         });

//     });

</script>

<script type="text/javascript">
    $(function(){
        $.ajax({
                url:"{{url('/gethtml')}}",
                type:'post',
                data:{'id':{{$goods->goods_id}},'_token':"{{csrf_token()}}"},
                datatype:'html',
                success:function(msg){
                //  $('#addcart').html(msg);
                 console.log('123',msg)
                 realPrice=msg.goods.goods_real_price; //商品的原价
                    //判断这个页面是不是在首页仿淘宝弹框中打开的
                    if(msg.goods.goods_blade_style=="1"){
                    mouduleTaoBao();
                    closeBtnWatch();
                    console.log("goods_blade_style",msg.goods.goods_blade_style)
                 }else{
                     //雅虎像素
                     if(msg.goods.goods_yahoo_pix){
                         window.dotq = window.dotq || [];
                                window.dotq.push(
                                {
                                'projectId':'10000',
                                'properties':{
                                    'pixelId':msg.goods.goods_yahoo_pix,
                                    'qstrings':{
                                    'et':'custom',
                                    'ea':'AddToCart',
                                    'product_id': msg.goods.goods_id,
                                    }
                                }});
                        (function(w,d,t,r,u){w[u]=w[u]||[];w[u].push({'projectId':'10000','properties':{'pixelId':msg.goods.goods_yahoo_pix}});var s=d.createElement(t);s.src=r;s.async=true;s.onload=s.onreadystatechange=function(){var y,rs=this.readyState,c=w[u];if(rs&&rs!="complete"&&rs!="loaded"){return}try{y=YAHOO.ywa.I13N.fireBeacon;w[u]=[];w[u].push=function(p){y([p])};y(c)}catch(e){}};var scr=d.getElementsByTagName(t)[0],par=scr.parentNode;par.insertBefore(s,scr)})(window,document,"script","https://s.yimg.com/wi/ytc.js","dotq");
                        console.log("goods_yahoo_pix",msg.goods.goods_yahoo_pix);
                     }
                     //goole像素
                     if(msg.goods.goods_google_pix){
                         var script = document.createElement('script');
                         script.type = 'text/javascript';
                         script.src = "https://www.googletagmanager.com/gtag/js?id="+msg.goods.goods_google_pix;

                         $("head").append(script);

                         window.dataLayer = window.dataLayer || [];
                         function gtag(){dataLayer.push(arguments);}
                         gtag('js', new Date());
             
                         gtag('config', msg.goods.goods_google_pix);
                         console.log("goods_google_pix",msg.goods.goods_google_pix);
                     }
                }
                 function returnFloat(value){
                      var value=Math.round(parseFloat(value)*100)/100;
                      var xsd=value.toString().split(".");
                      if(xsd.length==1){
                      value=value.toString()+".00";
                      return value;
                      }
                      if(xsd.length>1){
                      if(xsd[1].length<2){
                      value=value.toString()+"0";
                      }
                      return value;
                      }
                     };
                    // window.setTimeout("window.location='{{url('admin/contro/index')}}'",2000); 
                    if(msg.goods.goods_cuxiao_type=="0"){
                         $(function(){
                            var addCartHtml1='<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">รายการที่:1</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.goods.goods_price+'</span>  เหลือ'+msg.goods.goods_num+'รายการ\）</span><span class="addcart-specs-status"></span></div><div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">จำนวน:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">จำนวนรวม:<font>1</font> <span class="gift" style="display:none;">, ของแถม: <font>0</font>ชิ้น</span> </span><span class="addcart-footer-realPriceNative-total">ราคาปกติ:<font>1</font></span><span class="addcart-footer-realPrice-total">ลดปริมาณ:<font></font></span><span style="display: none;" class="addcart-footer-coupon-total">คูปอง:<font></font></span><span class="addcart-footer-price-total">ยอดรวม:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.goods.goods_price+'</font></span></div></div>';
                            $("#addcart").html(addCartHtml1);
                            var pricehtml=$('.addcart-footer-price-total').children('font:first');
                                var price=pricehtml.html().replace(/[^0-9]/ig,"")/100;
                                basePrice=msg.goods.goods_price;
                                    countDiff(a,basePrice-0,moneycoin,realPrice)  //初始化加差值；
	                        $('#addcart-quantity-dec').bind('click',function(){
	                        	removeform(); // 删除一组商品属性
	                        	var num=parseInt($(this).next().val());
	                        	if(num<=1){
	                        		return false;
	                        	}
	                        	$(this).next().val(num-1);
	                        	$('.addcart-specs-title-name').html("รายการที่:"+(num-1));
                                $('.addcart-footer-number-total').children('font:first').html(num-1);
                                basePrice=returnFloat((num-1)*price)   //声明一个基础价格；
	                        	$('#realprice').html( returnFloat((num-1)*price) );
                                pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat((num-1)*price) );
                                countDiff(a,basePrice-0,moneycoin,realPrice)  //初始化加差值
	                        })
	                        $('#addcart-quantity-inc').bind('click',function(){
	                        	formnum+=1
	                        	var formName="f"+formnum;
	                        	addform(formName); //增加一组商品属性；
	                        	var num=parseInt($(this).prev().val());
	                        	if(num>={{$goods->goods_num}}){
	                        		layer.msg('สินค้าขาดสต๊อก');
	                        		return false;
	                        	}
	                        	$(this).prev().val(num+1);
	                        	$('.addcart-specs-title-name').html("รายการที่:"+(num+1));
                                $('.addcart-footer-number-total').children('font:first').html(num+1);
                                basePrice=returnFloat((num+1)*price)   //声明一个基础价格；
	                            $('#realprice').html(returnFloat((num+1)*price) );
                                pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat((num+1)*price) );
                                countDiff(a,basePrice-0,moneycoin,realPrice)  //初始化加差值；
	                        })
                         })

                    }else if(msg.goods.goods_cuxiao_type=="2"){
                            $(function(){
                                var addCartHtml2= '<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">รายการที่:1</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.goods.goods_price+'</span>, เลือก【'+msg.cuxiao[0].cuxiao_msg+'&#12305;เหลือ'+msg.goods.goods_num+'รายการ）</span><span class="addcart-specs-status"></span></div><div class="addcart-group-buttons"  style="display: block;" ><div class="addcart-float-buttons-block" ><button class="chose_cart addcart-quantity-inc" type="button" >'+msg.cuxiao[0].cuxiao_msg+'</button></div></div><div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">จำนวน:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">จำนวนรวม:<font>1</font> <span class="gift" style="display:none;">, ของแถม: <font>0</font>ชิ้น</span>  </span><span class="addcart-footer-realPriceNative-total">ราคาปกติ:<font></font></span><span class="addcart-footer-realPrice-total">ลดปริมาณ:<font></font></span><span style="display: none;" class="addcart-footer-coupon-total">คูปอง:<font></font></span><span class="addcart-footer-price-total">ยอดรวม:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.goods.goods_price+'</font></span></div></div>';
                                $("#addcart").html(addCartHtml2);

                                    var pricehtml=$('.addcart-footer-price-total').children('font:first');
	                            	var price=pricehtml.html().replace(/[^0-9]/ig,"");
                                    var config_arr=String(msg.cuxiao[0].cuxiao_config).split(',');
                                    
                                    function priceMath(num){
                                            var confignum=$('.radiobox').length;console.log(confignum);
	                            	        var price=msg.goods.goods_price;
	                            	        var end_price=price*num;
	                            	        if(num<config_arr[0]){
                                                var end_price=price*num;
                                                basePrice=returnFloat(end_price)   //声明一个基础价格；
	                            	        	$('#realprice').html( returnFloat(end_price));
                                                pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat(end_price));
                                                countDiff(a,basePrice-0,moneycoin,realPrice)  //初始化加差值；
	                            	        }else{
	                            	        	var jp=price*(parseInt(config_arr[0])-1);
	                            	        	var jjp=0;
	                            	        	var len=config_arr.length;
	                            	        	for(var i = 0; i < config_arr.length/2; i++){
	                            	        			if(num>=parseInt(config_arr[i*2])){
	                            	        				if(num<parseInt(config_arr[i*2+2])){
	                            	        					jjp+=(num-(parseInt(config_arr[i*2])-1))*(price-(config_arr[i*2+1]));
	                            	        					break;
	                            	        				}else if(num>=parseInt(config_arr[i*2+2])){
	                            	        					jjp+=(parseInt(config_arr[i*2+2])-parseInt(config_arr[i*2]))*(price-config_arr[i*2+1]);
	                            	        				}else{
	                            	        					jjp+=(num-parseInt(config_arr[i*2])+1)*(price-config_arr[i*2+1]);
	                            	        				}
	                            	        			}
	                            	        		}
                                                 end_price=jp+jjp;
                                                 basePrice=returnFloat(end_price)  //声明一个基础价格；
	                            	        	$('#realprice').html(returnFloat(end_price) );
                                                pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat(end_price));
                                                countDiff(a,basePrice-0,moneycoin,realPrice)  //初始化加差值；
	                            	        }
                                    }
	                            
	                                $('#addcart-quantity-dec').bind('click',function(){
	                            	removeform();
	                            	var num=parseInt($(this).next().val());
	                            	if(num<=1){
	                            		return false;
	                            	}
	                            	$(this).next().val(num-1);
	                            	$('.addcart-specs-title-name').html("รายการที่:"+(num-1));
	                            	$('.addcart-footer-number-total').children('font:first').html(num-1);
	                            	$('.addcart-footer-number-total').children('font:first').html(num-1);
                                    num=num-1;
                                    priceMath(num)
	                            		
	                            })
	                            
	                            function zhengjia(){
	                            	
	                            	formnum+=1;
	                            	var formName="f"+formnum;
	                            	addform(formName); console.log(formnum) //增加一组商品属性
                            
	                            	// var num=parseInt($(this).prev().val());
	                            	var num = Number($('#addcart-quantity-val').val())
	                            	console.log(num)
	                            	if(num>= msg.goods.goods_num){
	                            		layer.msg('สินค้าขาดสต๊อก');
	                            		return false;
	                            	}
	                            	// $(this).prev().val(num+1);
	                            	$('#addcart-quantity-val').val(num+1);
	                            	$('.addcart-specs-title-name').html("รายการที่:"+(num+1));
	                            	$('.addcart-footer-number-total').children('font:first').html(num+1);
	                                $('.addcart-footer-number-total').children('font:first').html(num+1);
	                                num=num+1;
                                    priceMath(num)	
	                            }
                            
	                            var shuliang = formnum;
	                            if(shuliang>= msg.goods.goods_num){
	                            	shuliang = msg.goods.goods_num
	                            	for(var i=1; i<shuliang;i++){
	                            		zhengjia();
	                            	}
	                            }else{
	                            	for(var i=1; i<shuliang;i++){
	                            		zhengjia();
	                            	}
	                            }
	                            $('#addcart-quantity-inc,.addcart-quantity-inc').bind('click',function(){
	                            	zhengjia();
	                            });
                            })
                    }else  if(msg.goods.goods_cuxiao_type=="3"){
                        $(function(){
                            var specialHtml='';
                            $.each(msg.special,function(i,item){
                                specialHtml+= '<div class="addcart-specs image-list"  mine_id="'+item.special_id+'" style="display: none;" data-id="416515236" data-number="5" data-price="0" data-rule="6" data-gift="1" data-option="416515236#1"><div class="addcart-specs-title" >	<img style="width: 20%;height: 50%;" class="addcart-specs-title-image" src="'+item.price_img+'"><span class="addcart-specs-title-name">'+item.price_name+'</span><span class="addcart-specs-title-number">×'+item.special_price_num+'</span><span class="addcart-specs-title-gift">ของแถม </span></div></div>'
                            });
                            $("#addcart").append(specialHtml);
                             var yixuanHtml='<div class="addcart-specs-title unfold"><span class="addcart-specs-title-name">รายการที่:'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.cuxiao[0].cuxiao_config.split(",")[1]+'</span>, เลือก 【<span id="sell_msg">'+msg.cuxiao[0].cuxiao_msg+'</span>&#12305; เหลือ'+msg.goods.goods_num+'รายการ）</span><span class="addcart-specs-status"></span></div>'
                            $("#addcart").append(yixuanHtml);
                            var buttonHtml= '';
                            var chose_cart='chose_cart';
                            var unchose_cart='unchose_cart';
                            $.each(msg.cuxiao,function(j,val){
                                  buttonHtml+='<div class="addcart-group-buttons"  style="display: block;" ><div class="addcart-float-buttons-block"  data-id="7022"><button cuxiao_id="'+val.cuxiao_id+'"  class="'+ (j==0?chose_cart:unchose_cart)+'" type="button" num="'+val.cuxiao_config.split(",")[0]+'" price="'+val.cuxiao_config.split(",")[1]+'" type_name="'+val.cuxiao_msg+'" cuxiao_special_id="'+val.cuxiao_special_id+'" >'+val.cuxiao_msg+'</button></div></div>'
                            })
                            $("#addcart").append(buttonHtml);
                            var numberHtml = '<div class="addcart-quantity"><img src="/images/click.png" style="width: 20px;"><div class="addcart-quantity-content"><label class="addcart-quantity-title">จำนวน:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'" readonly=""><span id="addcart-quantity-inc"> + </span></div></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">จำนวนรวม:<font>'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'</font>  <span class="gift" style="display:none;">, ของแถม: <font>0</font>ชิ้น</span>  </span><span class="addcart-footer-realPriceNative-total">ราคาปกติ:<font></font></span><span class="addcart-footer-realPrice-total">ลดปริมาณ:<font></font></span><span style="display: none;" class="addcart-footer-coupon-total">คูปอง:<font></font></span><span class="addcart-footer-price-total">ยอดรวม:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.cuxiao[0].cuxiao_config.split(",")[1]+'</font></span></div></div>';
                            $("#addcart").append(numberHtml);

                            $("#goods_config_div").children("form").remove(); //如果选择套餐先删除说有属性，在根据有几件商品循环几组属性；
		                   	var num1=$("#addcart-quantity-val").val()-0;
		                   	formnum=0;
		                   	for(var i=1;i<=num1;i++){
		                   		formnum+=1
		                           var formName="f"+formnum;
		                           addform(formName); //增加一组商品属性；
                               }
                               basePrice = msg.cuxiao[0].cuxiao_config.split(",")[1];
                              countDiff(a,basePrice-0,moneycoin,realPrice)  //加差值；
                            $('form').children('[name="cuxiao_id"]').val(msg.cuxiao[0].cuxiao_id); //隐藏域促销id
                            var cuxiao_special_id=msg.cuxiao[0].cuxiao_special_id;  //默认初始化赠品是否显示；
                                $("[mine_id]").hide();
                            	if(cuxiao_special_id>0){
                                    $("[mine_id='"+cuxiao_special_id+"']").show();
                                    $(".gift").css("display","inline-block")
                                    $(".gift font").text($("[mine_id='"+cuxiao_special_id+"'] .addcart-specs-title-number").text().substr(1))
                            	}
	                       var pricehtml=$('.addcart-footer-price-total').children('font:first');
		                   var price=pricehtml.html().replace(/[^0-9]/ig,"");
	                       $('#addcart-quantity-dec').bind('click',function(){
		                   layer.msg('สินค้านี้รองรับการซื้อเป็นแพคเกจเท่านั้น');
		                   return false;
	                       })
	                       $('#addcart-quantity-inc').bind('click',function(){

		                    layer.msg('สินค้านี้รองรับการซื้อเป็นแพคเกจเท่านั้น');
		                    return false;
	                        })
                            $('.addcart-float-buttons-block').children('button').click(function(){    	
                            	$('form').children('[name="cuxiao_id"]').val($(this).attr('cuxiao_id'));
                            	var attr=$(this).attr('class');
                            	var cuxiao_special_id=$(this).attr('cuxiao_special_id');
                                $("[mine_id]").hide();
                                $(".gift").hide();
                            	if(cuxiao_special_id>0){
                                    $("[mine_id='"+cuxiao_special_id+"']").show();
                                    $(".gift").css("display","inline-block")
                                    $(".gift font").text($("[mine_id='"+cuxiao_special_id+"'] .addcart-specs-title-number").text().substr(1))
                            	}
                            	if(attr=='chose_cart'){
                            		layer.msg('เลือก ');
                            	}else if(attr =='unchose_cart'){
                       		     $('.chose_cart').attr('class','unchose_cart');
                       		     $(this).attr('class','chose_cart');
                                   var num=$(this).attr('num');
                                   var price=$(this).attr('price');
                                   var cuxiao_msg=$(this).attr('type_name');
                                   $('#sell_msg').html(cuxiao_msg);
                                   $('#realprice').html(price);
                                   $('.addcart-footer-number-total').children('font:first').html(num);
                                   $('#addcart-quantity-val').val(num);
                                   basePrice=price //声明一个基础价格；
                                   pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+price);       //填上自定义价格无需计算；
                                   $('div.unfold .addcart-specs-title-name').html("จำนวนรวม :"+num);
		                        console.log(num);
		                        $("#goods_config_div").children().remove(); //如果选择套餐先删除说有属性，在根据有几件商品循环几组属性；
		                        formnum=0;
		                        for(var i=1;i<=num;i++){
		                        	formnum+=1
		                           var formName="f"+formnum;
		                           addform(formName); //增加一组商品属性；
                                   }
                                   countDiff(a,basePrice-0,moneycoin,realPrice)  //加差值；
                       	        }
                            })
                       })
                            
                }
          }  })
    })
</script>

<script>
    var isuse =true;
jQuery(function(){
       $('#save input').on('input',function(){
             if(isuse){
                 try{fbq('track', "AddPaymentInfo");}
                 catch(e){}
                 isuse=false;
             }
        }) 
    jQuery('input').one('click',function(){
       jQuery('form').removeAttr('onsubmit');
    });
    jQuery("#select_ship").change(function(){
       jQuery.each(jQuery(this).find('option'),function(){
            var that = jQuery(this);
            if(that.attr('value')==jQuery("#select_ship").val())
            {
                price = that.data('price');
                jQuery("#ship_price").html(price);
            }
       });
    });
   
    
/*$('.radiobox').children().find('input').on('click',function(){alert('?');
            $(this).parent().parent().find('span').attr('class','uncheck')
           // $('#radiobox').find('span').each().attr('class','uncheck')
             $(this).next().attr("class",'ischeck');  
    })*/
//支付方式默认选中第一个；
$(function(){
    $(".paymentbox input[name='pay_type']:first").attr("checked","checked")
})
});
</script>
        <script>
        jQuery(function(){setFrom();});
        $('.size').click(function(){
            if($("#taorbg",parent.document)==0){
                $('.size_img').show();
            }else{
                $(".size_img",parent.document).show();
            }
        })
        $('.size_img').click(function(){
            $('.size_img').hide();
        });
        if($("#taorbg",parent.document)!=0){
            $(".size_img",parent.document).click(function(){
            $(".size_img",parent.document).hide();
        })
        }
        </script>


</body>
</html>