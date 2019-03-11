@extends('storage.father.static')
@section('content')
  <table id="storagelist" lay-filter="test"></table>
@endsection
@section('js')
<script type="text/javascript">
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
</script>
<script type="text/javascript">
  @{{# if(d.is_local==1)}{ }}
    <span style='color:green'>本地仓</span>
  @{{# }else{ }}
    <span style='color:brown'>海外仓</span>
  @{{# } }}
</script>
<script>
   layui.config({
    base: '{{asset("/admin/layuiadmin/")}}/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','admin', 'table'],function(){
    var table = layui.table;
      table.render({
      elem: '#storagelist'
      ,height: 312
      ,url: '/admin/storage/list/data' //数据接口
      ,page: true //开启分页
      ,cols: [[ //表头
        {field: 'id', title: 'ID', sort: true, fixed: 'left'}
        ,{field: 'storage_name', title: '仓库名'}
        ,{field: 'template_type_primary_id', title: '仓库地区',template:'area'}
        ,{field: 'is_local', title: '仓库类型',template:'is_local'} 
        ,{field: 'admin_id', title: '仓库所属人',}
        ,{field: 'check_at', title: '上次出库时间', sort: true}
        /*,{field: 'score', title: '评分', width: 80, sort: true}
        ,{field: 'classify', title: '职业', width: 80}
        ,{field: 'wealth', title: '财富', width: 135, sort: true}*/
      ]]
     });
  });

</script>
@endsection