<!DOCTYPE html>  
<meta charset="utf-8" />  
<title>WebSocket Test</title>  
<script src="/js/jquery.min.js"></script>
<script language="javascript"type="text/javascript">
    !function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}return function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}(function(){})});
    //var wsUri ="ws://echo.websocket.org/";
    var wsUri ="ws://13.229.73.221:8282/";
    var output;
    var ping;
    function init() { 
        output = document.getElementById("output"); 
        testWebSocket(); 
    }  
 
    function testWebSocket() { 
        websocket = new WebSocket(wsUri); 
        websocket.onopen = function(evt) { 
            onOpen(evt) 
        }; 
        websocket.onclose = function(evt) { 
            onClose(evt) 
        }; 
        websocket.onmessage = function(evt) { 
            onMessage(evt) 
        }; 
        websocket.onerror = function(evt) { 
            onError(evt) 
        }; 
    }  
 
    function onOpen(evt) { 
                    ping = setInterval(function () {
                        websocket.send(JSON.stringify({
                            'user': 'ping',
                            'type': 'send'
                        }));
                    },1000 * 25);
        writeToScreen("第一次打开"); 
        doSend("WebSocket rocks"); 
    }  
 
    function onClose(evt) { 
        clearInterval(ping)
        writeToScreen("关闭ws"); 
    }  
 
    function onMessage(evt) { 

        // writeToScreen('<span style="color: blue;">返回数据: '+ evt.data+'</span>'); 
        console.log('onmessage',evt)
        var data = JSON.parse(evt.data);
        console.log(data);
        if(data.status === 0 && data.touser === "client"){
            if(data.msg.pid !== undefined){
                setCookie('pid',data.msg.pid,1);
                $('#doSend').val(data.msg.pid);
            }
        }
        // doSend("保证，我不是第一次链接")
        // websocket.close(); 
    }  
 
    function onError(evt) { 
        writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data); 
    }  
 
    function doSend(message) { 
        writeToScreen("SENT: " + message);
        // Cookies.set('pp','123',{expires:1,path: '/'});
        Cookies.set('wsdata', '123',  { expires: 1, path: '/' })
        console.log(typeof getCookie('pid'));
        console.log(getCookie('pid') === undefined);
        if(!getCookie('pid') || getCookie('pid') === 'undefined'){
            websocket.send(JSON.stringify({user:'client','url':'http://13.229.73.221/send?goods_id=75','goods_id':75,'type':"firstClient",'country':'CHI'}));
        }else{
           websocket.send(JSON.stringify({user:'client','url':'http://13.229.73.221/send?goods_id=75','pid':getCookie('pid'),'country':'CHI','type':"reClient"}));
        }
        // websocket.send(JSON.stringify({ip:'192.168.10.1','route':'http://13.229.73.221/send?goods_id=75','ip_info':{"msg":"info"}})); 
        // websocket.send(JSON.stringify({'user':'admin','admin_name':'xiaocui','admin_password':'123456','type':"auth",'language':'CHI'})); 
    }  
 
    function writeToScreen(message) { 
        var pre = document.createElement("p"); 
        pre.style.wordWrap = "break-word"; 
        pre.innerHTML = message; 
        output.appendChild(pre); 
    } 


    function func(){
        console.log(getCookie('pid'));
        if(getCookie('pid') || getCookie('pid') !== 'undefined'){
            websocket.send(JSON.stringify({'pid':getCookie('pid'),'msg':$('#fname').val(),'user':'client','type':'clientSend','country':'CHI'})); 
        }else{
             writeToScreen("未登陆"); 
        }
        // websocket.send(JSON.stringify({'touser':'1','msg':$('#fname').val(),'user':'admin'})); 
    }

    //写cookies 
    function setCookie(cname,cvalue,exdays)
    {
        console.log(3333);
        var d = new Date();
      d.setTime(d.getTime()+(exdays*24*60*60*1000));
      var expires = "expires="+d.toGMTString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
    } 

    //读取cookies 
    function getCookie(cname)
    {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i=0; i<ca.length; i++) 
      {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
      }
      return "";
    }

    //删除cookies 
    function delCookie(name) 
    { 
        var exp = new Date(); 
        exp.setTime(exp.getTime() - 1); 
        var cval=getCookie(name); 
        if(cval!=null) 
            document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
    } 
 
    window.addEventListener("load", init, false);  
</script> 
<body>
    <h2>WebSocket Test</h2>  
    <div id="output"></div> 
    <form action="form_action.asp" method="get">
        <p>First name: <input id="fname" type="text" name="fname" /></p>
        <input type="text" id="doSend" name="" value="">
        <input type="button" id="button-submit" onclick="func()" value="Submit" />
    </form> 
</body> 
</html>