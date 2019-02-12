
//=====================全局函数========================
//Tab控制函数
function tabs(tabId, tabNum){
	//设置点击后的切换样式
	jQuery(tabId + " .tab li").removeClass("curr");
	jQuery(tabId + " .tab li").eq(tabNum).addClass("curr");
	//根据参数决定显示内容
	jQuery(tabId + " .tabcon").hide();
	jQuery(tabId + " .tabcon").eq(tabNum).show();
}

/*全站通用函数集合*/
function getQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return '';
}
function setCookie(c_name,value,expireSeconds)
{
    var exdate=new Date();
    exdate.setTime(exdate.getTime()+parseInt(expireSeconds)*1000);
    document.cookie=c_name+ "=" +escape(value)+
    ((expireSeconds==null) ? "" : ";expires="+exdate.toGMTString());
}
function getCookie(c_name)
{
    if (document.cookie.length>0)
      {
      c_start=document.cookie.indexOf(c_name + "=");
      if (c_start!=-1)
        { 
        c_start=c_start + c_name.length+1;
        c_end=document.cookie.indexOf(";",c_start);
        if (c_end==-1) c_end=document.cookie.length;
        return unescape(document.cookie.substring(c_start,c_end));
        } 
      }
    return "";
}
from = '';
function setFrom()
{   
    from = getQueryString('from');     
    if(from=='')
    {                   
        from = '';
        if(get_storage('befrom')) 
        {
            from = get_storage('befrom');           
            return;
        }
        
        if(getCookie('befrom')) 
        {
            from = getCookie('befrom');            
            return;
        }            
        var utm_source = getQueryString('utm_source');
        var gclid = getQueryString('gclid');
        if(utm_source)
        {
            from = utm_source;
            if(utm_source == 'ad') from = 'facebook';        
        }     
        if(gclid) from = 'google';
    }            
    set_storage('befrom', from, 0.5);
    setCookie('befrom', from, 3600);          
}
function set_storage(key,value,expiredays)
{
    now = parseInt( new Date().getTime().toString() );//当前毫秒       
    var t = expiredays || 0;    
    var timeout = now + t * 60 * 60 * 60;   
    if(window.localStorage)
    {                
        var object = {value: value, expires: timeout};
        window.localStorage.setItem(key, JSON.stringify(object));        
    }
}
function get_storage(key)
{
    if(window.localStorage)
    {
        var object = JSON.parse(window.localStorage.getItem(key));
        var obj = object || '';
        if(obj)
        {
            var expires = obj.expires || 0;
            var value = obj.value || '';  
            now = parseInt( new Date().getTime().toString() );//当前毫秒
            if(now > expires)
            {
                window.localStorage.removeItem(key);
                return '';
            }
            return value;
        }
        return '';
    } 
    return '';   
}

function getFinalPrice()
{
    if(jQuery('.addcart-specs').length == 1)
    {
        append = 0;
    }
    final_price = optionsPrice.productPrice;
    final_price = add(final_price,append);
    jQuery.each(jQuery('span.active'),function(){
        var data_id = jQuery(this).data('id') || '';
        var data_price = jQuery(this).data('price') || '';
        if(data_id!='' && data_price!='')
        {
            final_price = add(final_price,data_price);
        }
    });
    integerRequired = 1;
    var format_price = optionsPrice.formatPrice(final_price);
    jQuery('.addcart-header-price-total').html(format_price);
}
function add(a, b) {
    var c, d, e;
    try {
        c = a.toString().split(".")[1].length;
    } catch (f) {
        c = 0;
    }
    try {
        d = b.toString().split(".")[1].length;
    } catch (f) {
        d = 0;
    }
    return e = Math.pow(10, Math.max(c, d)), (mul(a, e) + mul(b, e)) / e;
}
function mul(a, b) {
    var c = 0,
        d = a.toString(),
        e = b.toString();
    try {
        c += d.split(".")[1].length;
    } catch (f) {}
    try {
        c += e.split(".")[1].length;
    } catch (f) {}
    return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
}
function getQueryParam()
{
    setFrom();   
    var param = '';
    var current_url = window.location.href;
   //页面携带请求参数判断
   if(current_url.indexOf('?')!='-1')
   {
        var url_arr = current_url.split('?');
        param = url_arr[1];
       if(getQueryString('from') != '')
        {
            param += "&from="+from;
        }                    
   }   
   else
   {
        if(from!='')
        {
            param += "from="+from;
        }
   } 
   return param;
}


jQuery(function(){ 
    jQuery("#cryozonic_stripe_cc_owner").parents("li:eq(0)").hide();
    jQuery("input[name='billing[firstname]']").change(function(event) {
        var val = jQuery("input[name='billing[firstname]']").val();
        jQuery("#cryozonic_stripe_cc_owner").val(val);
        //alert(jQuery("#cryozonic_stripe_cc_owner").val());
    });
    append = 0;
    jQuery('.addcart-float-buttons-block-add').click(function(){
        setTimeout(function(){
            var price = jQuery('.addcart-specs:eq(1)').data('price') || 0;
            append = price;
        },100);
    });
   setTimeout(function(){
        jQuery('.criteo_header,.criteo_footer,.criteo_body,.criteo_content,.criteo_foot').attr('style','display:none');
   },500);
   var param = getQueryParam();  
   jQuery('input').keydown(function(e){      
    if(e.keyCode ==13)
    {            
        e.stopPropagation();
        e.preventDefault();
        return false;
    }
   });        
   jQuery('span').click(function(event) {
        var data_price = jQuery(this).data('price') || '';
        if(data_price!='')
        {
            getFinalPrice();
        }
   });
   var $a = jQuery('a');              
  jQuery.each($a,function(){
    var ignore = {
        '#' : "",'#0' : "",'javascript:;':"",
        'javascript:void();':"",'':"",
        'javascript:void(0);':""
    }; 
    var href = jQuery(this).attr('href') || '';      
    if(from=='native') return;
    if(href in ignore) return;

    if(href.indexOf('?')!='-1')
    {
        if(param != '') href += '&' + param;
    }   
    else
    {        
        if(param != '') href += "?" + param;
    }  
    jQuery(this).attr('href', href);                
  });
   
});