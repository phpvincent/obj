// JavaScript Document
function addCart(goodsId, num, onSuccess, onError){
	var params = "gid=" + goodsId +"&num=" + num + "&ran=" + Math.random();
	$2.ajax2('cart/addCart',params, function(msg) {	
			if(msg > 0){
				$2("#cartNum").show();
				//$2.toast("已加入购物车！");
				if(onSuccess) onSuccess(msg);
			}else{
				$2.toast("修改失败！");
				if(onError) onError(msg);
			}
			
		}, function (err) {  
			$2.toast("修改失败！");
			if(onError) onError(err);
		}
    );
}
window.index=0;
//再选择一件
function buyonemore(callback)
{           
    index ++;    
    var $new = jQuery(".pro_color:eq(0)").clone(true);
    $new.find('.mui-icon-closeempty:eq(0)').css('display','block')       
    jQuery.each($new.find('input[type=hidden]'),function(){
        var name = jQuery(this).data('name')||'';
        if(name)
        {
            jQuery(this).attr('name','options['+index+']'+name);
        }
    });
    //获取复制的数量,进行填充
    var append_num = $new.find('input[name=specNumber]').val() || 1;    
    $new.find('input[type=number]').val(append_num); 
    $new.find('.show-num').val(append_num);       
    jQuery(".goods-main").append($new);
    $new.hide(); 
    getAllNumber();   
    if(jQuery.isFunction(callback))
    {
        callback($new);
    }
    $new.slideDown(500,function(){
        mui('.mui-numbox').numbox();  
        getAllNumber();         
    });        
}	
//求和商品总数
function getAllNumber()
{
    var _num = 0;        
    jQuery.each(jQuery('.show-num'),function(){
        _num += parseInt(jQuery(this).val());
    }); 
    jQuery('input[name=number]').val(_num);
    jQuery("#quantity").html(_num||1);
}

jQuery(function(){
    input_number = jQuery('input[name=number]').val();
    //关闭按钮效果
    jQuery(document.body).on('click',".mui-icon-closeempty",function(event) {
        var that = jQuery(this);
        jQuery(this).parents('.pro_color').slideUp(500,function(){
            that.parents('.pro_color').remove();
            getAllNumber();
        });                   
    });    
    //加减按钮操作
    jQuery('.mui-numbox-btn-minus,.mui-numbox-btn-plus').click(function(){
        var that = jQuery(this);
        var _num = 0;       
        setTimeout(function(){
            num = that.siblings('input[name=specNumber]').val();
            that.siblings('.show-num').val(num);
            getAllNumber();
        },100);        
    });
});

