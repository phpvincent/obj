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
            .uncheck{
                border:1px dashed #ccc;
            }
            .ischeck{
                border:1px solid red;
            }
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
        <!--引入不同地区的脚本文件，默认引入台湾的文件，其它地区的文件，在自定义block中设置-->
        <script src="/js/diqu/jquery.twzipcode3.js"></script>
        <script src="/js/Validform.min.js"></script>
        <script src="/js/Validform.min.js"></script>
        <link href="/css/addcart.css" rel="stylesheet">


         <!-- <script src="/js/addcart.js"></script> -->
         <!--gleepay-->
        <script type="text/javascript" src="/js/broser.js"></script>

        


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
    <!--雅虎统计代码-->
   <!--  <script type="application/javascript">(function(w,d,t,r,u){w[u]=w[u]||[];w[u].push({'projectId':'10000','properties':{'pixelId':'10042137'}});var s=d.createElement(t);s.src=r;s.async=true;s.onload=s.onreadystatechange=function(){var y,rs=this.readyState,c=w[u];if(rs&&rs!="complete"&&rs!="loaded"){return}try{y=YAHOO.ywa.I13N.fireBeacon;w[u]=[];w[u].push=function(p){y([p])};y(c)}catch(e){}};var scr=d.getElementsByTagName(t)[0],par=scr.parentNode;par.insertBefore(s,scr)})(window,document,"script","https://s.yimg.com/wi/ytc.js","dotq");</script>
<noscript>
  <iframe src="//b.yjtag.jp/iframe?c=FYdC6J1" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript> -->

</head>
<body style="">

<!--gleepay-->
<!--国内网站需修改导航内容，把头部导航抽象到 nav_checkout中 -->
<header class="mui-bar mui-bar-nav" style="background:#fff;">
    <a class=" mui-icon mui-icon-left-nav mui-pull-left" style="color:#333" onclick="javascript :history.back(-1);"></a>
    <h1 class="mui-title">確認訂單</h1>
</header>

<div class="mui-content">


<!--product info begin-->
<div class="pro_info">
    <div class="ctxthead">
        <div class="limgbox"><img src="{{App\img::where('img_goods_id',$goods->goods_id)->first()->img_url}}"/></div>
        <div class="rpricebox">NT$<span id="price">{{$goods->goods_price}}</span></div>
    </div>

    <div class="ctxtbox">
        <h1>{{$goods->goods_name}}</h1>
        <h2><span style="color: rgb(255, 0, 0);"><strong>【{{$goods->goods_cuxiao_name}}】</strong></span>{!!$goods->goods_msg!!}</h2>
            </div>
</div>
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
        <label><span class="require">*</span>姓名:</label>
        <input type="text" name="firstname" datatype="s1-30" placeholder="必填，填寫收件人姓名" nullmsg="填寫收件人姓名" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>Last name:</label>
        <input type="text" name="lastname" class="mui-input-clear">
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>手機:</label>
        <input type="text" datatype="/^\d+$/" placeholder="必填，填寫收件人聯繫電話" nullmsg="填寫收件人聯繫電話" errormsg="請填寫正確的電話號碼" name="telephone" class="mui-input-clear">
    </div>
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
        <label><span class="require">*</span></label>
        <div id="twzipcode"></div>
    </div>
    <div class="mui-input-row">
        <label><span class="require">*</span>詳細地址:</label>
        <input type="text" datatype="z1-300" placeholder="必填，街道門牌信息" nullmsg="街道門牌信息" errormsg="address_not_correct" name="address1" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>Address Line2:</label>
        <input type="text" name="address2" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style="display:none;">
        <label>郵政編號:</label>
        <input type="text" name="zip" class="mui-input-clear">
    </div>
        <div class="mui-input-row need_email">
        <label>Email:</label>
        <!--<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" datatype="/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" class="mui-input-clear">-->
        <input type="text" name="email" placeholder="選填，填寫收件人電子郵件" class="mui-input-clear">
    </div>
    <div class="mui-input-row" style=" height:66px">
        <label>留言:</label>
        <textarea name="notes" placeholder="選填，如備用電話、產品規格或配送時間等"></textarea>
    </div>

</div>
<!--table end-->
<!--paypal begin-->
<div class="paymentbox">
    <ul>

            <li>
          <div class="mui-input-row mui-radio mui-left cash-on-delivery">
              <input checked="" name="pay_type" id="pay_1" value="1" type="radio">
            <label>
                貨到付款            </label>
              <span style="width:100px;">
                                    <img src="/images/cash.jpg" alt="" id="cash"/>
                                                  </span>
          </div>
        </li>
            </ul>
</div>
<!--paypal end-->
    <!--把货到付款费用添加抽象到cash_on_delivery中-->
    
<!--button begin-->
<div class="btndiv">
    <button id="pay" type="button" class="btnstyle01">提交訂單</button>
</div>
<!--button end-->
<!--footer begin-->
    <!--把最下方的底部内容抽象到newfooter中-->
    <div class="newfooter">
            溫馨提示：支持貨到付款+免郵費+七天無理由退換貨！收到商品後有任何疑問請聯繫我們在線客服，或發郵件至
        <a href="mailto:hyfhdcjn@gmail.com" style="color:#F8770E">hyfhdcjn@gmail.com</a>.
    </div><!--footer end-->
