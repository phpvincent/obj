@extends('worker.father.static')
<style>
body .layim-chat-main{height: auto;}
</style>
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/layuiadmin/layui/css/layui.css">
<div class="layim-chat-main">
  <ul id="LAY_view"></ul>
</div>

<div id="LAY_page" style="margin: 0 10px;">
	<div id="page"></div>
</div>


<textarea title="消息模版" id="LAY_tpl" style="display:none;">
@{{# layui.each(d.data, function(index, item){ }}

  @{{# if(!isNaN(item.talk_msg_from_id)){  }}
    <li class="layim-chat-mine"><div class="layim-chat-user"><img src="@{{ item.avatar }}"><cite><i>@{{ layui.data.date(item.timestamp) }}</i>@{{ item.username }}</cite></div>
    	<div class="layim-chat-text">@{{ layui.layim.content(item.content) }}</div></li>
  @{{# } else { }}
    <li><div class="layim-chat-user"><img src="@{{ item.avatar }}"><cite>@{{ item.username }}<i>@{{ layui.data.date(item.timestamp) }}</i></cite></div><div class="layim-chat-text">@{{ layui.layim.content(item.content) }}</div></li>
  @{{# } }}
 @{{# }); }}
</textarea>
@endsection
@section('js')
<!-- 
上述模版采用了 laytpl 语法，不了解的同学可以去看下文档：http://www.layui.com/doc/modules/laytpl.html

-->


 <!--  <script src="/admin/layuiadmin/layui/layui.js"></script>
  <script src="/admin/layuiadmin/lib/index.js"></script> -->
<!--   <script src="/admin/layuiadmin/layui/layui.js?t=1"></script>  
  <script src="/admin/layuiadmin/lib/admin.js"></script>  
  <script src="/admin/layuiadmin/modules/common.js"></script>   -->
<script>
layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['layim', 'laypage','index','view','admin'], function(){
  var layim = layui.layim
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,$ = layui.jquery
  ,laypage = layui.laypage;
  var idArray = window.location.search.split("&");
	layui.each(idArray,function(index, item){
		if(item.indexOf('admin_id')>-1){
			admin_id=item.split('=');
			admin_id=admin_id[1];
		}
		if(item.indexOf('?id')>-1){
			id=item.split('=');
			id=id[1];
		}
	})	
  console.log(layui.setter.websocket.server)
  console.log('???',parent.layui.layim.cache().mine.id)
  //聊天记录的分页此处不做演示，你可以采用laypage，不了解的同学见文档：http://www.layui.com/doc/modules/laypage.html
  var counts=null;
   $.ajax({
            url: layui.setter.websocket.server+layui.setter.websocket.getTalkMsgCount,
            type:'get',
						data:{admin_id: admin_id,
							 id:id
							},
			async:false,
            datatype:'json',
            success:function(msg){
							var msg = JSON.parse(msg)
							if(msg.status === 0){
								counts=msg.msg;
								
							}else{
								layer.msg('获取失败',{zIndex: layer.zIndex})
								return;
							}
					  	
					  }})
  laypage.render({
    elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
    ,count: counts //数据总数，从服务端得到
    ,limit:10
    ,limits:[10,20,30,40,50]
    ,jump: function(obj, first){
    //obj包含了当前分页的所有参数，比如：
    console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
    console.log(obj.limit); //得到每页显示的条数
    	get_msg(obj.curr,obj.limit);
    //首次不执行
	    if(!first){
	      
	    }
  	}
  });
  function get_msg(curr,limit)
  {
  	var msg_data=null;
	  var param =  location.search //获得URL参数。该窗口url会携带会话id和type，他们是你请求聊天记录的重要凭据
	  var url = layui.setter.websocket.server+layui.setter.websocket.getTalkMsg
	   $.ajax({
	            url: url,
	            type:'get',
							data:{
								 admin_id: admin_id,
								 id:id,
								 page:curr,
								 limit:limit
								},
				async:false,
	            datatype:'json',
	            success:function(msg){
								var msg = JSON.parse(msg)
								if(msg.status === 0){
									msg_data=msg.msg;
								}else{
									layer.msg('获取失败',{zIndex: layer.zIndex})
								}
						  	
						  }})
	  console.log(msg_data);
	  var html = laytpl(LAY_tpl.value).render({
	    data: msg_data
	  });
	  $('#LAY_view').html(html);
  }
  //get_msg();
  //开始请求聊天记录
  
  //实际使用时，下述的res一般是通过Ajax获得，而此处仅仅只是演示数据格式
  res = {
    code: 0
    ,msg: ''
    ,data: [{
      username: '纸飞机'
      ,id: 100000
      ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.512.512.180/8693225ajw8f2rt20ptykj20e80e8weu.jpg'
      ,timestamp: 1480897882000
      ,content: 'face[抱抱] face[心] 你好啊小美女'
    }, {
      username: 'Z_子晴'
      ,id: 108101
      ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.512.512.180/8693225ajw8f2rt20ptykj20e80e8weu.jpg'
      ,timestamp: 1480897892000
      ,content: '你没发错吧？face[微笑]'
    },{
      username: 'Z_子晴'
      ,id: 108101
      ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.512.512.180/8693225ajw8f2rt20ptykj20e80e8weu.jpg'
      ,timestamp: 1480897898000
      ,content: '你是谁呀亲。。我爱的是贤心！我爱的是贤心！我爱的是贤心！重要的事情要说三遍~'
    },{
      username: 'Z_子晴'
      ,id: 108101
      ,avatar: 'http://tva3.sinaimg.cn/crop.0.0.512.512.180/8693225ajw8f2rt20ptykj20e80e8weu.jpg'
      ,timestamp: 1480897908000
      ,content: '注意：这些都是模拟数据，实际使用时，需将其中的模拟接口改为你的项目真实接口。\n该模版文件所在目录（相对于layui.js）：\n/css/modules/layim/html/chatlog.html'
    }]
  }
  
  //console.log(param)
  
  
  
});
</script>
@endsection
