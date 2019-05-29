@extends('worker.father.static')
@section('content')
 <body> 
 	<!-- <div id="user_info" style="display: none;">
 		
		 </div> -->
 </body>
@endsection
@section('js')
  <script>
  layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form','laydate','layim', 'layer'],function(){
  	 var layim=layui.layim
  	 var $=layui.jquery
  	 var admin_id="{{Auth::user()->admin_id}}"
  	 console.log(layui.setter.websocket.server+layui.setter.websocket.getGroupUsers);
  	 layim.config({
    	 init: {
    	 	 url: layui.setter.websocket.server+layui.setter.websocket.init_url+"&admin_id="+admin_id //接口地址（返回的数据格式见下文）
		     ,type: 'get' //默认get，一般可不填
		     ,data: {} //额外参数
    	 } //获取主面板列表信息，下文会做进一步介绍
	 	,title:'Customer service center'
	 	,min:false
	 	,brief:false
	 	,initSkin: '1.jpg'
	 	,isAudio:true
	 	,isVideo:true
	 	,notice:true
	 	,voice:'default.mp3'
	 	,isfriend:true
	 	,isgroup:true
	 	,maxLength:3000
	 	,skin: [ 
		  'http://52.14.183.239/images/ydzs.jpg', 
		  'http://52.14.183.239/images/ydzs.jpg'
		]   
		,copyright:true
	    //获取群员接口（返回的数据格式见下文）
	    ,members: {
		  url: layui.setter.websocket.server+layui.setter.websocket.getGroupUsers+"&admin_id="+admin_id
		  ,data: {}
		}   
	    ,tool: [{
		    alias: 'code' //工具别名
		    ,title: '详细信息' //工具名称
		    ,icon: '&#xe64e;' //工具图标，参考图标文档
		  }] 
	    //上传图片接口（返回的数据格式见下文），若不开启图片上传，剔除该项即可
	    ,uploadImage: {
	      url: layui.setter.websocket.server+layui.setter.websocket.img_upload //接口地址
	      ,type: 'post' //默认post
	    } 
	    
	    //上传文件接口（返回的数据格式见下文），若不开启文件上传，剔除该项即可
	    ,uploadFile: {
	      url: layui.setter.websocket.server+layui.setter.websocket.file_upload //接口地址
	      ,type: 'post' //默认post
	    }
	    //扩展工具栏，下文会做进一步介绍（如果无需扩展，剔除该项即可）
	    ,tool: [{
	      alias: 'code' //工具别名
	      ,title: '客户资料' //工具名称
	      ,icon: '&#xe62a;' //工具图标，参考图标文档
	    }]
	    
	    ,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
	    ,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
	    ,chatLog: '{{url('/admin/worker/talk/msg_log')}}?admin_id='+admin_id+'&' //聊天记录页面地址，若不开启，剔除该项即可
	    //,chatLog: layui.cache.dir + 'css/modules/layim/html/chatLog.html' //聊天记录页面地址，若不开启，剔除该项即可
	  });
  	 layim.on('tool(code)', function(insert, send, obj){ //事件中的tool为固定字符，而code则为过滤器，对应的是工具别名（alias）
			// $('#user_info').show();
				$.ajax({
          url: layui.setter.websocket.server+layui.setter.websocket.getUserInfo,
          type:'post',
          data:{pid: obj.data.id, admin_id: admin_id},
          datatype:'json',
          success:function(msg){
						// console.log(msg)
						var msg = JSON.parse(msg)
            if(typeof msg.msg === 'object'){
						var indexop =	layer.open({
	          type: 1 //此处以iframe举例
	          ,title: '个人信息'
	          ,area: ['800px', '600px']
	          ,maxmin: true
						,content: '<div id="user_info">'
						  +'<table class="layui-table">'
              +'<thead>'
                +'<tr>'
                  +'<th>商品ID</th>'
									+'<th>地区</th>'
									+'<th>是否购物</th>'
									+'<th>是否在线</th>'
									+'<th>语言</th>'
									+'<th>最后一次登录时间</th>'
									+'<th>初次访问时间</th>'
									+'<th>姓名</th>'
									+'<th>电话</th>'
									+'<th>email</th>'
									+'<th>操作</th>'
									+'</tr>'
									+'</thead>'
									+'<tbody>'
									+'<tr>'
									+'<td>'+msg.msg.talk_user_goods+'</td>'
									+'<td>'+msg.msg.talk_user_country+'</td>'
									+'<td>'+(msg.msg.talk_user_is_shop ==='0' ? '是':'否')+'</td>'
									+'<td>'+(msg.msg.talk_user_status ==='0' ? '是':'否')+'</td>'
									+'<td>'+msg.msg.talk_user_lan+'</td>'
									+'<td>'+msg.msg.talk_user_last_time+'</td>'
									+'<td>'+msg.msg.talk_user_time+'</td>'
									+'<td><input id="talk_user_name" class="layui-input" value="'+(msg.msg.talk_user_name||'')+'"></td>'
									+'<td><input id="talk_user_phone" class="layui-input" value="'+(msg.msg.talk_user_phone||'')+'"></td>'
									+'<td><input id="talk_user_email" class="layui-input" value="'+(msg.msg.talk_user_email||'')+'"></td>'
									+'<td rowspan="3"><a class="layui-btn layui-btn-xs" id="talkedit">确定修改</a></td>'
									+'</tr>'
									+'<tr style="background-color: #f2f2f2;">'
									+'<th colspan="10" style="text-align: center;">备注</th>'
									+'</tr>'
									+'<tr>'
									+'<td colspan="10"><textarea id="talk_user_remark" style="width: 100%;">'+(msg.msg.talk_user_remark||'')+'</textarea></td>'
									+'</tr>'
									+'</tbody>'
									+'</table>'
						+'</div>'
	          ,zIndex: layer.zIndex //重点1
	          ,offset: '60px'
	          ,end:function(){
	          	// $('#user_info'),hide();
	          }
			  ,success: function(layero, index){
              //  console.log(layero, index);
				$(layero).on('click','#talkedit', function(){

                $.ajax({
                url: layui.setter.websocket.server+layui.setter.websocket.upUserInfo,
                type:'post',
                data:{pid: obj.data.id,
                	 admin_id: admin_id,
                	 talk_user_name: $('#talk_user_name').val(),
                	 talk_user_phone: $('#talk_user_phone').val(),
                	 talk_user_email: $('#talk_user_email').val(),
									 talk_user_remark: $('#talk_user_remark').val(),
                	},
                datatype:'json',
                success:function(msg){
                	var msg = JSON.parse(msg)
                	if(msg.status === 1){
                		layer.msg('修改成功',{zIndex: layer.zIndex})
                		layer.close(indexop)
                	}else{
                		layer.msg('修改失败',{zIndex: layer.zIndex})
                	}
                	
                }})
                
              })
            }
					});
					}else(
							layer.msg('数据错误',{zIndex: layer.zIndex})
					)
          }
        });
	  	 /*layer.prompt({
		    title: '个人信息'
		    ,formType: 2
		    ,shade: 0
		  }, function(text, index){
		    layer.close(index);
		    insert('[pre class=layui-code]' + text + '[/pre]'); //将内容插入到编辑器，主要由insert完成
		    //send(); //自动发送
		  });*/
		
		
		  console.log(this); //获取当前工具的DOM对象
			console.log(obj); //获得当前会话窗口的DOM对象、基础信息
	}); 
	  layim.on('sign', function(value){
			  $.ajax({
            url: layui.setter.websocket.server+layui.setter.websocket.upAdminInfo,
            type:'post',
						data:{admin_id: admin_id,
							 admin_talk_sign:value
							},
            datatype:'json',
            success:function(msg){
							var msg = JSON.parse(msg)
							if(msg.status === 1){
								layer.msg('修改成功',{zIndex: layer.zIndex})
								layer.close(indexop)
							}else{
								layer.msg('修改失败',{zIndex: layer.zIndex})
							}
					  	
					  }})
			});  
	   var admin_info = {!! \App\admin::where('admin_id',\Auth::user()->admin_id)->first() !!};
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
                    socket.send(JSON.stringify({'user':'admin','admin_name': admin_info.admin_name,'admin_password': admin_info.password,'type':"auth",'language': admin_info.languages}));
                };
                //监听收到的消息
  				socket.onmessage = function(res){
                    var data = JSON.parse(res.data);
                    switch (data.msg.type) {
						case 'status':
                            layim.setFriendStatus(data.msg.uid, data.msg.status);
                            break;
						case 'auth':
                            break;
						case 'add':
							data.msg.type = 'friend';
							console.log(data.msg);
                            layim.addList(data.msg);
						    break;
						case 'friend':
                                layim.getMessage(data.msg);
                            break;
						default:
						    break;
                    }
                };
                
                /*socket.onmessage = function(res){
                    var data = JSON.parse(res.data);
                    if(data.msg.sendUser != "auth" && data.msg.sendUser != undefined){
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
                    }
                };*/
                socket.onclose = function(){
                    console.log("websocket is closed");
                    clearInterval(ping)
                };
                layim.on('sendMessage', function(res){
                    var mine = res.mine; //包含我发送的消息及我的信息
                    var to = res.to; //对方的信息
                    console.log(res);
                    //监听到上述消息后，就可以轻松地发送socket了，如：
                    socket.send(JSON.stringify({
                        user: 'admin'
                        ,touser: to.id
                        ,pid: mine.id
                        ,msg: res
                        ,account: 123456
                        ,type: 'send'
                    }));

                });
            },150);  
  });
  </script>
</body>
</html>
@endsection