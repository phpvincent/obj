@extends('storage.father.static')
@section('content')
<!-- 时间线的样式 -->
<style type="text/css">
object,embed{
    -webkit-animation-duration:.001s;-webkit-animation-name:playerInserted;               
     -ms-animation-duration:.001s;-ms-animation-name:playerInserted;               
      -o-animation-duration:.001s;-o-animation-name:playerInserted;               
       animation-duration:.001s;animation-name:playerInserted;
}               
@-webkit-keyframes playerInserted{
     from{opacity:0.99;}to{opacity:1;}
     }               
@-ms-keyframes playerInserted{
    from{opacity:0.99;}to{opacity:1;}
          }               
@-o-keyframes playerInserted{
    from{opacity:0.99;}to{opacity:1;}
    }                
@keyframes playerInserted{
    from{opacity:0.99;}to{opacity:1;}
    }

/* CSS 定制的公共样式 */
 div, h1, ul, li {margin: 0;padding: 0;}
h1 { font-weight:normal; font-size:12px;}
ul,dl{ list-style-type:none;}
li{vertical-align:top;}
.clear{ clear:both; margin:0; padding:0; font-size:0px; line-height:0px; height:0px; overflow:hidden;} 
.clearfix:after {content:".";display:block;height:0;clear:both;visibility:hidden;}
*html .clearfix {zoom:1;}
*+html .clearfix {zoom:1;}
img{ border:none; vertical-align:top;}
/* CSS 活动的公共样式 */
.course_nr li:hover {cursor:pointer;}
.course{ height:145px; background:#FFF;}
.course_nr{height:55px; background:url(/images/ico9.gif) repeat-x center;}
.course_nr li{ float:left; background:url(/images/ico10.gif) no-repeat center top; padding-top:30px; width:100px; text-align:center; position:relative; margin-top:10px;}
.shiji{ position:absolute; width:100%; left:0; top:-19px; display:none;}
.shiji h1{ height:67px; line-height:67px; color:#518dbb; font-weight:bold; background:url(/images/ico11.gif) no-repeat center top; margin-bottom:8px;}
.shiji p{ line-height:14px; color:#999;}



.details span{
  padding-left:16px;
  font-weight: 700;
}
span:first-child
{
  padding-left:0
}
#put_ul li{
  
  position: relative;
}
#put_ul li blockquote:hover{
  cursor: pointer;
    border: 1px solid #1e9fff;
}
.ft-l{
  float: left;
}
.ft-r{
  float: right;
  border-right: 5px solid #e6e6e6;
  border-left: 1px solid #e6e6e6;
}
.red{
  border: 2px solid red;
}
.ft-l-blue{
  border-right: 5px solid #372fad;
  -moz-box-shadow:2px 2px 5px #333333;
   -webkit-box-shadow:2px 2px 5px #333333;
     box-shadow:2px 2px 5px #333333;
  background-color:#e5eed9;
  border-radius: 20px 0 20px 0;;
}
.ft-l-green{
  border-right: 5px solid #0ca036;
  border-radius: 0 20px 0 20px;
  background-color:#efba72
}
.ft-l-green img{
  width: 200px;
    height: 200px;
}
.layui-layer.layui-layer-tips{
  top:0!important;
}
.layui-layer-tips .layui-layer-content {
    min-width: 84px!important;
}
</style>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
             
            </div>
          </div>


          
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-card-header">监控台<h2 style="line-height: 40px;margin-left: 20px;    float: right;" id="collect_status_h2"><span style="color:red;font-size: 10px;">Status:<img id="collect_status" style="width: 80px;height: 45px;border-radius:35px;" src="/images/close.png">断开连接...</span></h2> </div>  
              <form class="layui-form" action="">
                <div class="layui-form-item">
                  <div class="layui-inline">
                    <label class="layui-form-label">商品名筛选</label>
                    <div class="layui-input-inline">
                      <select name="modules"  lay-search="">
                        <option value="">直接选择或搜索选择</option>
                      </select>
                    </div>
                  </div>
                  <div class="layui-inline">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-inline">
                      <select name="type" lay-verify="required">
                        <option value="0">选择类型</option>
                        <option value="notice">路由访问</option>
                        <option value="data">数据捉取</option>
                        <option value="event">事件监听</option>
                      </select>
                    </div>
                  </div>
                  <div class="layui-inline">
                    <label class="layui-form-label">ip</label>
                    <div class="layui-input-inline">
                    <input type="text" name="ip"  lay-verify="required" placeholder="请输入ip" autocomplete="off" class="layui-input">
                    </div>
                  </div>
                </div>
              </form>
              
              <hr> 
              <div class="layui-card-body">
                <li style="display: none;" id="console_board_li"><button class="layui-btn layui-btn-radius layui-btn-primary" id="console_board" ></button></li>
             <ul id="put_ul">
                 <li>
                    
                 </li>
             </ul>
            <div id="output"></div>  
              </div>
            </div>
            
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">个人信息</div>
          <div class="layui-card-body layui-text">
            <table class="layui-table">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>登陆次数</td>
                  <td>
                    <script type="text/html" template>
                     {{\Auth::user()->admin_num}}
                    </script>
                  </td>
                </tr>
                <tr>
                  <td>上次登陆时间</td>
                  <td>
                    <script type="text/html" template>
                     {{\Auth::user()->admin_time}}
                    </script>
                 </td>
                </tr>
                <tr>
                  <td>账户角色</td>
                  <td>@if(Auth::user()->is_root==1)
                    <li>超级管理员</li>
                    @else
                    {{App\role::where('role_id',Auth::user()->admin_role_id)->first()->role_name}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>辅助工具</td>
                  <td style="padding-bottom: 0;">
                    <div class="layui-btn-container">
                      <a lay-href="{{url('admin/message/send_phone')}}" target="_blank" class="layui-btn layui-btn-danger">发送短信</a>
                      <a lay-href="{{url('admin/message/send_mail')}}" target="_blank" class="layui-btn">发送邮件</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {{--用户访问时长--}}
        <div class="layui-card">
            <div class="layui-card-header">访问记录</div>
            <div class="layui-form-item" style="margin-top: 20px">
                <label class="layui-form-label">商品名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="goods_name" placeholder="请输入" id="goods_name" autocomplete="off" class="layui-input">
                </div>
                <button class="layui-btn search_goods_name">搜索</button>
            </div>
            <div class="layui-card-body layui-text goods_search">

            </div>
      </div>
      </div>
      
    </div>
  </div>

@endsection
@section('js')
<!-- <script id="suntable" type="text/html">
  <fieldset class="layui-elem-field">
    <div class="layui-tab-item layui-show">
      <div class="layui-field-box">
          <blockquote class="layui-elem-quote">操作:@{{d.msg.msg}}</blockquote>
          <blockquote class="layui-elem-quote">i p:@{{d.msg.ip}}</blockquote>
          <blockquote class="layui-elem-quote">时间:@{{d.msg.time}}</blockquote>
          <blockquote class="layui-elem-quote">路由:@{{d.msg.route}}</blockquote>
          <blockquote class="layui-elem-quote">邮箱:@{{d.msg.ip_msg.email}}</blockquote>
          <blockquote class="layui-elem-quote">手机号:@{{d.msg.ip_msg.telephone}}</blockquote>
      </div>
    </div>
  </fieldset>
</script> -->
<script id="suntable" type="text/html">
  <fieldset class="layui-elem-field">
    <div class="layui-tab-item layui-show">
        @{{# if (d.ip_event.tpye== 'detial') { }}
            <div class="layui-field-box">
                <blockquote class="layui-elem-quote">操作:查看用户须知</blockquote>
                <blockquote class="layui-elem-quote">i p:@{{d.ip}}</blockquote>
                <blockquote class="layui-elem-quote">停留时间:@{{d.ip_event.countTime}}</blockquote>
                <blockquote class="layui-elem-quote">路由:@{{d.ip_event.router}}</blockquote>
            </div>
          @{{# } else if(d.ip_event.tpye== 'comment') { }}
            <div class="layui-field-box">
              <blockquote class="layui-elem-quote">操作:查看评论区</blockquote>
              <blockquote class="layui-elem-quote">i p:@{{d.ip}}</blockquote>
              <blockquote class="layui-elem-quote">停留时间:@{{d.ip_event.countTime}}</blockquote>
              <blockquote class="layui-elem-quote">路由:@{{d.ip_event.router}}</blockquote>
            </div>
          @{{# } else if(d.ip_event.tpye== 'mqcImgClick') { }}
            <div class="layui-field-box">
              <blockquote class="layui-elem-quote">操作:图片被点击</blockquote>
              <blockquote class="layui-elem-quote">i p:@{{d.ip}}</blockquote>
              <blockquote class="layui-elem-quote">评论ID:@{{d.ip_event.com_id}}</blockquote>
              <blockquote class="layui-elem-quote">路由:@{{d.ip_event.router}}</blockquote>
              <div class="layui-block details">
              <span>图片: </span><img src="@{{d.ip_event.value}}" alt="">
            </div>
          @{{# } else if(d.ip_event.tpye== 'mqcClick') { }}
            <div class="layui-field-box">
              <blockquote class="layui-elem-quote">操作:评论区被点击</blockquote>
              <blockquote class="layui-elem-quote">i p:@{{d.ip}}</blockquote>
              <blockquote class="layui-elem-quote">评论ID:@{{d.ip_event.com_id}}</blockquote>
              <blockquote class="layui-elem-quote">路由:@{{d.ip_event.router}}</blockquote>
              <blockquote class="layui-elem-quote">评论内容:@{{d.ip_event.value}}</blockquote>
            </div>
          @{{# } else if(d.ip_event.tpye== 1) { }}
            <div class="layui-field-box">
              <blockquote class="layui-elem-quote">操作:@{{d.msg}}</blockquote>
              <blockquote class="layui-elem-quote">i p:@{{d.ip}}</blockquote>
              <blockquote class="layui-elem-quote">电话:@{{d.ip_msg.telephone}}</blockquote>
              <blockquote class="layui-elem-quote">邮箱:@{{d.ip_msg.email}}</blockquote>
              <blockquote class="layui-elem-quote">路由:@{{d.route}}</blockquote>
            </div>
          @{{# } }}
    </div>
  </fieldset>
</script>
<script id="suntable_1" type="text/html">
<div class="layui-field-box">
                <form class="layui-form layui-form-pane " method="post" lay-filter="" action="">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">接收IP</label>
                        <div class="layui-input-inline">
                            <input type="text" name="receive_ip" value="@{{d.ip}}" disabled class="layui-input receive_ip">
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">推送内容</label>
                        <div class="layui-input-block">
                            <textarea name="remarks" placeholder="请输入内容" class="layui-textarea receive_content"></textarea>
                        </div>
                        <div style="color: red;margin-top: 10px"><span style="font-weight: bold">注: </span>推送内容最多40个汉字或120个英文字符</div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn send_button" onclick="func()" type="button">确认发送</button>
                        </div>
                    </div>
                </form>
</div>
</script>
  <script>
  layui.config({
    base: '/admin/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console', 'layer', 'laytpl', 'table','form'], function() {
    var $ =layui.jquery;
    var layer = layui.layer;
    var laytpl = layui.laytpl;
    var table=layui.table;
    var form=layui.form;
    $.ajax({
      url:"/admin/goods/api_goods",
      type:'get',
      success:function(msg){
        var str='';
        $.each(msg.data,function(index,val){
          str+= '<option value="'+val.goods_id+'">'+val.goods_real_name+'</option>'
        });
        $('select[name="modules"]').append(str);
        form.render();
      }
    }) 
// 表单提交 推送普通消息
window.func=function () {
         var  message_info = $('.receive_content').val();
         if(message_info.length > 120){
             layer.msg("发送内容最多40个汉字或120个英文字符",{
                 time: 2000 //2秒关闭（如果不配置，默认是3秒）
                 ,offset: '180'
                 ,anim: 6
                 ,zIndex: layer.zIndex+10
             });
             return;
         }
         $.ajax({
             url:'/admin/worker/monitor/push_message',
             type:'post',
             data:{
                 ip: $('.receive_ip').val(),
                 type: 0,
                 msg: $('.receive_content').val()
             },
             headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
             success:function(msg){
                if(msg.err === 1){
                    layer.msg(msg.str,{
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        ,offset: '180'
                        ,anim: 6
                        ,zIndex: layer.zIndex+10
                    },function () {
                        $('.receive_content').val(null);
                    });
                }else{
                    layer.msg(msg.str,{
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        ,offset: '180'
                        ,anim: 6
                        ,zIndex: layer.zIndex+10
                    });
                }
             }
         });
       };
    $('body').on('click','.put_ul_click',function(){
      var msg = JSON.parse($(this).attr('data-msg')).msg
      if(JSON.parse($(this).attr('data-msg')).type==2){
        var msg_1=JSON.parse(msg)
        msg_1.ip_event = {'tpye':1}
        // msg=JSON.stringify(JSON.parse(msg).ip_event={'type':1})
        msg = JSON.stringify(msg_1)
      }
      var that = $(this)
      var str = '<div class="layui-field-box" data-msg=\''+msg+'\'>'+
                  '<p class="details_1"style="cursor: pointer;">查看详情</p>'+
                  '<p class="details_2"style="cursor: pointer;">消息推送</p>'+
                  '<p style="cursor: pointer;">查看详情</p>'+
                '</div>'
      layer.tips(str,that,{tips:[2,'#333'],time:0,area: 'auto',maxWidth:500,offset: 'rt',anim: 1,success: function(layero, index){that.parent().parent().append(layero)}});
      // layer.open({
      //   type: 1 //此处以iframe举例
      //   ,title: '访问详情'
      //   ,area: ['800px', '600px']
      //   ,maxmin: true
      //   ,content: '<div id="details"></div>'
      //   ,zIndex: layer.zIndex //重点1
      //   ,offset: '60px'
      // });
      // var getTpl = suntable.innerHTML;
      // laytpl(getTpl).render(msg, function(html){
      //   $('#details').html(html)
      // });
      $('.put_ul_click').removeClass('red');
      $(this).addClass('red');
    })
    $('body').on('click','.details_1',function(){
      var msg = JSON.parse($(this).parent().attr('data-msg'))
      var that = $(this)
      layer.open({
        type: 1 //此处以iframe举例
        ,title: '访问详情'
        ,area: ['800px', '600px']
        ,maxmin: true
        ,content: '<div id="details"></div>'
        ,zIndex: layer.zIndex //重点1
        ,offset: '60px'
      });
      var getTpl = suntable.innerHTML;
      laytpl(getTpl).render(msg, function(html){
        $('#details').html(html)
      });
      // $('.put_ul_click').removeClass('red');
      $(this).parent().find('p').removeClass('red');

      $(this).addClass('red');
    })
    $('body').on('click','.details_2',function(){
      var msg = JSON.parse($(this).parent().attr('data-msg'))
      var that = $(this)
      layer.open({
        type: 1 //此处以iframe举例
        ,title: '访问详情'
        ,area: ['800px', '600px']
        ,maxmin: true
        ,content: '<div id="details_1"></div>'
        ,zIndex: layer.zIndex //重点1
        ,offset: '60px'
      });
      var getTpl = suntable_1.innerHTML;
      laytpl(getTpl).render(msg, function(html){
        $('#details_1').html(html)
      });
      $(this).parent().find('p').removeClass('red');
      $(this).addClass('red');
    })
    
  });
  </script>
  <script type="text/javascript" src="/js/jquery.min.js"></script>

  <script language="javascript"type="text/javascript">  
  function route_id(data_route,id,evt){
    if(data_route !=null){
            if(data_route.indexOf('goods_id')==-1){
              var data_id=data_route.substring(data_route.indexOf('site_goods')+11,data_route.length);
              if(id==data_id){
                writeToScreen(evt.data);
              }
            }else{
              var data_id=data_route.split("?")[1].split("&").filter(function(item){ return item.indexOf('goods_id')===0})[0].split("=")[1];
              if(id==data_id){
                writeToScreen(evt.data);
              }
            }
        }
  }

    //var wsUri ="ws://echo.websocket.org/";
    var dom_btn=$('#console_board');
    var wsUri ="ws://13.229.73.221:2350/";
    // var wsUri ="ws://192.168.10.10:2350/";
     //var wsUri ="ws://192.168.10.166:2350/";
    var output;

    // 遍历表格
    function goods_visit_info() {
        var goods_name_str = $('#goods_name').val();
        var goods_infos = [];
                @forEach($data as $key => $value)
        var goods_name = '{{$value['goods_name']}}';
        if(goods_name.search(goods_name_str) >= 0){
            let arr = {};
            arr.count = '{{$value['count']}}';
            arr.goods_name = goods_name;
            arr.stay_time = '{{$value['stay_time']}}';
            arr.sites_name = '{{$value['sites_name']}}';
            arr.url = '{{$value['url']}}';
            arr.time = '{{$value['time']}}';
            goods_infos.push(arr);
        }
        @endforeach
        var table_html = "";
        if(goods_infos.length > 0){
            goods_infos.forEach(function(item,index){
                if (index >= 10) {
                    table_html += '<table class="layui-table table_data_url" style="display: none">';
                    table_html += '<colgroup>';
                    table_html += '<col width="100">';
                    table_html += '<col>';
                    table_html += '</colgroup>';
                    table_html += '<tbody>';
                    table_html += '<tr>';
                    table_html += '<td>访问路由</td>';
                    table_html += '<td>';
                    table_html += item.url;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>站点名称</td>';
                    table_html += '<td>';
                    table_html += item.sites_name;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>商品名称</td>';
                    table_html += '<td>';
                    table_html += item.goods_name;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>平均访问时间</td>';
                    table_html += '<td>';
                    table_html += item.stay_time;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>日访问次数</td>';
                    table_html += '<td>';
                    table_html += item.count;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>最后离开时间</td>';
                    table_html += '<td>';
                    table_html += item.time;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '</tbody>';
                    table_html += '</table>';
                } else {
                    table_html += '<table class="layui-table table_data_url">';
                    table_html += '<colgroup>';
                    table_html += '<col width="100">';
                    table_html += '<col>';
                    table_html += '</colgroup>';
                    table_html += '<tbody>';
                    table_html += '<tr>';
                    table_html += '<td>访问路由</td>';
                    table_html += '<td>';
                    table_html += item.url;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>站点名称</td>';
                    table_html += '<td>';
                    table_html += item.sites_name;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>商品名称</td>';
                    table_html += '<td>';
                    table_html += item.goods_name;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>平均访问时间</td>';
                    table_html += '<td>';
                    table_html += item.stay_time;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>日访问次数</td>';
                    table_html += '<td>';
                    table_html += item.count;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '<tr>';
                    table_html += '<td>最后离开时间</td>';
                    table_html += '<td>';
                    table_html += item.time;
                    table_html += '</td>';
                    table_html += '</tr>';
                    table_html += '</tbody>';
                    table_html += '</table>';
                }
            });
            if(goods_infos.length > 10) {
                table_html += '<button class="layui-btn layui-btn-fluid table_data_last" onclick="out_data(this)">查看更多</button>';
            }
        }

        $('.table_data_url').remove();
        $('.table_data_last').remove();
        $('.goods_search').append(table_html);
    }


    $('.search_goods_name').click(function () {
        goods_visit_info();
    });

    //初始化数据
    function init() { 
        output = document.getElementById("output"); 
        testWebSocket();
        goods_visit_info();
    }
 
    function testWebSocket() { 
        websocket = new WebSocket(wsUri); 
        websocket.onopen = function(evt) { 
          var str='<span style="color:green;font-size: 10px;">Status:<img id="collect_status" style="width: 80px;height: 45px;border-radius:35px;" src="/images/online.gif">    已连接，通讯中...</span>'
          $('#collect_status_h2').html(str)
            onOpen(evt) 
        }; 
        websocket.onclose = function(evt) { 
           var str='<span style="color:red;font-size: 10px;" onclick="window.location.reload(true)" >Status:<img id="collect_status" style="width: 80px;height: 45px;border-radius:35px;" src="/images/close.png">断开连接...</span>'
          $('#collect_status_h2').html(str)
            onClose(evt) 
        }; 
        websocket.onmessage = function(evt) { 
            onMessage(evt) 
        }; 
        websocket.onerror = function(evt) { 
          var str='<span style="color:red;font-size: 10px;" onclick="window.location.reload(true)" >Status:<img id="collect_status" style="width: 80px;height: 45px;border-radius:35px;" src="/images/close.png">断开连接...</span>'
          $('#collect_status_h2').html(str)
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
 
    // function onMessage(evt) { 
    //     writeToScreen(evt.data); 
    //     console.log('onmessage',JSON.parse(evt.data))
    //     // websocket.close(); 
    // } 
    var id_1='',
      type_1=0,
      ip_1=''
    function onMessage(evt) { 
      var data_route=JSON.parse(JSON.parse(evt.data).msg).msg.route
      var data_type =JSON.parse(evt.data).msg_type
      if(data_type == 'notice'){
        var data_ip =JSON.parse(JSON.parse(evt.data).msg).msg.ip
      }else{
        var data_ip =JSON.parse(JSON.parse(JSON.parse(evt.data).msg).msg).ip
      }
      if(data_route !=null){
            if(data_route.indexOf('goods_id')==-1){
              var data_id=data_route.substring(data_route.indexOf('site_goods')+11,data_route.length);
            }else{
              var data_id=data_route.split("?")[1].split("&").filter(function(item){ return item.indexOf('goods_id')===0})[0].split("=")[1];
            }
        }
      var id=$('select[name="modules"]').val(),
      type=$('select[name="type"]').val(),
      ip=$('input[name="ip"]').val()
      
      // console.log(data_id, data_ip, data_type)
      // console.log(id, type, ip)
      // console.log((id==''||id==data_id)&&(type==0||type==data_type)&&(ip==''||ip==data_ip))
        
      
      
      if(id ==  ''&&type == 0 && ip == ''){
        if((id==id_1)&&(type==type_1)&&(ip==ip_1)){

        }else{
          id_1=id
          ip_1=ip
          type_1=type
          var dom_div=$('<li style="display:none"><hr style="border:1px dashed #ff0000"/></li>')
          // dom_li.show();
          //pre.append(dom_btn);
          $('#put_ul').prepend(dom_div); 
          dom_div.show(1200);
        }
        writeToScreen(evt.data);
      }else if((id==''||id==data_id)&&(type==0||type==data_type)&&(ip==''||ip==data_ip)){
        if((id==id_1)&&(type==type_1)&&(ip==ip_1)){

        }else{
          id_1=id
          ip_1=ip
          type_1=type
          var dom_div=$('<li style="display:none"><hr style="border:1px dashed #ff0000"/></li>')
          // dom_li.show();
          //pre.append(dom_btn);
          $('#put_ul').prepend(dom_div); 
          dom_div.show(1200);
        }
        writeToScreen(evt.data);
      }
        // console.log('onmessage',JSON.parse(evt.data))
        // websocket.close(); 
    }  
 
    function onError(evt) { 
        writeToScreen('<span style="color: red;">ERROR:</span> '+ evt.data); 
    }  
 
    function doSend(message) { 
        writeToScreen("SENT: " + message);  
        websocket.send(JSON.stringify({laofan:'laofan'})); 
    }  
 
    function writeToScreen(message) { 
        if(message=='hello' || message=='第一次打开'){
            return;
        }
        message=JSON.parse(message);
        // console.log(message);
        msg=JSON.parse(message.msg);
        // console.log(msg.msg)
        //console.log(JSON.parse(message.msg))
        var dom_li=$('#console_board_li').clone();
        var dom_btn=dom_li.children();
        var put_ul=$('#put_ul');
        //pre.style.wordWrap = "break-word"; 
        if(message.msg_type =='notice'){
          if(msg.msg.msg=='离开页面'){
          var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-l">'
                +'<div class="layui-block details" style="color:red">'
                  +'<span>操作: </span>'+msg.msg.msg+'<span>I P: </span>'+msg.msg.ip+'<span>时间: </span>'+msg.msg.time+'<span>停留时间: </span>'+msg.msg.stay_time
                +'秒</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.msg.route
                +'</div>'
              +'</blockquote>'
            // dom_btn.html('操作：'+msg.msg.msg+'    |   路由：'+msg.msg.route+'    |   IP：'+msg.msg.ip+'   |   时间：'+msg.msg.time+'  |   停留时间：'+msg.msg.stay_time); 
        }else if(msg.msg.msg=='访问请求...'||msg.msg.msg=='路由访问'){
          var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r">'
                +'<div class="layui-block details">'
                  +'<span>操作: </span>'+msg.msg.msg+'<span>I P: </span>'+msg.msg.ip+'<span>时间: </span>'+msg.msg.time+'<span>'
                +'</div>'
               
              +'</blockquote>'
                    // dom_btn.html('操作：'+msg.msg.msg+'    |   路由：'+msg.msg.route+'    |   IP：'+msg.msg.ip+'   |   时间：'+msg.msg.time); 

        }else if(msg.msg.msg=='访问页面'||msg.msg.msg=='进入页面'){
            var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r">'
                +'<div class="layui-block details" style="color:green">'
                  +'<span>操作: </span>'+msg.msg.msg+'<span>I P: </span>'+msg.msg.ip+'<span>时间: </span>'+msg.msg.time
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.msg.route
                +'</div>'
              +'</blockquote>'
        }
        }else if(message.msg_type =='data'){
          msg=JSON.parse(msg.msg);
          if(msg.msg=='输入联系方式'){
            if(msg.hasOwnProperty('route')){
              var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r put_ul_click ft-l-blue" data-msg=\''+message.msg+'\'>'
                +'<div class="layui-block details" style="color:#ea6f5a">'
                  +'<span>操作: </span>'+msg.msg+'<span>I P: </span>'+msg.ip+'<span>时间: </span>'+msg.time+'<span>电话: </span>'+msg.ip_msg.telephone+'<span>邮箱: </span>'+msg.ip_msg.email
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.route
                +'</div>'
              +'</blockquote>'
            }else{
              var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r ft-l-blue">'
                +'<div class="layui-block details" style="color:#ea6f5a">'
                  +'<span>操作: </span>'+msg.msg+'<span>I P: </span>'+msg.ip+'<span>时间: </span>'+msg.time+'<span>电话: </span>'+msg.ip_msg.telephone+'<span>邮箱: </span>'+msg.ip_msg.email
                +'</div>'
              +'</blockquote>'
            }
        }
        }else if(message.msg_type =='event'){
          msg=JSON.parse(msg.msg);
              if(msg.ip_event.tpye == 'mqcClick'){
                var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r put_ul_click ft-l-green" data-msg=\''+message.msg+'\'>'
                +'<div class="layui-block details" style="color:#000">'
                  +'<span>操作: </span>评论区被点击<span>I P: </span>'+msg.ip+'<span>评论ID: </span>'+msg.ip_event.com_id
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.ip_event.router
                +'</div>'
              +'</blockquote>'
              }else if(msg.ip_event.tpye == 'mqcImgClick'){
                var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r put_ul_click ft-l-green" data-msg=\''+message.msg+'\'>'
                +'<div class="layui-block details" style="color:#000">'
                  +'<span>操作: </span>图片被点击<span>I P: </span>'+msg.ip+'<span>评论ID: </span>'+msg.ip_event.com_id
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.ip_event.router
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>图片: </span><img src="'+msg.ip_event.value+'" alt="">'
                +'</div>'
              +'</blockquote>'
              }else if(msg.ip_event.tpye == 'comment'){
                var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r put_ul_click ft-l-green" data-msg=\''+message.msg+'\'>'
                +'<div class="layui-block details" style="color:#000">'
                  +'<span>操作: </span>查看评论区<span>I P: </span>'+msg.ip+'<span>停留时间: </span>'+msg.ip_event.countTime
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.ip_event.router
                +'</div>'
              +'</blockquote>'
              }else if(msg.ip_event.tpye == 'detial'){
                var str = '<blockquote class="layui-elem-quote layui-quote-nm ft-r put_ul_click ft-l-green" data-msg=\''+message.msg+'\'>'
                +'<div class="layui-block details" style="color:#000">'
                  +'<span>操作: </span>查看用户须知<span>I P: </span>'+msg.ip+'<span>停留时间: </span>'+msg.ip_event.countTime
                +'</div>'
                +'<div class="layui-block details">'
                  +'<span>路由: </span>'+msg.ip_event.router
                +'</div>'
              +'</blockquote>'
              }
        }
        var dom_div=$('<li style="display:none"></li>')
        //dom_div.css('display','none');
        dom_div.html('<div style="overflow: hidden;">'+str+'</div>');
        // dom_li.show();
        //pre.append(dom_btn);
        $('#put_ul').prepend(dom_div); 
        dom_div.show(1200);
        if($('#put_ul li').length>=250){
          $('#put_ul li').eq(250).nextAll().remove();
        }
     
    }
    // 查看更多
    function out_data(obj){
        $(obj).hide();
        $('.table_data_url').show();
    }

    window.addEventListener("load", init, false);  
</script> 
@endsection
