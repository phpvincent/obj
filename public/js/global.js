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
        from = 'native';
        if(get_storage('befrom')) 
        {
            from = get_storage('befrom');
            jQuery('#from').val(get_storage('befrom'));
            return;
        }
        
        if(getCookie('befrom')) 
        {
            from = getCookie('befrom');
            jQuery('#from').val(getCookie('befrom'));
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
    jQuery('#from').val(from);       
    set_storage('befrom', from, 0.5);
    setCookie('befrom', from, 30*60);          
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
        if(!getQueryString('from'))
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
   setTimeout(function(){
        if(jQuery('#payForm').length>0 && from != '')
        {        
            var action = jQuery("#payForm").attr('action');
            if(action.indexOf('?')!='-1')
            {
                action += '&from='+from;
            }   
            else
            {
                action += '?from='+from;
            } 
            jQuery("#payForm").attr('action',action);               
        }  
   },500); 
    var param = getQueryParam();  
    var $a = jQuery('a');             
    jQuery.each($a,function(){
        var ignore = {
            '#' : "",'#0' : "",'javascript:;':"",
            'javascript:void();':"",'':"",
            'javascript:void(0);':"",
            'javascript:void(0)':""
        }; 
        var href = jQuery(this).attr('href') || '';      
      //  if(from=='native') return;        
        if(href in ignore) return; 
        if(href.indexOf('@') != '-1') return;
      
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