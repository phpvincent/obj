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
.course{margin-top:10px}
.course_nr li:hover {cursor:pointer;}
.course{ height:145px; background:#FFF;}
.course_nr{height:55px; background:url(/images/ico9.gif) repeat-x center;}
.course_nr li{ float:left; background:url(/images/ico10.gif) no-repeat center top; padding-top:30px; width:100px; text-align:center; position:relative; margin-top:10px;}
.shiji{ position:absolute; width:100%; left:0; top:-19px; display:none;}
.shiji h1{ height:67px; line-height:67px; color:#518dbb; font-weight:bold; background:url(/images/ico11.gif) no-repeat center top; margin-bottom:8px;}
.shiji p{ line-height:14px; color:#999;}
.course_nr2>li>span{
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow-wrap: break-word;
}
.ip_title{
  max-width: 166px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow-wrap: break-word;
}
</style>
<div class="layui-fluid">
<div class="layui-card">
<form class="layui-form" action="" lay-filter="example">
  <div class="layui-card-header layui-form layuiadmin-card-header-auto">
  <div class="layui-form-item">
      
      <div class="layui-inline">
          <label class="layui-form-label">路由搜索</label>
          <div class="layui-input-block">
          <input type="text" name="" placeholder="请输入" autocomplete="off" class="layui-input ipt">
          </div>
      </div>
      <div class="layui-inline">
      <button class="layui-btn" id="reload1">搜索</button>
      </div>
      <div class="layui-inline">
          <label class="layui-form-label">总人数:</label>
          <div class="layui-input-block num">

          </div>
      </div>
      <div class="layui-inline">
      <label class="layui-form-label">自动刷新:</label>
        <input type="checkbox" name="zzz" lay-skin="switch"checked="" lay-text="开启|关闭"lay-filter="switchTest">
      </div>
  </div>
  
  </div>
  <div class="layui-card-body">
      <table id="table1" lay-filter='table1'></table>
  </div>
</div>
</div>
</form>

<div class="layui-container" id="tabDom" style="display: none;">  
  <div class="layui-row">
    <div class="layui-col-md6">
    <div class="layui-tab">
      <ul class="layui-tab-title">
      </ul>
      <div class="layui-tab-content">
        
      </div>
    </div>
    </div>
</div>
<script id="suntable" type="text/html">
<fieldset class="layui-elem-field">
    <div>
      操作记录
    </div>
    <div class="course">
      <div class="clearfix web_widht course_nr">
          <ul class="course_nr2">
          @{{#  layui.each(d.data.routes, function(index, item){ }}
          <li datasj="@{{item.start_date}}"dataurl="@{{item.route}}">
                <span>@{{item.route}}</span>
                <div class="shiji" style="display: none;">
                    <!-- <h1>@{{item.storage_log_type}}</h1> -->
                    <h1>1</h1>
                    <p>@{{item.start_date}}</p>
                </div>
          </li>
          @{{#  }); }}
          </ul>
      </div>
    </div>
    <blockquote class="layui-elem-quote dataurl">路由地址:<span>@{{d.data.routes[0].route}}</span></blockquote>
    <blockquote class="layui-elem-quote datasj">时间:<span>@{{d.data.routes[0].start_date}}</span></blockquote>
    <br><hr><br>
    <div>
      联系方式
    </div>
    <blockquote class="layui-elem-quote">email:@{{#  if(d.data.ip_msg.email){ }}@{{d.data.ip_msg.email}}@{{# }else{ }}@{{# } }}</blockquote>
  <blockquote class="layui-elem-quote">telephone:@{{#  if(d.data.ip_msg.telephone){ }}@{{d.data.ip_msg.telephone}}@{{# }else{ }}@{{# } }}</blockquote>
    <div>
      设备详情
    </div>
	<div class="layui-field-box">
  <blockquote class="layui-elem-quote">core:@{{d.data.deviceData.core}}</blockquote>
  <blockquote class="layui-elem-quote">iPad:@{{#  if(d.data.deviceData.iPad){ }}是@{{# }else{ }}否@{{# } }}</blockquote>
  <blockquote class="layui-elem-quote">iPhone:@{{#  if(d.data.deviceData.iPhone){ }}是@{{# }else{ }}否@{{# } }}</blockquote>
  <blockquote class="layui-elem-quote">iosOrAndroid:@{{d.data.deviceData.iosOrAndroid}}</blockquote>
  <blockquote class="layui-elem-quote">language:@{{d.data.deviceData.language}}</blockquote>
  <blockquote class="layui-elem-quote">mobile:@{{#  if(d.data.deviceData.mobile){ }}是@{{# }else{ }}否@{{# } }}</blockquote>
  <blockquote class="layui-elem-quote">system:@{{d.data.deviceData.system}}</blockquote>
  <blockquote class="layui-elem-quote">webApp:@{{#  if(d.data.deviceData.webApp){ }}是@{{# }else{ }}否@{{# } }}</blockquote>
  
  
  </div>

  
  </fieldset>
</script>
<script id="timeLine" type="text/html">
  @{{#  layui.each(d, function(index, item){ }}
  <li dataid="@{{item.storage_log_id}}">
        <span>@{{item.admin_show_name}}</span>
        <div class="shiji" style="display: none;">
            <h1>@{{item.storage_log_type}}</h1>
            <p>@{{item.created_at}}</p>
        </div>
  </li>
  @{{#  }); }}
  </script>
@endsection
@section('js')
<script>
   layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table','laydate', 'laytpl','form'],function(){
    var table = layui.table;
    var laydate = layui.laydate;
    var $ =layui.jquery;
    var layer = layui.layer;
    var laytpl = layui.laytpl;
    var form = layui.form
    
    var options={
      elem: '#table1'
      ,url: '/admin/worker/monitor/page/get_table' //数据接口
      ,page: false //开启分页
      ,text: {
        none: '暂无数据' 
      }
      ,autoSort:false
      ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
      ,method:'get'
      ,cols: [[ //表头
         {type:'checkbox', fixed: 'left'}
        ,{field: 'route', title: '路由'}
        ,{field: 'num', title: '人数'}
        ,{field: 'route_name', title: '当前页'}
        ,{field: 'goods_name', title: '产品名称'}
        ,{field: 'sites_name', title: '站点名称'}
        ,{field: 'area', title: '地区'}
      ]],
      done:function(res){
        // console.log(res)
        $('.num').text(res.num)
      }
     };
    //表格初始化
    table.render(options);
    function aa(){
      table.reload('table1')
    }
    var dt=setInterval(aa,30000);
    //监听指定开关
  form.on('switch(switchTest)', function(data){
    // layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
    //   offset: '6px'
    // });
    if(this.checked){
      dt=setInterval(aa,30000);
    }else{
      clearInterval(dt);
    }
  });
    // //排序监听
    // 表格1复选框监听
    var flag = true // true 表示没有一个弹层
    table.on('checkbox(table1)', function(obj){

      // console.log(obj)
      var route1 = obj.data.route.replace(/[&\|\\\/*^%$#:.@?&=\-]/g,"");
    var closeFunc = function () {
        $('#tabDom .layui-tab-title li').remove()
        $('#tabDom .layui-tab-content div').remove()
         layer.closeAll();
         flag = true
        table.reload('table1')
    }

    var songTable = function (route,route1,goods_name) {
      var options={
      elem: '#'+route1
      ,url: '/admin/worker/monitor/page/ip_list' //数据接口
      ,page: false //开启分页
      ,text: {
        none: '暂无数据' 
      }
      ,width: 400
      ,autoSort:false
      ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
      ,method:'post'
      ,where: {
        route: route,
        goods_name: goods_name
      }
      ,cols: [[ //表头
         {field: 'ip', title: 'ip', minWidth: 150},
         {field: 'city', title: '地区', minWidth: 150}
      ]]
     };
       //zi表格初始化
       table.render(options);
       table.on('row('+route1+')', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
      //  console.log(obj)
         var data = obj.data; //获得当前行数据
         var ip1 = obj.data.ip.replace(/[&\|\\\/*^%$#:.@?&=\-]/g,"");
        //  if(obj.event === 'showsong'){ 
            // console.log(data)
            layer.open({
            type: 1 //此处以iframe举例
            ,title: '访问详情'
            ,area: ['800px', '600px']
            ,maxmin: true
            ,content: '<div id="'+ip1+'"></div>'
            ,zIndex: layer.zIndex //重点1
          })
          $.ajax({
                url:'/admin/worker/monitor/page/ip_info',
                type:'post',
                data:{
                  ip: data.ip
                },
                // datatype:'json',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                success:function(msg){
                   if(msg.data ==null){
                    $('#'+ip1).html('<div>暂无数据</div>')
                   }else{
                    var getTpl = suntable.innerHTML;
                  
                  laytpl(getTpl).render(msg, function(html){
                   //  console.log(html)
                    $('#'+ip1).html(html)
                   //  console.log($('#'+ip1))
                  });
                   }
                   
                    $('.datasj span').text(msg.data.routes[0].start_date)
                    $('.dataurl span').text(msg.data.routes[0].route)
                   $(function(){
              
                    $('body').on('click','.course_nr2 li', function() {
                      $('.datasj span').text($(this).attr('datasj'))
                    $('.dataurl span').text($(this).attr('dataurl'))
                    })
                  //首页大事记
                  $('.course_nr2 li').hover(function(){
                      $(this).find('.shiji').stop().slideDown(600);
                      $(this).find('span').hide();
                  },function(){
                      $(this).find('.shiji').stop().slideUp(100);
                      $(this).find('span').show();
                  });
              });
                }
          })
        //  }

       })
    }

    if (flag) {
      layer.open({
        type: 1 //此处以iframe举例
        ,title: '多记录对比'
        ,area: ['500px', '100%']
        ,shade: 0
        ,maxmin: true
        ,offset: 'rt'
        ,content: $('#tabDom')
        ,btn: ['全部关闭'] //只是为了演示
        ,end: function (){
          closeFunc()
        }
        ,btn2: function(){
          closeFunc()
        }
        ,zIndex: layer.zIndex //重点1
        ,success: function(layero){
          layer.setTop(layero); //重点2
        }
      })
      flag = false
    }
    if(obj.checked){
      if($('#tabDom .layui-tab-title li').length === 0){
        $('#tabDom .layui-tab-title').append('<li class="layui-this ip_title" dataid="'+route1+'">'+obj.data.route_name+'</li>')
        $('#tabDom .layui-tab-content').append('<div class="layui-tab-item layui-show" dataid="'+route1+'"><div class="layui-field-box"><blockquote class="layui-elem-quote">当前页:'+obj.data.route_name+'</blockquote><blockquote class="layui-elem-quote">产品名称:'+obj.data.goods_name+'</blockquote><blockquote class="layui-elem-quote">站点名称:'+obj.data.sites_name+'</blockquote></div><div class="layui-inline"><label class="layui-form-label">ip搜索</label><div class="layui-input-block"><input type="text" name="" placeholder="请输入" autocomplete="off" class="layui-input ipt"></div></div><div class="layui-inline"><button class="layui-btn" id="reload2">搜索</button></div><table id="'+route1+'" lay-filter="'+route1+'"></table></div>')
        // console.log(obj.data.route)
          songTable(obj.data.route,route1,obj.data.goods_name)
      } else {
        $('#tabDom .layui-tab-title').append('<li dataid="'+route1+'"class="ip_title">'+obj.data.route_name+'</li>')
        $('#tabDom .layui-tab-content').append('<div class="layui-tab-item" dataid="'+route1+'"><div class="layui-inline"><label class="layui-form-label">ip搜索</label><div class="layui-input-block"><input type="text" name="" placeholder="请输入" autocomplete="off" class="layui-input ipt"></div></div><div class="layui-inline"><button class="layui-btn" id="reload2">搜索</button></div><table id="'+route1+'" lay-filter="'+route1+'"></table></div>')
        songTable(obj.data.route,route1,obj.data.goods_name)
        // songSibTable(obj.data.storage_check_id)
      }
    } else {
        $('#tabDom .layui-tab-title li[dataid="'+route1+'"]').remove()
        $('#tabDom .layui-tab-content div[dataid="'+route1+'"]').remove()
      }
    });




    $('body').on('click','#reload1',function(){
    var oTab=$('.layui-table-body>.layui-table')[0];
    var oTab1=$('.layui-table-body>.layui-table')[1];
    var oBt=$('.ipt').val();
//     oBt[1].onclick=function(){
     for(var i=0;i<oTab.tBodies[0].rows.length;i++)
     {
//       var str1=oTab.tBodies[0].rows[i].cells[1].innerHTML.toUpperCase();
      var str1=$(oTab.tBodies[0].rows[i].cells[1]).children().text().toUpperCase();
      var str2=oBt.toUpperCase();
      if(str1==str2){
       oTab.tBodies[0].rows[i].style.display='block';
       oTab1.tBodies[0].rows[i].style.display='block';
      }
      else{
        oTab.tBodies[0].rows[i].style.display='none';
        oTab1.tBodies[0].rows[i].style.display='none';
      }
     /***********************************JS实现表格的模糊搜索*************************************/
     //表格的模糊搜索的就是通过JS中的一个search()方法，使用格式，string1.search(string2);如果
     //用户输入的字符串是其一个子串，就会返回该子串在主串的位置，不匹配则会返回-1，故操作如下
     if(str1.search(str2)!==-1&&str2!=''){
       oTab.tBodies[0].rows[i].style.display='block';
       oTab1.tBodies[0].rows[i].style.display='block';
      }else{
        oTab.tBodies[0].rows[i].style.display='none';
        oTab1.tBodies[0].rows[i].style.display='none';}
      if(str2==''){oTab.tBodies[0].rows[i].style.display='block';oTab1.tBodies[0].rows[i].style.display='block';}
     /***********************************JS实现表格的多关键字搜索********************************/
     //表格的多关键字搜索，加入用户所输入的多个关键字之间用空格隔开，就用split方法把一个长字符串以空格为标准，分成一个字符串数组，
     //然后以一个循环将切成的数组的子字符串与信息表中的字符串比较
//      var arr=str2.split(' ');
//      for(var j=0;j<arr.length;j++)
//      {
//       if(str1.search(arr[j])!=-1){oTab.tBodies[0].rows[i].style.background='red';}
//      }
     }
    })



    $('body').on('click','#reload2',function(){
      // console.log($(this).parent().next().children('div').find('table')[1])
      // console.log($(this).parent().parent().find('.layui-form').find('table')[1])
      // console.log($(this).parent().prev().find('input').val())
    var oTab=$(this).parent().parent().find('.layui-form').find('table')[1];
    var oBt=$(this).parent().prev().find('input').val();
//     oBt[1].onclick=function(){
     for(var i=0;i<oTab.tBodies[0].rows.length;i++)
     {
//       var str1=oTab.tBodies[0].rows[i].cells[1].innerHTML.toUpperCase();
      var str1=$(oTab.tBodies[0].rows[i].cells[0]).children().text().toUpperCase();
      var str2=oBt.toUpperCase();
      if(str1==str2){
       oTab.tBodies[0].rows[i].style.display='block';
      }
      else{
        oTab.tBodies[0].rows[i].style.display='none';
      }
     /***********************************JS实现表格的模糊搜索*************************************/
     //表格的模糊搜索的就是通过JS中的一个search()方法，使用格式，string1.search(string2);如果
     //用户输入的字符串是其一个子串，就会返回该子串在主串的位置，不匹配则会返回-1，故操作如下
     if(str1.search(str2)!==-1&&str2!=''){
       oTab.tBodies[0].rows[i].style.display='block';
      }else{
        oTab.tBodies[0].rows[i].style.display='none';}
      if(str2==''){oTab.tBodies[0].rows[i].style.display='block';}
     /***********************************JS实现表格的多关键字搜索********************************/
     //表格的多关键字搜索，加入用户所输入的多个关键字之间用空格隔开，就用split方法把一个长字符串以空格为标准，分成一个字符串数组，
     //然后以一个循环将切成的数组的子字符串与信息表中的字符串比较
//      var arr=str2.split(' ');
//      for(var j=0;j<arr.length;j++)
//      {
//       if(str1.search(arr[j])!=-1){oTab.tBodies[0].rows[i].style.background='red';}
//      }
     }
//     }
    })


    // $.ajax({
    //        url:'/admin/storage/log/time_line',
    //        type:'get',
    //        success:function(msg){
    //           console.log(msg)
    //           var getTpl = timeLine.innerHTML;
    //           laytpl(getTpl).render(msg, function(html){
    //             $('ul.course_nr2').append(html)
    //           });
    //           // 时间线样式
              
    //        }
    //       })

    // $(function(){
    //   console.log($('.layui-table-box>.layui-table-body>.layui-table').children())
    // console.log($('table').eq(2).find("tr").children("td").eq(2))
    // })
    
    })

</script>
@endsection