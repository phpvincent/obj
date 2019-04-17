
<!DOCTYPE html>
<html>
  <head>
    <title>[fleekfly]訂單狀態查詢</title>
	  	  <link rel="shortcut icon" href="/images/1508385777747154.png"/>
	<meta name="Description" Content="">
    <meta name="Keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="/css/mui.min.css" rel="stylesheet">
	<link href="/css/iconfont.css" rel="stylesheet">
	<link href="/css/base.css" rel="stylesheet">
	<link href="/css/component.css" rel="stylesheet">
	<link href="/css/detail.css" rel="stylesheet">

    <style type="text/css">
	<!--
		.fixed {
			position: fixed;
			z-index: 999;
			top: 0px;
		}
		 .fixed {
			position: fixed;
			top: 0px;
			width: 100%;
			background-color: rgb(255, 255, 255);
			max-width: 640px;
			min-width: 320px;
			height: 40px;
		}
		 .fixed a {
			background-image: url("/images/zuo.png");
			background-size: 30px auto;
			display: block;
			width: 30px;
			height: 30px;
			margin: 6px 0px 0px 20px;
			float: left;
		}
		 .fixed h4 {

			font-size: 22px;
			text-align:center;
			color:#fff;
			font-weight: normal;
			line-height: 40px;
			background:#414141;
		}
		 .fixed h4 span{ width:70%; float:left;}
		.fixed h4 img{ width:22px; height:auto;vertical-align:middle;}
		 .wwddcc {
			margin-top: 48px;
			height: auto;
			background-color: rgb(255, 255, 255);
			padding: 20px;
			padding-top:5px;

		}
		 .wwddcc .textbox input {
			width: 78%;
			height: 30px;
			padding-left: 10px;
			border: 1px solid #000;
			border-radius: 2px 2px 2px 2px;
			float: left;
		}
		 .wwddcc #btnQuery {
			display: block;
			width: 20%;
			margin-left: 2%;
			height: 30px;
			float: left;
			line-height: 30px;
			background-color:#F00;
			text-align: center;
			font-size: 14px;
			color: rgb(255, 255, 255);
			cursor: pointer;
			border-radius: 4px 4px 4px 4px;
		}
		.details{
			background-color: rgb(255, 255, 255);
			max-width: 640px;
			min-width: 320px;
			padding: 10px;
			margin: 10px auto;
    		overflow: hidden;
		}
		.clear{ clear:both;}
		.product_image{ width:22%; height:auto; float:left;}
		.check_show{ width:66%; float:left; margin-left:2%;}
		.check_show h2{ font-size:14px; font-weight:normal; line-height:20px; height:20px;}
		.check_sorce{ width:100%; height:40px; line-height:40px; margin:0 auto; background:#edecec; color:#000; margin-top:0px;}
		.check_sorce p{ color:#000; font-size:16px;}
		.check_sorce img{ width:34px; height:auto; vertical-align:middle; padding-left:2%; padding-right:1%;}
		.show_check{ width:100%; height:auto; margin:0 auto; }
		.show_check table{ width:98%; height:auto; text-align:center; font-size:12px; margin:0 auto; border:1px solid #000;}
		.show_check table tr{ border:1px solid #000;}
		.show_check table tr td{ border:1px solid #000;}
		#txtkey{
			font-size:14px;
		}
		.no-data{padding-left:20px;}
		.top{ background-color:#ddd; font-weight:bold}
		.back_index {
			width: 120px;
			height: 30px;
			margin: 0 auto;
			background: #F00;
			line-height: 30px;
			color: #fff !important;
			text-align: center;
			margin-bottom: 15px;
		}
		.check_show h2{ font-size:14px; font-weight:normal; line-height:28px; height:auto;}
		.product_image { margin-top:12px;}
		.wwddcc { padding-top:15px;}
		@media screen and (max-width:656px){.product_image{ width:21.8%;}.check_show h2{line-height:18.5px; height:auto;}}
		.check_show h2{ font-size:14px; font-weight:normal; line-height:28px; height:auto;}
		.product_image { margin-top:12px;}
		.wwddcc { padding-top:15px;}
		@media screen and (max-width:656px){.product_image{ width:21.8%;}.check_show h2{line-height:18.5px; height:auto;}}
		@media screen and (max-width:656px){.product_image { margin-top:7px;}}
		.fixed h4 { margin-top:0;}
@-moz-document url-prefix(){.wwddcc .textbox input { width:73.5%;}}
@media screen and (max-width:656px){@-moz-document url-prefix(){.wwddcc .textbox input { width:70%;}}}
		.fixed a { position:absolute;}
		@media screen and (max-width:656px){.check_show { width:75%;}}
		.check_sorce{ background:#fff; font-weight:bold;}
		.check_sorce p img{ width:34px; height:22px; padding:0;}

	-->
	.heimao{ display:none;}
.footer_jp{ display:none;}
@media screen and (max-width: 656px){.check_sorce p { font-size:14px !important;}}
	</style>

</head>
<body>


<div class="fixed">
  <h4> <a href="javascript:history.go(-1);"></a>
	  訂單查詢</h4>
</div>

<div class="mui-content" style="background:#fff">
  <div class="wwddcc">
	<div class="check_sorce">
		<!-- <p>
			<img src='https://cdn.uudobuy.com/skin/default/images/heimao.png' class='heimao'>			本數據由黑貓宅急便和新竹物流官方提供：		</p> -->
	</div>
	<div style="color: #39424a; line-height: 2">
		訂單號/物流單號(填寫一項即可查詢)		<!--（<font style=" font-size:14px;">一つだけ記入すればいい</font>）-->
</div>
	<div class="textbox">
		<form id="queryForm" action="/product/trackingform" method="post">
			<input name="queryNo" value="" id="txtkey" class="text" placeholder="填寫相關訊息查詢" type="text">
		</form>
	</div>
	<a id="btnQuery">立即查詢</a>
	<div class="clearfix"></div>
  </div>


	<table class="tablelist"></table>
<div class="details">
	   
 </div>



  <!--
  <div class="details">
	<div class="product_image">
		<img src="/upload/images/goods/17050243000941526825.jpg">
	</div>
	<div class="check_show">
		<h2><b>產品名稱：</b>花花公子POLO衫</h2>
		<h2><b>訂單編號：</b>17070127002013540229</h2>
		<h2><b>配送公司：</b>黑貓宅急便</h2>
		<h2><b>運單編號：</b>8502603863</h2>
	</div>
  </div>
	<div class="clear"></div>

	<!--div class="check_sorce">
	  <p><img src="/media/mobile/images/heimao.png">本數據由黑貓宅急便官方提供：</p>
	</div-->
	<div class="clear"></div>

    
        <div class="clear"></div>

        <div class="clear"></div>
        <div style="padding:0px;padding-bottom: 10px;">
            <div style="width:100%; background:white;">
								<div style="width:100%; background:white;"><img src="/images/footer.jpg" width="100%"></div>			</div>
  			<div style="padding:14px 20px 10px 20px;text-align:left;  background-color:#eee;color:#7B7A7A; margin-top:5px;">
               <p style="margin-bottom:0;"></p>
				<div class="buyinfo_note" style=" line-height:16px;">
					<strong>溫馨提示：：</strong>
										收到商品後有任何疑問請聯繫在線客服或發郵件至<a href='mailto:hyfhdcjn@gmail.com' style='color:#F8770E'>hyfhdcjn@gmail.com</a> 。同時請告知您的姓名/聯繫方式/訂單編號，我們會快速的給您及時處理，祝您購物愉快！				</div>
				<p></p>
  			</div>
		</div>
        <div class="back_index"><a  href="javascript:;" onclick="goHome()" style="color:#fff">返回首頁</a></div>
  </div>

  <script src="/js/jquery.min.js"></script>
  <script type="text/javascript" charset="utf-8">
    $(function (){
    	
		$("#btnQuery").click(function(e) {
			if($("input[name='queryNo']").val()==''){
				alert('訂單號/物流單號(填寫一項即可查詢)');
				return;
			}
            $("#queryForm").submit();
        });

		var tab = $(".tablelist");
		tab.hide();
		tab.find("a").each(function(index, element) {
            $(this).attr("href", "javscript:void(0);");
        });
        $('#queryForm').bind('submit',function(){
        	 $.ajax({
                url:"{{url('/getsendmsg')}}",
                type:'post',
                data:{'msg':$("input[name='queryNo']").val(),'_token':"{{csrf_token()}}"},
                datatype:'html',
                success:function(msg){
                	if(msg!='false'){
                		  $('.details').html(msg);
                	}else{
                		  $('.details').html("<span style='color:#f00;'>訂單號碼錯誤，無對應信息，請重新輸入</span>");
                	}
                    // window.setTimeout("window.location='{{url('admin/contro/index')}}'",2000);       
                }
            })
        	 return false;
        })
		function addRec(status, intime, addr){
			var tr = $("<tr></tr>");
			var td = $("<td></td>");
			td.html(status);
			tr.append(td);

			td = $("<td></td>");
			td.html(intime);
			tr.append(td);

			td = $("<td></td>");
			td.html(addr);
			tr.append(td);

			tab.append(tr);
		}
                if(tab.find("tr:eq(1)").find("td").size()==3){
			var td = $("<td></td>");
			td.text("");
			td.insertBefore(tab.find("tr:eq(1)").find("td:eq(0)"));
		}
		tab.find("tr:eq(1)").find("td").each(function(index, element) {
            if(index==0){
				$(this).attr("rowspan", tab.find("tr").size());
			}else if(index>0){
				$(this).attr("bgcolor", "yellow");
			}
        });
		tab.slideDown(500);
	});
	function getParam(paramName) { 
    paramValue = "", isFound = !1; 
    if (this.location.search.indexOf("?") == 0 && this.location.search.indexOf("=") > 1) { 
        arrSource = unescape(this.location.search).substring(1, this.location.search.length).split("&"), i = 0; 
        while (i < arrSource.length && !isFound) arrSource[i].indexOf("=") > 0 && arrSource[i].split("=")[0].toLowerCase() == paramName.toLowerCase() && (paramValue = arrSource[i].split("=")[1], isFound = !0), i++ 
    } 
    // return paramValue == "" && (paramValue = null), paramValue 
		if(paramValue !== "" && paramValue != null){
			$("input[name='queryNo']").val(paramValue)
			
			setTimeout("$('#queryForm').submit();",500)
		}
} 
getParam('order_id')
function goHome(){
        var u = 'http://{{$url}}';
    location.href=u;
        //window.location.href=u;
    }
  </script>
</body>
</html>