<input type="hidden" name="id" value="103107897"/>
<input type="hidden" name="poid" value=""/>
<input type="hidden" name="append" value="0"/>
<input type="hidden" name="salerule_id" value="0"/>
<input type="hidden" name="currency_code" value="NTD"/>
<input type="hidden" name="currency_id" value="1"/>
<input type="hidden" name="amount" value="0"/>
</form>
    

<script>
    var  addClickEven= function (){
         $("#goods_config_div input.radio").on('click',function(){
         $(this).parent().parent().find('span').attr('class','uncheck');
         $(this).next().attr("class",'ischeck');  
          })
     }
var formnum=1; //商品属性组数计数；
var a={!!$goods_config_arr!!}
console.log(a) 

        var addform=function(e){
            console.log('开始addform')
        var addhtml='';
        var color25="";
        

        $.each(a,function(i,val){
        // console.log(i,val);      
            var colorBut=''
            $.each(val,function(j,item){
                if(j===0){
                    colorBut= '<input type="radio"  class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" checked="checked"><span class="ischeck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</span>&nbsp';
                }else{
                    colorBut+= '<input type="radio"  class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'"><span class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</span>&nbsp';
                }
               
            })
            color25+='<div calss="radiobox"> <dl class="addcart-specs-content"><dt>'+val[0].goods_config_msg+'</dt><dd>'+colorBut+'</dl></div>';
    })

    console.log('form',e);
    addhtml='<form id="'+e+'">'+ color25+'</form>';   //每件商品的所有属性的HTML放入一个form；
    $("#goods_config_div").append(addhtml);                  //插入一组商品的所有属性；
    addClickEven()                                           //每增加一組屬性節點，監聽一次ischeck；
     }
     addform("f1");                                          //默认一组商品的所有属性fromid为f1；
     //删除一组商品属性的form；
     var removeform= function(){
         if($("#goods_config_div").children("form").length > 1){
            $("#goods_config_div").children("form:last-child").remove();
            formnum--
            console.log(formnum)
         }else {return  }
     }

    console.log( $("#f1").serializeArray());

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



$('#pay').bind('click',function(){
    var btime=getNowDate();
     try{fbq('track', 'InitiateCheckout')}catch(e){};
            $.ajax({url:"{{url('/visfrom/setorder')}}"+"?id="+{{$vis_id}}+"&date="+btime,async:false});    
    //整理表单数据；
    var dataArr=$("form#f1").serializeArray();
    var dataObj={};
    var datasObj={};
    var fromArr=$("#goods_config_div").children("form").serializeArray();

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
        layer.msg('詳細地址不能為空！');
        return false;
    }
    if(datasObj.city==null||datasObj.city==''){
        layer.msg('請選擇地區信息！');
        return false;
    }
    if(datasObj.firstname==null||datasObj.firstname==''){
        layer.msg('請填寫收貨人姓名');
        return false;
    }
    if(datasObj.telephone==null||datasObj.telephone==''){
        layer.msg('請填寫收貨人手機號碼');
        return false;
    }
    layer.msg("訂單提交中，請稍等");
    $.ajax({
       type: "POST",    
       url: "/saveform",
       data:datasObj,
       success: function (data) {
           location.href=data.url;
       },
       error: function(data) {
           
       }
    }) ;
       
    
            //记录购买事件
            
})
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
    jQuery(function(){
        var html1 ='';
//        html +='<div class="mui-input-row need_email">';
        html1 += ' <label><span style="color:red;">*</span>Email:</label>';
        html1 +='<input type="text" placeholder="選填，填寫收件人電子郵件" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" datatype="/^([0-9A-Za-z\-_\.]+)@([0-9a-z\.]+)$/g" name="email" class="mui-input-clear"></div>';
        var html2 = '';
        html2 += "<label>Email:</label>";

        html2 += '<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" class="mui-input-clear">';

        var payty =  jQuery('input[name=pay_type]:checked').val();
        if(payty==7||payty==2){
            jQuery('.need_email').children().remove();
            jQuery('.need_email').append(html1);
        }else{
            jQuery('.need_email').children().remove();
            jQuery('.need_email').append(html2);
        }
        jQuery('input[name=pay_type]').click(function(){
            if(jQuery(this).val()==7 || jQuery(this).val()==2){
                jQuery('.need_email').children().remove();
                jQuery('.need_email').append(html1);
            }else{
                jQuery('.need_email').children().remove();
                jQuery('.need_email').append(html2);
            }

        });

    });

</script>

<script type="text/javascript">
    $(function(){
        $.ajax({
                url:"{{url('/gethtml')}}",
                type:'post',
                data:{'id':{{$goods->goods_id}},'_token':"{{csrf_token()}}"},
                datatype:'html',
                success:function(msg){
                 $('#addcart').html(msg);
                    // window.setTimeout("window.location='{{url('admin/contro/index')}}'",2000);       
                }
            })
    })
</script>

<script>
    var isuse =true;
jQuery(function(){
   
       $('#save input').on('focus',function(){
             if(isuse){
                 try{fbq('track', "AddPaymentInfo");}
                 catch(e){}
                 isuse=false;
                 console.log('1');
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
});
</script>
        <script>
        jQuery(function(){setFrom();});
        </script>


</body>
</html>