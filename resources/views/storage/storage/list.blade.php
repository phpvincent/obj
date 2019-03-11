@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
  <div class="layui-card">
   <table id="storagelist" lay-filter='button-listen'></table>
  </div>
</div>
  <script type="text/html" id="use_button">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="test-laydate-start"
                       placeholder="开始日期">
            </div> -
            <div class="layui-input-inline">
                <input type="text" class="layui-input" id="test-laydate-end"
                       placeholder="结束日期">
            </div>
            <div class="layui-inline">
             <input class="layui-input" name="id" id="test-table-demoReload"
                                               autocomplete="off" placeholder="检索信息">
            </div>
            <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:black;"
               onclick="goods_show('新建仓库','{{url("")}}',2,1400,800)">检索</b>
            </button>
        </div>
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('新建仓库','{{url("")}}',2,1400,800)">新建仓库</b>
        </button>

  </script>
  <script type="text/html" id="area">
   <div>
    @{{# if(d.is_local==1){ }}
      <span style='color:green'>本地仓</span>
    @{{# }else if(d.template_type_primary_id==0||d.template_type_primary_id==1){ }}
      <span style='color:brown'>台湾地区仓</span>
    @{{# }else if(d.template_type_primary_id==2){ }}
      <span style='color:brown'>阿联酋地区仓</span>
    @{{# }else if(d.template_type_primary_id==3){ }}
      <span style='color:brown'>马来西亚地区仓</span>
    @{{# }else if(d.template_type_primary_id==4){ }}
      <span style='color:brown'>泰国地区仓</span>
    @{{# }else if(d.template_type_primary_id==5){ }}
      <span style='color:brown'>日本地区仓</span>
    @{{# }else if(d.template_type_primary_id==6){ }}
      <span style='color:brown'>印尼地区仓</span>
    @{{# }else if(d.template_type_primary_id==7){ }}
      <span style='color:brown'>菲律宾地区仓</span>
    @{{# }else if(d.template_type_primary_id==8){ }}
      <span style='color:brown'>英国地区仓</span>
    @{{# }else if(d.template_type_primary_id==9||d.template_type_primary_id==10){ }}
      <span style='color:brown'>美国地区仓</span>
    @{{# }else if(d.template_type_primary_id==11){ }}
      <span style='color:brown'>越南地区仓</span>
    @{{# }else if(d.template_type_primary_id==12||d.template_type_primary_id==13){ }}
      <span style='color:brown'>沙特地区仓</span>
    @{{# }else if(d.template_type_primary_id==14||d.template_type_primary_id==15){ }}
      <span style='color:brown'>卡塔尔地区仓</span>
    @{{# }else if(d.template_type_primary_id==16||d.template_type_primary_id==17){ }}
      <span style='color:brown'>中东地区仓</span>
    @{{# } }}
  </div>
</script>
<script type="text/html" id='is_local'>
  <div>
  @{{# if(d.is_local==1){ }}
    <span style='color:green'>本地仓</span>
  @{{# }else{ }}
    <span style='color:brown'>海外仓</span>
  @{{# } }}
  </div>
</script>
<script type="text/html" id="button" >
  <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
@endsection
@section('js')


<script>
   layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table'],function(){
    var table = layui.table;
    var $ =layui.jquery;
      table.render({
      elem: '#storagelist'
      ,height: 312
      ,url: '/admin/storage/list/data' //数据接口
      ,page: true //开启分页
      ,toolbar:'#use_button'
      ,defaultToolbar: ['filter', 'print']
      ,cols: [[ //表头
        {field: 'storage_id', title: 'ID', sort: true, fixed: 'left'}
        ,{field: 'storage_name', title: '仓库名'}
        ,{field: 'template_type_primary_id', title: '仓库地区',templet:'#area'}
        ,{field: 'is_local', title: '仓库类型',templet:'#is_local'} 
        ,{field: 'admin_name', title: '仓库所属人',}
        ,{field: 'check_at', title: '上次出库时间', sort: true}
        ,{field: 'created_at', title: '仓库建立时间', sort: true}
        ,{field: 'button', title: '操作', toolbar:'#button'}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     });
    //table事件监听
    table.on("tool(button-listen)",function(obj){
      var data = obj.data; //获得当前行数据
      var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
      var tr = obj.tr; //获得当前行 tr 的DOM对象
      if(layEvent=='detail'){
        layer.open();
      }else if(layEvent=='edit'){
        layer.open();
      }else{
        layer.confirm('真的删除行么', function(index){
          obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
          layer.close(index);
          //向服务端发送删除指令
          $.ajax({
             url:"{{url('admin/storage/list/del_storage')}}",
              type:'get',
              data:{id:data.storage_id},
              datatype:'json',
              success:function(msg){
                     if(msg['err']==1){
                       layer.close(index);   
                       layer.msg(msg.str,{
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){
                          parent.layui.admin.events.refresh();
                        });
                     }else if(msg['err']==0){
                      layer.close(index);   
                       layer.msg(msg.str);
                     }else{
                      layer.close(index);   
                       layer.msg('删除失败！');
                     }
              }
          });
        });
      }
    })
    goods_show=function goods_show(title,url,type,w,h){
      layer.open({
        skin: 'layui-layer-nobg', //没有背景色
                        type: type,
                        title: title,
                        area: [w, h],
                        fixed: false, //不固定
                        maxmin: true,
                        content: url
                  });
    }
  });
</script>
@endsection