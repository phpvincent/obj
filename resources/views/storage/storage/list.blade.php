@extends('storage.father.static')
@section('content')
  <div class="layui-form layui-card-header layuiadmin-card-header-auto">
    <div class="layui-form-item">
      <div class="layui-inline test-table-reload-btn">
        <button class="layui-btn" id="addgoods_kind">新增仓库</button>
      </div>
    </div>
    <div class="layui-form-item">
      <div class="layui-inline">
        <div class="layui-form-item">
          <div class="layui-inline">
            <label class="layui-form-label">日期范围：</label>
            <div class="layui-input-inline">
              <input type="text" class="layui-input" id="test-laydate-start"
                     placeholder="开始日期">
            </div>
            <div class="layui-form-mid">
              -
            </div>
            <div class="layui-input-inline">
              <input type="text" class="layui-input" id="test-laydate-end"
                     placeholder="结束日期">
            </div>
          </div>
          <span style="color: red">时间不选择默认为近10天</span>
        </div>
      </div>
      <div class="layui-inline">
        <label class="layui-form-label">产品分类</label>
        <div class="layui-input-block">
          <select name="product_type_id" id="product_type_id" lay-verify="required">
            <option value="0">所有</option>
            @foreach(\App\product_type::all() as $k => $v)
              <option value="{{$v->product_type_id}}">{{$v->product_type_name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="layui-inline test-table-reload-btn">
        <label>从当前数据中检索:</label>
        <div class="layui-inline">
          <input class="layui-input" name="id" id="test-table-demoReload"
                 autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
        <button class="layui-btn" id="outorder">产品导出</button>
      </div>
    </div>
  </div>
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
    var that = this;
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

       //搜索刷新数据
       var $ = layui.$;

     //新增产品
     $('#addgoods_kind').on('click', function () {
         that.goods_show('新增仓库', '{{url("admin/storage/add_storage")}}',2,600,510);
     });
  });

  //model 模态框
  function goods_show(title, url, type, w, h) {
      layer.open({
          type: type,
          title: title,
          area: [w, h],
          fixed: false, //不固定
          maxmin: true,
          content: url
      });
  }

</script>
@endsection