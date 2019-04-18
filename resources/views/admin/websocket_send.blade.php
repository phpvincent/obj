<!DOCTYPE html>  
<meta charset="utf-8" />  
<title>WebSocket Test</title> 
<script src="http://52.14.183.239/js/jquery.min.js"></script>
<script src="http://52.14.183.239/layer/layer.js"></script>
<script language="javascript"type="text/javascript">  
    //var wsUri ="ws://echo.websocket.org/";
     var wsUri ="ws://13.250.109.37:2350/";
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
        //doSend("WebSocket rocks"); 
    }  
 
    function onClose(evt) { 
        writeToScreen("关闭ws"); 
    }  
 
    function onMessage(evt) { 
        writeToScreen('<span style="color: blue;">返回数据: '+ evt.data+'</span>'); 
        // websocket.close(); 
    }  
 
    function onError(evt) { 
        writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data); 
    }  
 
    function doSend(message) { 
        writeToScreen("SENT: " + message);  
        websocket.send(JSON.stringify({ip:'192.168.0.0','route':'http://obj.com','ip_info':'{"msg":"info"}'})); 
    }  
 	function doNotice(message) { 
        writeToScreen("SENT: " + message);  
        websocket.send(JSON.stringify(message)); 
    }  
 
    function writeToScreen(message) { 
        var pre = document.createElement("p"); 
        pre.style.wordWrap = "break-word"; 
        pre.innerHTML = message; 
        output.appendChild(pre); 
    }  
 
    window.addEventListener("load", init, false);  
    function sendmsg(){
    	var msg={};
    	var innetmsg=$('#send').val();
    	var ip=$('#sendip').val();
    	if(ip!=null&&ip!=''){
    		msg={type:1,msg:'innetmsg',ip:'ip'};
    		msg.msg=innetmsg;
    		msg.ip=ip;
    		doNotice(msg);
    	}else{
    		msg={type:0,msg:'innetmsg'};
    		msg.msg=innetmsg;
    		doNotice(msg);
    	}
    }
</script>  
<h2>WebSocket Test</h2>  
<div id="output"></div>  
<textarea id="send" name="" placeholder="send msg" style="width: 700px;height: 500;"> </textarea><br>
<input type="text" id="sendip" name="" placeholder="ip msg">
<button onclick="sendmsg()">send message</button>
</html>