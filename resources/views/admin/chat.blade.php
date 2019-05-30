<!DOCTYPE html>
<html>
<head>
<meta name="viewport"   content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>chat</title>
    <style>
    .layui-layer.layui-layer-page.layui-box.layui-layim-chat{
        width: 100%!important;
    left: 0!important;
    min-width: 0px!important;
    }
    </style>
</head>
<body>
  <link rel="stylesheet" href="{{asset('/admin/layuiadmin/layui/css/layui.css')}}" media="all">
  <link rel="stylesheet" href="{{asset('/admin/layuiadmin/style/admin.css')}}" media="all">
  <!-- <link rel="stylesheet" href="{{asset('/admin/layuiadmin/layui/css/layui.mobile.css')}}" media="all"> -->
  <script src="{{asset('/admin/layuiadmin/layui/layui.js')}}"></script>
  <script type="text/javascript">
  	layui.use('layim', function(layim){
// var mobile = layui.mobile,
// layim=mobile.layim;
  		layim.config({
  			init:{
  				'mine':{
  					 "username": "visiter" //我的昵称
				      ,"status": "online" //在线状态 online：在线、hide：隐身
				      ,"avatar": "http://13.229.73.221/images/online.gif" //我的头像
  				}
  			}
  			,brief:true
  			,uploadImage: {
		      url:'http://13.229.73.221:7273?type=img_upload' //接口地址
		      ,type: 'post' //默认post
		    }
		    ,uploadFile: {
		      url: 'http://13.229.73.221:7273?type=file_upload' //接口地址
		      ,type: 'post' //默认post
		    }
          }).chat({
		  name: 'Customer service' //名称
		  ,type: 'kefu' //聊天类型
		  ,avatar: 'http://13.229.73.221/images/online.gif' //头像
		  ,id: 1 //好友id
		})
		 var goods_id=0;
         var idArray = window.location.search.split("&");
			layui.each(idArray,function(index, item){
				if(item.indexOf('goods_id')>-1){
					goods_id=item.split('=');
					goods_id=goods_id[1];
				}
			})	
		 function getCookie(Name) {
		   var search = Name + "="//查询检索的值
		   var returnvalue = "";//返回值
		   if (document.cookie.length > 0) {
		     sd = document.cookie.indexOf(search);
		     if (sd!= -1) {
		        sd += search.length;
		        end = document.cookie.indexOf(";", sd);
		        if (end == -1)
		         end = document.cookie.length;
		         //unescape() 函数可对通过 escape() 编码的字符串进行解码。
		        returnvalue=unescape(document.cookie.substring(sd, end))
		      }
		   } 
		   return returnvalue;
		}
		 function setCookie(cname,cvalue,exdays)
	    {
	        console.log(3333);
	        var d = new Date();
	      d.setTime(d.getTime()+(exdays*24*60*60*1000));
	      var expires = "expires="+d.toGMTString();
	      document.cookie = cname + "=" + cvalue + "; " + expires;
	    } 
	    function delCookie(name) 
	    { 
	        var exp = new Date(); 
	        exp.setTime(exp.getTime() - 1); 
	        var cval=getCookie(name); 
	        if(cval!=null) 
	            document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
	    } 
		setTimeout(function () {
                //var socket = new WebSocket('ws://192.168.10.166:8282');
                var socket = new WebSocket('ws://13.229.73.221:8282');

                //发送一个消息
                // socket.send('Hi Server, I am LayIM!');

                //更多情况下，一般是传递一个JSON
                // socket.send(JSON.stringify({
                //   type: '' //随便定义，用于在服务端区分消息类型
                //   ,data: {}
                // }));

                //连接成功时触发
                socket.onopen = function(){
                    ping = setInterval(function () {
                        socket.send(JSON.stringify({
                            'user': 'ping',
                            'type': 'send'
                        }));
                    },1000 * 25);
                    var user_id=getCookie('user_id');
                   
                    if(user_id==""){
                    	socket.send(JSON.stringify({'type':"firstClient",'goods_id':goods_id,'user':'client'}));
                    }else{
                    	socket.send(JSON.stringify({'type':"reClient",'pid':user_id,'goods_id':goods_id,'user':'client'}));
                    }
                    // socket.send('XXX连接成功');
                    // socket.send(JSON.stringify({'user':'admin','admin_name':'root','admin_password':'123456','type':"auth",'language':'CHI'}));

                    //   var data = {
                    //       avatar: null,
                    //       cid: 0,
                    //       content: "来了，大哥",
                    //       fromid: 1,
                    //       id: 1,
                    //       mine: true,
                    //       timestamp: 1559024978000,
                    //       type: "friend",
                    //       username: "admin",
                    // };
                    // layim.getMessage(data);


                };

                //监听收到的消息
                socket.onmessage = function(res){
                    var data = JSON.parse(res.data);
                    if(data.msg.type=='connet_success'){
                    	window.client_id=data.msg.client_id;
                    	window.country=data.msg.country;
                    	window.ip=data.msg.ip;
                    	window.time=data.msg.time;
                    }else if(data.msg.type=='first_client'){
                    	setCookie('user_id',data.msg.pid,30);
                    }else if(data.msg.type=='friend'){
						layim.getMessage(data.msg);                    	
                    }
                    return;
                    /*if(data.msg.sendUser != "auth" && data.msg.sendUser != undefined){
                        if(data.msg.sendUser == "new_user"){
                            var addUser = {
                                type: 'friend' //列表类型，只支持friend和group两种
                                ,avatar: data.msg.avatar //好友头像
                                ,username: data.msg.username //好友昵称
                                ,groupid: 1 //所在的分组id
                                ,id: data.msg.id //好友id
                                ,sign: "本人冲田杏梨将结束AV女优的工作" //好友签名
                            };
                            if(layim.addList(addUser)){
                                delete data.msg.sendUser;

                                layim.getMessage(data.msg);
                            };
                        }else{
                            delete data.msg.sendUser;

                            layim.getMessage(data.msg);
                        }
                    }*/
                };
                socket.onclose = function(){
                    console.log("websocket is closed");
                    clearInterval(ping)
                };
                layim.on('sendMessage', function(res){
                    var mine = res.mine; //包含我发送的消息及我的信息
                    var to = res.to; //对方的信息
                    console.log(res);
                    var pid=getCookie('user_id');
                    if(pid==""||pid==null){
                    	return;
                    }
                    //监听到上述消息后，就可以轻松地发送socket了，如：
                    socket.send(JSON.stringify({
                        pid: pid
                        ,msg: res.mine.content
                        ,type: 'clientSend'
                        ,user:'client'
                    }));

                });
            },150);  
  	})
  </script>
</body>
</html>