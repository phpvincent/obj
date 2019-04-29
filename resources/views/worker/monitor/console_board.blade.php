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
  overflow: hidden;
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
                console.log(msg);
                // console.log($('select[name="modules"]'));
                var str='';
                $.each(msg.data,function(index,val){
                  str+= '<option value="'+val.goods_id+'">'+val.goods_real_name+'</option>'
                });
                $('select[name="modules"]').append(str);
                form.render();
              }
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
    function onMessage(evt) { 
      var data_route=JSON.parse(JSON.parse(evt.data).msg).msg.route
      var id=$('select[name="modules"]').val()
      if(id ==  ''){
        writeToScreen(evt.data);
      }else{
        route_id(data_route,id,evt);
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
        if(message=='hello'){
            return;
        }
        /*console.log(message);*/
        message=JSON.parse(message);
        msg=JSON.parse(message.msg);
        //console.log(JSON.parse(message.msg))
        var dom_li=$('#console_board_li').clone();
        var dom_btn=dom_li.children();
        var put_ul=$('#put_ul');
        //pre.style.wordWrap = "break-word"; 
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
        var dom_div=$('<li style="display:none"></li>')
        //dom_div.css('display','none');
        dom_div.html(str);
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
