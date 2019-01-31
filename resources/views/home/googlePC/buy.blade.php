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
            .uncheck{
                border:1px solid #ccc;
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
            /* 层叠掉样式 */
            body .mui-content .pro_info{
                background: url("");
                background-color: #fff;
            }
            body .mui-content .pro_info:after{
                background: url("");
                content:none;
            }
            #addcart .chose_cart{
                background-color: white;
                color: black !important;
                border: 2px dashed red !important;

            }
            #addcart .unchose_cart{
                border: none !important;
            }

        
        </style>
        <!-- 弹窗样式 -->
        <style>
            .Popup{
                display: none;
                top:0;
                left:0;
                right:0;
                bottom:0;
                z-index:9999999999;
                position:fixed;
                background-color:rgba(0,0,0,0.3)
            }
            .Popup>div{
                height:80%;
                width:1190px;
                position: absolute;
                transform: translate(-50%, -50%);
                top: 50%;
                left: 50%;
            }
            .Popup>div>div{
                height:100%;
                width:100%;
                overflow-y: auto;
                
                background: #fff;
                padding:50px;
                padding-bottom:30px;
            }
            .Popup>div .Close{
                height:30px;
                line-height:30px;
                width:100%;
                left:0;
                text-align: center;
                position: absolute;
                bottom:0;
                background: #6b6868;
                color:#fff;
                cursor:pointer;
            }
            .Popup>div h3,.Popup>div h6{
                text-align: center;
                border-bottom: 2px solid;
            }
            .popupBox{
                padding:50px;
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
        <script src="/js/diqu/zhongdongCity.js"></script>
        <script src="/js/Validform.min.js"></script>
        <script src="/js/Validform.min.js"></script>
        <link href="/css/addcart.css" rel="stylesheet">


         <!-- <script src="/js/addcart.js"></script> -->
         <!--gleepay-->
        <script type="text/javascript" src="/js/broser.js"></script>
        <style type="text/css">
            	.chose_cart{
            		background-color: #00923f;
            		color: white !important;
            		border:1px dashed #ccc !important;
            	}
            	.unchose_cart{
            		background-color: white;
            		color: black !important;
            		border:1px dashed #ccc !important;
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
                'ea':'AddToCart',
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

</head>
<body style="min-width: 1190px">

<!--gleepay-->
<!--国内网站需修改导航内容，把头部导航抽象到 nav_checkout中 -->
<header class="" style="background:#fff;min-width: 1190px;overflow: hidden;height: 51px;">
    <a class=" mui-icon mui-icon-left-nav mui-pull-left" style="color:#333; padding-top: 15px;    cursor: pointer; " onclick="url_href()"></a>
    <img src="/img/pc_kuaidi.jpg" alt=""style="    width: 70%;">
    <!-- <h1 class="mui-title">Checkout</h1> -->
</header>
<div class="Popup Popup_1">
        <div>
        <span class=" Close_1"  ><img style="width:22px;position: absolute;top: 3%;left: 95%;cursor: pointer;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAVCAYAAABG1c6oAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE0SURBVDhPtdLbcoMgFAXQ/v8/Il5DtNZ7mg5J3AWFFLloHtI9cx7EM0vw8IE35z/BGWPFUA439bwf3jCwxu1V4IxrlYISAhIlYOO8LgfC2wJxJHoJRW6hApzBv/IV07WD8u6EZMF0URTdQ71V4O3Socyo0STKg94HZmER4rzCxP/6nkc+Ql2MgFqYzGYoQbS2jymwzMVkDFBGoi3ONmpVCJOxQBmJ1mCpH93DZDygzAPXWl0js6JY/NO76vHHv8PujJRamC6a4vP75R0KbChdzBoIoRnqn8N/6MeihKEZaxRJtFkPoQoU2OTDTmiXAayDctHcQQV4hOm8hi4gF0fNDNDFdOTHLVQMqTQm/zyyRsOYjkQr5LFABVZN22u0GQofewyB6W0j0R79xb2TBvievBkEfgEk9VPLGAMbXwAAAABJRU5ErkJggg==" alt=""></span>
            <div>
                <h3>PRIVACY POLICY</h3>
                <div>
                    <strong> What personal data do we collect about you?</strong>
                    <p>We collect personal data from you when you provide it to us directly and through your use of the Site. This information may include:</p>
                    <p>
                    •    Information you provide to us when you use our Site (e.g. your name, contact details, product reviews, and any information which you add our site);
                    </p>
                    <p>
                    •    Transaction and billing information, if you make any purchases from us or using our Site (e.g. PayPal details and delivery information);
                    </p>
                    <p>•    Records of your interactions with us (e.g. if you contact our customer service team, interact with us on social media);</p>
                    <p>•    Information you provide us when you enter a competition or participate in a survey;</p>
                    <p>•    Information collected automatically, using cookies and other tracking technologies .</p>
                </div>
                <div>
                    <strong>What do we use this personal data for?</strong>
                    <p>Depending on how you use our Site, your interactions with us, and the permissions you give us, the purposes for which we use your personal data include:</p>
                    <p>•    To fulfill your order </p>
                    <p>•    To manage and respond to any queries or complaints to our customer service team. </p>
                    <p>•    To improve and maintain the Site, and monitor its usage.</p>
                    <p>•    For market research, e.g. we may contact you for feedback about our products.</p>
                    <p>•    For security purposes, to investigate fraud and where necessary to protect ourselves and third parties.</p>
                    <p>•    To comply with our legal and regulatory obligations.</p>
                    <p>We rely on the following legal basis, under data protection law, to process your personal data:</p>
                    <p>•    Because the processing is necessary to perform a contract with you, or take steps prior to entering into a contract with you (e.g. where you have made a purchase with us, we use your personal data to process the payment and fulfill your order).</p>
                    <p>•    Because it is in our legitimate interests as an e-commerce provider to maintain and promote our services. We are always seeking to understand more about our customers in order to offer the best products and customer experience. </p>
                </div>
                <div>
                    <strong>Who do we share this personal data with?</strong>
                    <p>We may share information with governmental agencies or other companies assisting us in fraud prevention or investigation. We may do so when:</p>
                    <p>•   Permitted or required by law; or,</p>
                    <p> • Trying to protect against or prevent actual or potential fraud or unauthorized transactions; or,</p>
                    <p> •  Investigating fraud which has already taken place. The information is not provided to these companies for marketing purposes.</p>
                    <p>We may also disclose your personal information, without notice, if such action is necessary to:</p>
                    <p>•  Conform to the edicts of the law or comply with legal process served on the Site;</p>
                    <p>•  Protect and defend the rights or property of the Site;</p>
                    <p>•  Act in urgent circumstances to protect the personal safety of users of the Site.</p>
                </div>
                <div>
                    <strong>Security </strong>
                    <p>This Site ensures that data is encrypted when leaving the Site. This process involves the converting of information or data into a code to prevent unauthorized access. This Site follows this process and employs secure methods to ensure the protection of all payment transactions. Encryption methods such as SSL are utilized to protect customer data when in transit to and from this Site over a secure communications channel. </p>
                    <p>Whilst we do everything within our power to ensure that personal data is protected at all times from our Site, we cannot guarantee the security and integrity of the information that has been transmitted to our Site.</p>
                    
                </div>
                <div>
                    <strong>Cookies</strong>
                    <p>The Site may use cookie and tracking technology depending on the features offered. Cookie and tracking technology are useful for gathering information such as browser type and operating system, tracking the number of visitors to the Site, and understanding how visitors use the Site. Cookies can also help customize the Site for visitors. Personal information cannot be collected via cookies and other tracking technology, however, if you previously provided personally identifiable information, cookies may be tied to such information. Aggregate cookie and tracking information may be shared with third parties.</p>
                    
                </div>
                <div>
                    <strong>Contact Us</strong>
                    <p>If you have any questions, concerns, or comments about our privacy policy you may contact us.</p>
                </div>
                <div class="Close Close_1">Close</div>
                
            </div>
        </div>
    </div>
    <div class="Popup Popup_2">
        <div>
        <span class=" Close_2"  ><img style="cursor: pointer;width:22px;position: absolute;top: 3%;left: 95%;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAVCAYAAABG1c6oAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE0SURBVDhPtdLbcoMgFAXQ/v8/Il5DtNZ7mg5J3AWFFLloHtI9cx7EM0vw8IE35z/BGWPFUA439bwf3jCwxu1V4IxrlYISAhIlYOO8LgfC2wJxJHoJRW6hApzBv/IV07WD8u6EZMF0URTdQ71V4O3Socyo0STKg94HZmER4rzCxP/6nkc+Ql2MgFqYzGYoQbS2jymwzMVkDFBGoi3ONmpVCJOxQBmJ1mCpH93DZDygzAPXWl0js6JY/NO76vHHv8PujJRamC6a4vP75R0KbChdzBoIoRnqn8N/6MeihKEZaxRJtFkPoQoU2OTDTmiXAayDctHcQQV4hOm8hi4gF0fNDNDFdOTHLVQMqTQm/zyyRsOYjkQr5LFABVZN22u0GQofewyB6W0j0R79xb2TBvievBkEfgEk9VPLGAMbXwAAAABJRU5ErkJggg==" alt=""></span>
            <div>
                <h3>RETURENS POLICY </h3>
                <div>
                    <p>Items can only be returned for a refund if they are unopened, unused and in a re-saleable condition with all tamper-resistant seals, packaging and any cellophane intact. You must notify us in writing that you are returning your purchase within 14 days, beginning the day after the day on which you receive the product.</p>
                    <p>
                    Please ensure that you also return any free gifts that are associated with your return items or the related order. If the free gift isn’t returned, then we reserve the right to deduct the value of the free gift from your refund.
                    </p>
                    <p>
                    We recommend a photograph is taken of the item prior to returning it if you are concerned about damage during its return journey.
                    </p>
                    <p>Please note that we do not accept returns of personalised products. </p>
                    <p><strong>Please note the order number needs to be entered without any letter at the end.</strong> If you do not have your dispatch note or invoice, please include an explanatory note quoting your order number and reason for return.</p>
                    <p>Your refund will be processed, once it has been delivered to our warehouse and within 3 working days of arriving back to our us. Refunds can take up to 1 week to show on your account; this is due to the time taken by some banks to process the payment.</p>
                    <p>We will refund you by the same payment method used to make the original order (e.g. if you have paid by PayPal, we will reimburse your PayPal account). If you have not received your refund after this time, please contact our <strong> Customer Care Team</strong> and we will be happy assist you.</p>
                </div>
                
                <div class="Close_2 Close">Close</div>
            </div>
        </div>
    </div>

<div class="mui-content">


<!--product info begin-->
<div class="pro_info" style=" border: 1px solid #dddddd;height:">
    <div class="ctxthead" style="width: 30%;">
       {{-- <div class="limgbox"><img src="{{App\img::where('img_goods_id',$goods->goods_id)->orderBy('img_id','asc')->all()[0]['img_url']}}"/></div>--}}
        @if($goods->img)
        <div class="limgbox"><img src="{{$goods->img}}"/></div>
        @endif
    </div>
    <div class="ctxtbox" style="{{$goods->img ? '' : 'position: absolute;z-index: 1000;left: 10px;'}}; width: 70%;">
        <h1>{{$goods->goods_name}}</h1>
        <h2><span style="color: rgb(255, 0, 0);"><strong>@if(trim($goods->goods_cuxiao_name)!='')【{{$goods->goods_cuxiao_name}}】@endif</strong></span><p style="display: inline-block;">{!!$goods->goods_msg!!}</p></h2>
        <div class="rpricebox" style="{{$goods->img ? '' : 'margin-top:60px;'}}">
        {{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}
        <span id="price">{{$goods->goods_price}}</span></div>
    </div>
    <div id="goods_config_div" style="width: 70%;float: left;font-size: 12px; padding: 0px 0 0 2%;">
         <ul style=" overflow: hidden;font-size: 14px;">
         </ul>
    </div>
    <div id="addcart" style="margin-bottom: 26px;">
   
    </div>
</div>

<!--product info end-->
<!--size begin-->  


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
<div class="mui-input-group" style="width: 70%;float: right;">
    <div class="mui-input-row">
            <label><span class="require">*</span>First Name:</label>
            <input type="text" name="firstname" datatype="s1-30" placeholder="Required: please enter your first name" nullmsg="填寫收件人姓名" class="mui-input-clear">
        </div>
        <div class="mui-input-row">
            <label><span class="require">*</span>Last Name:</label>
            <input type="text" name="lastname" placeholder="Required:please enter your last name" class="mui-input-clear">
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
            <label><span class="require">*</span>Detailed Address:</label>
            <input type="text" datatype="z1-300" placeholder="Required:please fill in the full address" nullmsg="address_not_correct" errormsg="address_not_correct" name="address1" class="mui-input-clear">
        </div>
        <div class="mui-input-row">
            <label><span class="require">*</span>City:</label>
            <input type="text" datatype="z1-300" placeholder="Please fill in the city" nullmsg="" errormsg="Please fill in the city" name="city" class="mui-input-clear">
        </div>
        <div class="mui-input-row" style="">
            <label><span class="require">*</span>Zip:</label>
            <input type="text" name="zip" placeholder="Required: please fill in the zip code" class="mui-input-clear">
        </div>
        <div class="mui-input-row">
            <label><span class="require">*</span>country:</label>
            <select name="state" style="margin-right:4.7%;float: left;width: 72%!important;">
                <option value="">- - Select an option - -</option>
            </select>
        </div>
        
        
        <div class="mui-input-row" style="display:none;">
            <label>Address Line2:</label>
            <input type="text" name="address2" class="mui-input-clear">
        </div>
        
            <div class="mui-input-row need_email">
            <label><span class="require">*</span>Email:</label>
            <!--<input type="text" name="email" placeholder="選填，填寫收件人電子郵件" datatype="/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" class="mui-input-clear">-->
            <input type="text" name="email" placeholder="Required:  we shall send you the order information though this Email" class="mui-input-clear">
        </div>
        <div class="mui-input-row">
            <label>Phone No.:</label>
            <input type="text" datatype="/^\d+$/" placeholder="Optional:please enter your telephone number " nullmsg="填寫收件人聯繫電話" errormsg="請填寫正確的電話號碼" name="telephone" class="mui-input-clear">
        </div>
        <div class="mui-input-row" style=" height:66px">
            <label>Message:</label>
            <textarea name="notes" placeholder=" Optional: such as other phone number, product specification or delivery time, etc. "></textarea>
        </div>

</div>
<div style="float: left;width: 30%;">
<p  style="background-color: #d2d2d2;text-align: left;">·PRIVACY POLICY </p>
<p><strong> What personal data do we collect about you?</strong></p>
We collect personal data from you when you provide it to us directly and through your use of the Site. This information may include:
    •    Information you provide to us when you use our Site (e.g. your name, contact details, product reviews, and any information which you add our site)......
<span class="privacyPolicy" style="font-size:12px;text-decoration:underline ;cursor:pointer;color: #007aff;">CLICK HERE FOR DETAILS</span>
<p  style="background-color: #d2d2d2;text-align: left;cursor:pointer;">RETURENS POLICY </p>
Items can only be returned for a refund if they are unopened, unused and in a re-saleable condition with all tamper-resistant seals, packaging and any cellophane intact. You must notify us in writing that you are returning your purchase within 14 days, beginning the day after the day on which you receive the product......
<span class="privacyPolicy_1" style="font-size:12px;text-decoration:underline ;cursor:pointer; color: #007aff;" >CLICK HERE FOR DETAILS</span>
</div>
<!--table end-->
<!--paypal begin-->
<div class="paymentbox">
    <ul style="border: none;">

        <li>
            @if(in_array('0',$goods->goods_pay_type))
          <div class="mui-input-row mui-radio mui-left cash-on-delivery" style="display: inline-block ;float: right;width: 25%;">
              <input checked="" name="pay_type" id="pay_1" value="1" type="radio">
            <label>
            cash on delivery         </label>
              <span style="width:100px;">
                                    <img src="/images/cash.jpg" alt="" id="cash"/>
                                                  </span>
          </div>
          @endif
          @if(in_array('1',$goods->goods_pay_type))
          <div class="mui-input-row mui-radio mui-left cash-on-delivery" style="display: inline-block;float: right;width: 25%;">
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
    
<!--button begin-->
<div class="btndiv">
    <button id="pay" type="button" class="btnstyle01" style="background-color: #00923f;float: right;width: 25%;">Start Order</button>
</div>


<!--button end-->
<!--footer begin-->
    <!--把最下方的底部内容抽象到newfooter中-->
    <div class="newfooter">
    <!-- Warm Tips: available for Free shipping+ Cash on delivery + Return or exchange of goods without reasons by 7 days after acquired. If you have any questions about our products, please contact our online Customer Service Team, or send email to 
        <a href="mailto:yejforlh@gmail.com" style="color:#F8770E">yejforlh@gmail.com</a>. -->
    </div>
    <!--footer end-->
<input type="hidden" name="id" value="103107897"/>
<input type="hidden" name="poid" value=""/>
<input type="hidden" name="append" value="0"/>
<input type="hidden" name="salerule_id" value="0"/>
<input type="hidden" name="currency_code" value="NTD"/>
<input type="hidden" name="currency_id" value="1"/>
<input type="hidden" name="amount" value="0"/>
</form>
    

<script>
    //第几件翻译
    function jianshu(a){
    return 'item.'+a
  }
function url_href()
{
    window.location.href = 'http://{{ $home_url }}';
}
    var issubmit=true;
    var formnum=1; //商品属性组数计数；
    var cuxiao_num={!!$cuxiao_num!!};  //如果有默认数量；
    var  addClickEven= function (){
         $("#goods_config_div").on('click',"input.radio",function(){
            $(this).parent().parent().find('label[for]').attr('class','uncheck') ;
             $(this).parent().parent().find('span').attr('class','uncheck');
         $(this).next().attr("class",'ischeck');  
          })
        }
         addClickEven(); 
    //商品li点击监听；
    (function toggleLi(){
        $("#goods_config_div ul").on('click',"li",function(){
            console.log($(this).attr("formNum"))
               var formNum= $(this).attr("formNum");
               $("#goods_config_div form").hide()  //点击对应li 显示对应form；
                $("#"+formNum).show();
                $(this).siblings().css("background-color","");
                setTimeout(() => {
                    $(this).css("background-color","#eee");
                }, 250);
                //动画效果；
                $("#goods_config_div form").css({ 'position':' relative','left':'10px'});
                $("#goods_config_div form").animate({'left':' 0'});
        })
    })()
   
    if( cuxiao_num !=null && typeof(cuxiao_num) !='undefinde' && cuxiao_num !=''){
        formnum=Number(cuxiao_num);  //如果有默认数量；
    }
    var a={!!$goods_config_arr!!}
        console.log(a);
        var addform=function(e){
            console.log('开始addform')
        var addhtml='';
        var color25="";
        var eNum=$("#goods_config_div form").length+1;
        var flag=false;
        $.each(a,function(i,val){
        // console.log(i,val);
            if(val){flag=true};     
            var colorBut=''
            $.each(val,function(j,item){
             if(item.config_val_img){     //如果是展示图片的话显示这一组HTML；
                if(j===0){
                    colorBut= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label class="ischeck" style="margin-bottom: 2px;width: 20%;text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }else{
                    colorBut+= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label class="uncheck" style="margin-bottom: 2px;width: 20%;text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }        
              }else{
                if(j===0){
                    colorBut= '<label style="margin-bottom: 2px;display:inline-block"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="ischeck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }else{
                    colorBut+= '<label style="margin-bottom: 2px;display:inline-block"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }
              }
               
            })
            color25+='<div calss="radiobox"> <dl class="addcart-specs-content"><dd><strong>'+val[0].goods_config_msg+'：</strong><br>'+colorBut+'</dl></div>';
         })
         addhtml='<form id="'+e+'" style="display: none;padding: 5px 0; min-height: 150px;    background: url(/img/pc_bg.png) no-repeat right bottom #eee; box-shadow: rgb(136, 136, 136) 5px 5px 5px;overflow: auto;"><div><strong style="display: none;">item'+eNum+'</strong></div'+ color25+'</form>';   //每件商品的所有属性的HTML放入一个form；
         if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
         var tabLi='<li style="float: left;padding: 5px 10px; border-radius: 5px 5px 0px 0px; cursor: pointer;" formNum="'+e+'">item'+eNum+'</li>'
         if(flag){ $("#goods_config_div ul").append(tabLi); }
         if($("#goods_config_div form").length==1){$("#goods_config_div form").show();} //只有一个from的时候让from直接显示；
         if($("#goods_config_div form").length==1){$("#goods_config_div ul li").css("background-color","#eee");}
         
         // addClickEven()                                           //每增加一組屬性節點，監聽一次ischeck；
          }
     addform("f1");                                          //默认一组商品的所有属性fromid为f1；
     //删除一组商品属性的form；
     var removeform= function(){
         if($("#goods_config_div").children("form").length > 1){
             //如果删除的是选中的from，那么让前一个from show（）；
             if($("#goods_config_div").children("form:last-child").css("display")=="block"){
                $("#goods_config_div").children("form:last-child").remove();
                $("#goods_config_div ul>li:last").remove();  //移除最后一个 li标签；
                $("#goods_config_div form:last").show();
                $("#goods_config_div ul li:last").css("background-color","#eee");

             }else{
                $("#goods_config_div").children("form:last-child").remove();
                $("#goods_config_div ul>li:last").remove();  //移除最后一个 li标签；
             }

            formnum--
         }else {return  }
     }
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
                if(vname.test(jQuery("input[name='firstname1']").val())){
                    /*layer.msg("請填寫您的真實姓名");
                    return false;*/
                }
                if(_checkBlackName(jQuery("input[name='firstname1']").val())){
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
         layer.msg('The detailed address can not be empty.');
         return false;
     }
     if(datasObj.state==null||datasObj.state==''){
         layer.msg('Please select an option.');
         return false;
     }
     if(datasObj.city==null||datasObj.city==''){
         layer.msg('This is a required field.');
         return false;
     }
     if(datasObj.firstname==null||datasObj.firstname==''){
         layer.msg("Please fill in the consignee's name.");
         return false;
     }
     if(datasObj.lastname==null||datasObj.lastname==''){
         layer.msg("Please fill in the consignee's name.");
         return false;
     }
     var res = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;//邮箱
     if(!res.test(datasObj.email)){
         layer.msg("Please enter your email address.");
         return false;
     }
     // if(datasObj.telephone==null||datasObj.telephone==''){
     //     layer.msg("Please fill in the consignee's cell phone number.");
     //     return false;
     // }
     if(datasObj.zip==null||datasObj.zip==''){
         layer.msg("Please fill in the correct zip code.");
         return false;
     }
     // var zipre = /^[0-9]{5}$/;//判断马来西亚邮政编码五位正整数；
     // if(!zipre.test(datasObj.zip)){
     //     layer.msg('Please fill in the valid postal code.');
     //     return false;
     // }
     // var re = /^[0-9]+.?[0-9]*/;//判断字符串是否为数字//判断正整数/[1−9]+[0−9]∗]∗/  
     // if(!re.test(datasObj.telephone)){
     //     layer.msg('Please fill in the valid cell phone number.');
     //     return false;
     // }
     datasObj.firstname=datasObj.firstname+"\u0020"+datasObj.lastname;
     datasObj.address1=datasObj.address1+"(Zip:"+datasObj.zip+")";//后台不想多加字段，把邮政编码加在地址后面；
    //  layer.msg("Please wait for the order submitted");
     var index = layer.load(2, {shade: [0.15, '#393D49'],content:'Please wait for the order submitted',success: function(layero){
        layero.find('.layui-layer-content').css({'padding-top':'40px','width': '245px',  'text-align': 'center', 'color': 'red',   'margin-left':' -80px','background-position-x': '106px'});
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
                             location.href=data.url;
                        },
           
                     
            error: function(data) {
                layer.close(index);
                layer.msg('The order submission failed. Please check the network condition.');
            }
         }) ; 
         }else{
                       // location.href="/paypal_pay?datas="+JSON.stringify(datasObj);
               $.ajax({
               type: "POST",
               url: "/paypal_pay",
               data:datasObj,
               success: function (data) {
                layer.close(index);
                   if(data.err=='0'){
                       layer.msg('paymenty of the paypal failed. Please choose alternate forms of payment!');
                        issubmit=true;
                   }else{
                       var btime=getNowDate();
                       try{fbq('track', 'InitiateCheckout')}catch(e){};
                       $.ajax({url:"{{url('/visfrom/setorder')}}"+"?id="+{{$vis_id}}+"&date="+btime,async:false});
                       location.href=data.url;
                   }
               },
 
 
               error: function(data) {
                   layer.close(index);
                   layer.msg('The order submission failed. Please check the network condition.');
                 }
             }) ;
         }
         
     }else{
        layer.close(index);
         layer.msg('Orders have been submitted, not submitted repeatedly.');
     }
    
     
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
    // $(document).scroll(function () {
    //     $("#navigationBox").css('top', $(document).scrollTop());
    // });
</script>

<script>
jQuery(function(){
    jQuery("#coll_id").val(getQueryString('coll_id'));
});
</script>

<script>
                // 添加城市下拉
    var country = ['Austria','Belgium','Bulgaria','Cyprus','Croatia','CzechRepublic','Denmark','Estonia','Finland','France','Germany','Greece','Hungary','Ireland','Italy','Latvia','Lithuania','Luxembourg','Malta','Netherlands','Poland','Portugal','Romania','Slovakia','Slovenia','Spain','Sweden','United Kingdom'];
    var str='';
    for (let i = 0; i < country.length; i++) {
         str+=' <option value="'+country[i]+'">'+country[i]+'</option>';   
    }
    $('select').append(str);
    
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
//         html1 += ' <label><span style="color:red;">*</span>Email:</label>';
//         html1 +='<input type="text" placeholder="Optional, we shall send you the order information though this Email" nullmsg="填寫收件人電子郵件" errormsg="email_not_correct" datatype="/^([0-9A-Za-z\-_\.]+)@([0-9a-z\.]+)$/g" name="email" class="mui-input-clear"></div>';
//         var html2 = '';
//         html2 += "<label><span style='color:red;'>*</span>Email:</label>";

//         html2 += '<input type="text" name="email" placeholder="Optional, we shall send you the order information though this Email" class="mui-input-clear">';

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
                 console.log('123',msg);
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
                            var addCartHtml1='<div class="addcart-specs-title unfold" style=" text-align: right;"><span class="addcart-specs-title-name" style="float: right;">Total Quantity:1</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.goods.goods_price+'</span>  Only left:'+msg.goods.goods_num+'\）</span><span class="addcart-specs-status"></span></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">Total Quantity:<font>1</font> <span class="gift" style="display:none;">, Gift : <font>0</font></span>  </span><span class="addcart-footer-price-total">Total:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.goods.goods_price+'</font></span></div></div><div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">Order Summary:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div>';
                            $("#addcart").html(addCartHtml1);
                            var pricehtml=$('.addcart-footer-price-total').children('font:first');
	                        	var price=pricehtml.html().replace(/[^0-9]/ig,"")/100;
	                        $('#addcart-quantity-dec').bind('click',function(){
	                        	removeform(); // 删除一组商品属性
	                        	var num=parseInt($(this).next().val());
	                        	if(num<=1){
	                        		return false;
	                        	}
	                        	$(this).next().val(num-1);
	                        	$('.addcart-specs-title-name').html("Total Quantity:"+(num-1));
	                        	$('.addcart-footer-number-total').children('font:first').html(num-1);
	                        	$('#realprice').html(returnFloat((num-1)*price));
	                        	pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat((num-1)*price));
	                        })
	                        $('#addcart-quantity-inc').bind('click',function(){
	                        	formnum+=1
	                        	var formName="f"+formnum;
	                        	addform(formName); //增加一组商品属性；
	                        	var num=parseInt($(this).prev().val());
	                        	if(num>={{$goods->goods_num}}){
	                        		layer.msg('low stocks!');
	                        		return false;
	                        	}
	                        	$(this).prev().val(num+1);
	                        	$('.addcart-specs-title-name').html("Total Quantity:"+(num+1));
	                            $('.addcart-footer-number-total').children('font:first').html(num+1);
	                            $('#realprice').html( returnFloat((num+1)*price));
	                        	pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat((num+1)*price));
	                        })
                         })

                    }else if(msg.goods.goods_cuxiao_type=="2"){
                            $(function(){
                                var addCartHtml2= '<div class="addcart-specs-title unfold" style=" text-align: right;"><span style="float: right;" class="addcart-specs-title-name">Total Quantity:1</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.goods.goods_price+'</span>, Preferred Selection【'+msg.cuxiao[0].cuxiao_msg+'&#12305;Only left:'+msg.goods.goods_num+'）</span><span class="addcart-specs-status"></span></div><div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">Order Summary:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="1" readonly=""><span id="addcart-quantity-inc"> + </span></div></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">Total Quantity:<font>1</font> <span class="gift" style="display:none;">, Gift : <font>0</font></span>  </span><span class="addcart-footer-price-total">Total:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.goods.goods_price+'</font></span></div></div>';
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
	                            	        	$('#realprice').html( returnFloat(end_price));
	                            	        	pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat(end_price));
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
	                            	        	$('#realprice').html(returnFloat(end_price) );
	                            	        	pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+ returnFloat(end_price));
	                            	        }
                                    }
	                            
	                                $('#addcart-quantity-dec').bind('click',function(){
	                            	removeform();
	                            	var num=parseInt($(this).next().val());
	                            	if(num<=1){
	                            		return false;
	                            	}
	                            	$(this).next().val(num-1);
	                            	$('.addcart-specs-title-name').html("Total Quantity:"+(num-1));
	                            	$('.addcart-footer-number-total').children('font:first').html(num-1);
	                            	$('.addcart-footer-number-total').children('font:first').html(num-1);
	                            	num=num-1;
                                    priceMath(num);
	                            		
	                            })
	                            
	                            function zhengjia(){
	                            	
	                            	formnum+=1;
	                            	var formName="f"+formnum;
	                            	addform(formName); console.log(formnum) //增加一组商品属性
                            
	                            	// var num=parseInt($(this).prev().val());
	                            	var num = Number($('#addcart-quantity-val').val())
	                            	console.log(num)
	                            	if(num>= msg.goods.goods_num){
	                            		layer.msg('low stocks!');
	                            		return false;
	                            	}
	                            	// $(this).prev().val(num+1);
	                            	$('#addcart-quantity-val').val(num+1);
	                            	$('.addcart-specs-title-name').html("Total Quantity:"+(num+1));
	                            	$('.addcart-footer-number-total').children('font:first').html(num+1);
	                                $('.addcart-footer-number-total').children('font:first').html(num+1);
	                                num=num+1;
                                    priceMath(num);	
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
	                            $('#addcart-quantity-inc').bind('click',function(){
	                            	zhengjia();
	                            });
                            })
                    }else  if(msg.goods.goods_cuxiao_type=="3"){
                        $(function(){
                            var specialHtml='';
                            $.each(msg.special,function(i,item){
                                specialHtml+= '<div class="addcart-specs image-list"  mine_id="'+item.special_id+'" style="display: none;" data-id="416515236" data-number="5" data-price="0" data-rule="6" data-gift="1" data-option="416515236#1"><div class="addcart-specs-title" >	<img style="width: 20%;height: 50%;" class="addcart-specs-title-image" src="'+item.price_img+'"><span class="addcart-specs-title-name">'+item.price_name+'</span><span class="addcart-specs-title-number">×'+item.special_price_num+'</span><span class="addcart-specs-title-gift">Gift</span></div></div>'
                            });
                            $("#addcart").append(specialHtml);
                             var yixuanHtml='<div class="addcart-specs-title unfold" style=" text-align: right;"><span style="float: right;" class="addcart-specs-title-name">Total Quantity:'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'</span><span class="addcart-specs-arrow"></span><span class="addcart-specs-descript">（{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}<span id="realprice">'+msg.cuxiao[0].cuxiao_config.split(",")[1]+'</span>, Preferred Selection 【<span id="sell_msg">'+msg.cuxiao[0].cuxiao_msg+'</span>&#12305; Only left:'+msg.goods.goods_num+'）</span><span class="addcart-specs-status"></span></div>'
                            $("#addcart").append(yixuanHtml);
                            var buttonHtml= '';
                            var chose_cart='chose_cart';
                            var unchose_cart='unchose_cart';
                            $.each(msg.cuxiao,function(j,val){
                                  buttonHtml+='<div class="addcart-group-buttons"  style="float: right;font-size: 16px; cursor:pointer; margin: 5px;" ><div class="addcart-float-buttons-block"  data-id="7022"><span style="padding: 0 30px;"cuxiao_id="'+val.cuxiao_id+'"  class="'+ (j==0?chose_cart:unchose_cart)+'"  num="'+val.cuxiao_config.split(",")[0]+'" price="'+val.cuxiao_config.split(",")[1]+'" type_name="'+val.cuxiao_msg+'" cuxiao_special_id="'+val.cuxiao_special_id+'" >'+val.cuxiao_msg+'</span></div></div>'
                            })
                            $("#addcart").append('<div style="overflow: hidden;">'+buttonHtml+'</div>');
                            var numberHtml = '<div class="addcart-quantity"><div class="addcart-quantity-content"><label class="addcart-quantity-title">Order Summary:</label><span id="addcart-quantity-dec"> - </span><input type="text" name="specNumber" id="addcart-quantity-val" value="'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'" readonly=""><span id="addcart-quantity-inc"> + </span></div></div><div class="addcart-footer"><div class="addcart-footer-price"><span class="addcart-footer-number-total">Total Quantity:<font>'+msg.cuxiao[0].cuxiao_config.split(",")[0]+'</font> <span class="gift" style="display:none;">, Gift : <font>0</font></span> </span><span class="addcart-footer-price-total">Total:<font>{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}'+msg.cuxiao[0].cuxiao_config.split(",")[1]+'</font></span></div></div>';
                            $("#addcart").append(numberHtml);

                            $("#goods_config_div").children("form").remove(); //如果选择套餐先删除说有属性，在根据有几件商品循环几组属性；
                            $("#goods_config_div ul li").remove()
		                   	var num1=$("#addcart-quantity-val").val()-0;
		                   	formnum=0;
		                   	for(var i=1;i<=num1;i++){
		                   		formnum+=1
		                           var formName="f"+formnum;
		                           addform(formName); //增加一组商品属性；
		                   	}
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
		                   layer.msg('This item only supports package purchase');
		                   return false;
	                       })
	                       $('#addcart-quantity-inc').bind('click',function(){

		                    layer.msg('This item only supports package purchase');
		                    return false;
	                        })
                            $('.addcart-float-buttons-block').children('span').click(function(){    	
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
                            		layer.msg('Selected ');
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
                                   pricehtml.html("{{\App\currency_type::where('currency_type_id',$goods->goods_currency_id)->first()['currency_type_name']}}"+price);       //填上自定义价格无需计算；
                                   $('div.unfold .addcart-specs-title-name').html("Total Quantity:"+num);
		                        console.log(num);
		                        $("#goods_config_div").children("form").remove(); //如果选择套餐先删除说有属性，在根据有几件商品循环几组属性；
                                $("#goods_config_div ul li").remove()
		                        formnum=0;
		                        for(var i=1;i<=num;i++){
		                        	formnum+=1
		                           var formName="f"+formnum;
		                           addform(formName); //增加一组商品属性；
		                   	    }
                       	        }
                            })
                       })
                            
                }
          }  })
    })
</script>

<script>
$(function(){
        // 增加弹窗
        $('.privacyPolicy').click(function(){
        $('.Popup_1').show();
    })
    $('.Close_1').click(function(){
        $('.Popup_1').hide();
    })
    // 第二个弹窗
    $('.privacyPolicy_1').click(function(){
        $('.Popup_2').show();
    })
    $('.Close_2').click(function(){
        $('.Popup_2').hide();
    })

})
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
        </script>


</body>
</html>