@extends('worker.father.static')
@section('content')
 <body>
 	<div id="user_info" style="display: none;">
 		
 	</div>
 </body>
@endsection
@section('js')
  <script>
  layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','form','laydate','layim'],function(){
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
	      url: '' //接口地址
	      ,type: 'post' //默认post
	    } 
	    
	    //上传文件接口（返回的数据格式见下文），若不开启文件上传，剔除该项即可
	    ,uploadFile: {
	      url: '' //接口地址
	      ,type: 'post' //默认post
	    }
	    //扩展工具栏，下文会做进一步介绍（如果无需扩展，剔除该项即可）
	    ,tool: [{
	      alias: 'code' //工具别名
	      ,title: '代码' //工具名称
	      ,icon: '&#xe64e;' //工具图标，参考图标文档
	    }]
	    
	    ,msgbox: layui.cache.dir + 'css/modules/layim/html/msgbox.html' //消息盒子页面地址，若不开启，剔除该项即可
	    ,find: layui.cache.dir + 'css/modules/layim/html/find.html' //发现页面地址，若不开启，剔除该项即可
	    ,chatLog: layui.cache.dir + 'css/modules/layim/html/chatlog.html' //聊天记录页面地址，若不开启，剔除该项即可
	  });
  	 layim.on('tool(code)', function(insert, send, obj){ //事件中的tool为固定字符，而code则为过滤器，对应的是工具别名（alias）
  	 	$('#user_info').show();
  	 	 layer.open({
	        type: 1 //此处以iframe举例
	        ,title: '个人信息'
	        ,area: ['800px', '600px']
	        ,maxmin: true
	        ,content: '<div id="user_info"></div>'
	        ,zIndex: layer.zIndex //重点1
	        ,offset: '60px'
	        ,end:function(){
	        	$('#user_info'),hide();
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
  });
  </script>
</body>
</html>
@endsection