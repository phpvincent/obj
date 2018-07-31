 var _PAGE_SIZE = 10;
 var _WEB_PATH = document.getElementById('baseScript').getAttribute('path');
 
 var _ONCLICK = "click",
     _ONDBCLICK = "doubletap",//双击屏幕
     _ONLONGCLICK = "longtap",//长按屏幕
     _ONHOLD = "hold",//按住屏幕
     _ONRELEASE = "release",//离开屏幕
     _ONSWIPEUP = "swipeup",
     _ONSWIPEDOWN = "swipedown",
     _ONSWIPELEFT = "swipeleft",
     _ONSWIPERIGHT = "swiperight";
	 
(function($2) {
	_WEB_PATH = _WEB_PATH + "/mobile/page/";
	$2.openWin = function(params){
		//$.openWindow(params);
		window.location.href = params.url;
	};
	
	$2.getParam = function(paramName){
		var match = RegExp('[?&]' + paramName + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace('/+/g', ' '));
	};
	
	/*$2.$$ = function(eName){
		return jQuery(eName);
	};*/
	
	$2.id = function(id){
		return document.getElementById(id);
	};
	
	$2.ajax2 = function(url, data, onSuccess, onError){
		
		jQuery.ajax({
			url:_WEB_PATH + url,
			data:data,
			dataType:'json',
			type:'post',
			timeout:10000,
			success:function(rdata){
				if(onSuccess) onSuccess(rdata);
			},
			error:function(xhr,type,errorThrown){
				//异常处理；
				//alert("ajax2 error: " + errorThrown);
				console.log("ajax2 error: " + errorThrown);
				if(onError) onError(errorThrown);
			}
		});
	};
	
	$2.toast = function(msg){
		var box = $2('<div class="message-box"></div>');
		box.text(msg);
		$2("body").append(box);
		box.show();
		window.setTimeout(function(){
			box.hide(1000);box.remove();
		}, 3000);
	};
	
	$2.loading = function(isShow){
		var ldbox = $2('<div class="ajax-loading"></div>');
		if(isShow){
			ldbox.show();
		}else{
			ldbox.hide();
		}
	};
	
	$2.confirm = function(msg, onYes, onNo){
		if(window.confirm(msg)){
			if(onYes) onYes();
		}else{
			if(onNo) onNo();
		}
	};
	
}(window.$2 = jQuery.noConflict()||{}));


$2(document).ready(function(e) {
	 $2(".mui-badge").each(function(index, element) {
        if($2(this).text()=='0'||$2(this).text()==''){
			$2(this).hide();
		}else{
			$2(this).show();
		}
     });
	 
	 $2('.touch-link').each(function(index, item){		 
	    $2(item).bind(_ONCLICK, function() {
			var _url = this.getAttribute('data-link');
			var _id = this.getAttribute('data-id');
	
			window.$2.openWin({
				url: _url, 
				id:_id,
				styles: {
					top: '45px',
					bottom: '50px',
					bounce: 'vertical'
				}
			});
	    }); 
    });
	
	$2('.mui-action-back').each(function(index, item){		 
		$2(item).bind(_ONCLICK, function() {
			window.history.go(-1);
		});
	});

	/*mui('.mui-tab-item').each(function(index,item){
		item.addEventListener('tap', function(e) {
			var _url = this.getAttribute('href');
			var _id = this.getAttribute('id');
			window.location.href = _url;
		});
	});*/
 });

 // 评论分页函数
 function goPage(pno,psize){
	 var itable = jQuery("#idData");
	 var num = itable.find('.discuss_content').length;//获取所有行数(所有记录数)
//        console.log(num);
	 var totalPage = 0;//总页数
	 var pageSize = psize;//每页显示行数
	 //总共分几页
	 if(num/pageSize > parseInt(num/pageSize)){
		 totalPage=parseInt(num/pageSize)+1;
	 }else{
		 totalPage=parseInt(num/pageSize);
	 }
	 var currentPage = pno;//当前页数
	 var startRow = (currentPage - 1) * pageSize+1;//开始显示的行  31
	 var endRow = currentPage * pageSize;//结束显示的行   40
	 endRow = (endRow > num)? num : endRow;    //40
//        console.log(endRow);
	 //遍历显示数据实现分页
	 for(var i=1;i<(num+1);i++){
		 var irow = itable.find('.discuss_content')[i-1];
		 if(i>=startRow && i<=endRow){
			 irow.style.display = "block";
		 }else{
			 irow.style.display = "none";
		 }
	 }
	 var page="";
	 page += "<a href=\"javascript:\" onClick=\"goPage("+(1)+","+psize+")\"><span>&lt;</span></a>";
	 for(var i=1;i<=totalPage;i++){
		 if(i == currentPage){
			 page += '<span><a href="javascript:" style="color:#ff0000;">'+i+'</a></span>';
		 }else{
			 page += "<span><a href=\"javascript:\" onClick=\"goPage("+i+","+psize+")\">"+i+"</a></span>";
		 }
		 page += "&nbsp;";
	 }
	 page += "<a href=\"javascript:\" onClick=\"goPage("+(totalPage)+","+psize+")\"><span>&gt;</span></a>";
	 jQuery('#paging').html(page);
	 if(!scroll){
		 jQuery('html, body').animate({scrollTop: jQuery("#detial-appraise").offset().top - 60},1000);
	 }
 }

 