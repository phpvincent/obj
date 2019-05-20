<!DOCTYPE html>  
<meta charset="utf-8" />  
<title>WebSocket Test</title>  
<script src="/js/jquery.min.js"></script>
<script src="/layer/layer.js"></script>
<script language="javascript"type="text/javascript">  
    //var wsUri ="ws://echo.websocket.org/";
     var wsUri ="ws://192.168.10.166:8282/";
     var pid =false;
    var output;  
    
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
            alert('goodbye');
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
        writeToScreen("第一次打开"); 
        doSend("WebSocket rocks"); 
    }  
 
    function onClose(evt) { 
        writeToScreen("关闭ws"); 
    }  
 
    function onMessage(evt) { 
        writeToScreen('<span style="color: blue;">返回数据: '+ evt.data+'</span>'); 
        //console.log('onmessage',evt)
        var obj = eval("(" + evt.data + ")");
        //console.log(obj.msg.pid);
        if(obj.msg.pid!=false&&obj.msg.pid!=undefined ){
            pid=obj.msg.pid;console.log(pid)
        }
        // websocket.close(); 
    }  
 
    function onError(evt) { 
        writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data); 
    }  
 
    function doSend(message) { 
        writeToScreen("SENT: " + message);  
        websocket.send(JSON.stringify({ip:'192.168.0.0','route':'http://obj.com','ip_info':'{"msg":"info"}',user:'client',type:'firstClient'})); 
    }  
    function sendMessage(message) { 
        writeToScreen("SENTMSG: " + message);  
        console.log(pid);
        if(pid!=false){
            websocket.send(JSON.stringify({ip:'192.168.0.0','route':'http://obj.com','ip_info':'{"msg":'+message+'}',user:'client',pid:pid,'type':'clientSend'})); 
        }else{
            websocket.send(JSON.stringify({ip:'192.168.0.0','route':'http://obj.com','ip_info':'{"msg":'+message+'}',user:'client','type':'clientSend'})); 
        }
    }  
    function writeToScreen(message) { 
         // var pre = document.createElement("p"); 
        // pre.style.wordWrap = "break-word"; 
        // pre.innerHTML = message; 
        // output.appendChild(pre); 
        $('#output').append('<p>'+message+'</p>')
    }  
 
    window.addEventListener("load", init, false);  
</script>  
<h2>WebSocket Test</h2>  
<div id="output"></div>  
<input type="text" name="ok" id="test"> <button onclick="sendMessage($('#test').val())">send</button>
</html>