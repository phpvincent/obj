{{--@extends('admin.father.css')--}}
{{--@section('content')--}}
{{--<div class="page-container">--}}
{{--<div class="text-c"> 日期范围：--}}
{{--<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}'})" id="datemin" class="input-text Wdate" style="width:120px;">--}}
{{-----}}
{{--<input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')||\'%y-%M-#{%d-10}\'}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">--}}
{{--<!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->--}}
{{--<button type="submit" class="btn btn-success" id="seavis1" name=""><i class="Hui-iconfont">&#xe665;</i> 搜产品</button>--}}
{{--&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outorder" name=""><i class="Hui-iconfont">&#xe640;</i> 产品导出</button>--}}
{{--</div>--}}
{{--<div style="text-align: center;color: red">选择时间应该在10天内,时间不选择默认为近10天</div>--}}
{{--</div>--}}
{{--<img id="img" width="100%" src="" style="display: none;">--}}
{{--<div class="page-container">--}}
{{--<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">--}}
{{--<button type="button" class="btn btn-primary-outline radius" style="border-radius: 8%;" id="addgoods_kind" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加新产品</button></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>--}}
{{--<label class="form-label col-xs-1 col-sm-1">产品分类：</label>--}}
{{--<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">--}}
{{--<select name="product_type_id" id="product_type_id" class="select">--}}
{{--<option value="0">所有</option>--}}
{{--@foreach(\App\product_type::all() as $k => $v)--}}
{{--<option value="{{$v->product_type_id}}">{{$v->product_type_name}}</option>--}}
{{--@endforeach--}}
{{--</select>--}}
{{--</span>--}}
{{--</div>--}}
{{--<br>--}}
{{--</div>--}}
{{--<table class="table table-border table-bordered table-bg" id="goods_index_table">--}}
{{--<thead>--}}
{{--<tr>--}}
{{--<th scope="col" colspan="15">产品列表</th>--}}
{{--</tr>--}}
{{--<tr class="text-c">--}}
{{--<th width="40">ID</th>--}}
{{--<th width="110">产品名</th>--}}
{{--<th width="110">产品英文名</th>--}}
{{--<th width="110">产品图片</th>--}}
{{--<th width="110">单品分类</th>--}}
{{--<th width="110">属性</th>--}}
{{--<th width="110">绑定商品个数</th>--}}
{{--<th width="110">产品重量</th>--}}
{{--<th width="110">产品体积</th>--}}
{{--<th width="110">邮费（元）</th>--}}
{{--<th width="80">SKU绑定状态</th>--}}
{{--<th width="70">添加时间</th>--}}
{{--<th width="100">操作</th>--}}
{{--</tr>--}}
{{--</thead>--}}
{{--</table>--}}
{{--@endsection--}}
{{--@section('js')--}}
{{--<script type="text/javascript">--}}
{{--function shuaxin(){--}}

{{--$("#goods_index_table").DataTable().draw(false);--}}
{{--// quanxuan()--}}
{{--}--}}
{{--$.tablesetting={--}}
{{--"lengthMenu": [[10,20],[10,20]],--}}
{{--"paging": true,--}}
{{--"info":   true,--}}
{{--"searching": true,--}}
{{--"ordering": true,--}}
{{--"order": [[ 0, "desc" ]],--}}
{{--"stateSave": false,--}}
{{--"columnDefs": [{--}}
{{--"targets": [1,2,3,4,5,6,7,8,9,10,11,12],--}}
{{--"orderable": false--}}
{{--}],--}}
{{--"processing": true,--}}
{{--"serverSide": true,--}}
{{--"ajax": {--}}
{{--"data":{--}}
{{--product_type_id:function(){return $('#product_type_id').val()},--}}
{{--min:function(){return $('#datemin').val()},--}}
{{--max:function(){return $('#datemax').val()},--}}
{{--},--}}
{{--"url": "{{url('admin/kind/get_table')}}",--}}
{{--"type": "POST",--}}
{{--'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }--}}
{{--},--}}
{{--"columns": [--}}
{{--{"data":'goods_kind_id'},--}}
{{--{'data':'goods_kind_name'},--}}
{{--{'data':'goods_kind_english_name'},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--{'data':'product_type_name'},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--{'data':'goods_kind_volume'},--}}
{{--{'data':'goods_kind_postage'},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--{'data':'goods_kind_time'},--}}
{{--{'defaultContent':"","className":"td-manager"},--}}
{{--],--}}
{{--"createdRow":function(row,data,dataIndex){--}}
{{--// {'data':'num'},--}}
{{--var info='<a title="修改产品属性" href="javascript:;" onclick="goods_show(\'修改产品属性\',\'{{url("admin/kind/upgoods_kind")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="修改产品属性"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除产品" href="javascript:;" onclick="del_goods('+data.goods_kind_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除产品"><i class="Hui-iconfont">&#xe6e2;</i></span></a>';--}}
{{--if(data.goods_kind_sku_status!=1){--}}
{{--info+='<a title="释放产品SKU" href="javascript:;" onclick="del_sku('+data.goods_kind_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="释放产品SKU"><i class="Hui-iconfont"></i></span></a>';--}}
{{--}--}}
{{--var check='<a title="属性详情" href="javascript:;" onclick="goods_show(\'查看属性详情\',\'{{url("admin/kind/show")}}?id='+data.goods_kind_id+'\',\'2\',\'600\',\'500\')" class="ml-5"><span class="label label-default radius" style="background-color:#ccc;color:green;">查看属性详情</span></a>';--}}
{{--var num='<a title="商品列表" href="javascript:;" onclick="goods_info(\'{{url("admin/goods/index")}}?id='+data.goods_kind_id+'\',\''+ data.num + '\')" class="ml-5"><span class="label label-default radius" style="background-color:#ccc;color:red;">'+ data.num +'</span></a>';--}}
{{--if ( data.goods_kind_img != null && data.goods_kind_img != '') {--}}
{{--var img = '<img alt="产品图片"  src="/' + data.goods_kind_img + '" target="_blank" width="50px" onclick="layer_img($(this).attr(\'src\'))">'--}}
{{--}else {--}}
{{--var img = '';--}}
{{--}--}}
{{--if(data.goods_kind_sku_status==0){--}}
{{--var sku='<span class="l"><button type="button"  class="btn btn-primary-outline radius" style="border-radius: 0%;color:green;" <b style="color:green;" onclick="sku_show(\'SKU状态\',\'{{url("admin/kind/sku_show")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')">正常</b></button></span>';--}}
{{--}else if(data.goods_kind_sku_status==1){--}}
{{--var sku='<span class="l"><button type="button"  class="btn btn-primary-outline radius" style="border-radius: 0%;color:#ccc;" <b style="color:#ccc;" onclick="sku_show(\'SKU状态\',\'{{url("admin/kind/sku_show")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')">已释放</b></button></span>';--}}
{{--info='<span class="l"><button type="button"  class="btn btn-primary-outline radius" style="border-radius: 0%;color:#ccc;" <b style="color:#ccc;" onclick="sku_show(\'SKU状态\',\'{{url("admin/kind/sku_show")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')">已释放</b></button></span>';--}}
{{--}else if(data.goods_kind_sku_status==2){--}}
{{--var sku='<span class="l"><button type="button"  class="btn btn-primary-outline radius" style="border-radius: 0%;color:brown;" <b style="color:brown;" onclick="sku_show(\'SKU状态\',\'{{url("admin/kind/sku_show")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')">重用SKU</b></button></span>';--}}
{{--}--}}
{{--$(row).find('td:eq(12)').html(info);--}}
{{--$(row).find('td:eq(10)').html(sku);--}}
{{--$(row).find('td:eq(7)').html(data.goods_buy_weight + 'kg');--}}
{{--$(row).find('td:eq(5)').html(check);--}}
{{--$(row).find('td:eq(6)').html(num);--}}
{{--$(row).find('td:eq(3)').html(img);--}}
{{--$(row).addClass('text-c');--}}

{{--}--}}
{{--};--}}
{{--dataTable =$('#goods_index_table').DataTable($.tablesetting);--}}
{{--function del_goods(id){--}}
{{--var msg =confirm("确定要删除此产品吗？");--}}
{{--if(msg){--}}
{{--layer.msg('删除中');--}}
{{--$.ajax({--}}
{{--url:"{{url('admin/kind/delkind')}}",--}}
{{--type:'get',--}}
{{--data:{'id':id},--}}
{{--datatype:'json',--}}
{{--success:function(msg){--}}
{{--if(msg['err']==1){--}}
{{--layer.msg(msg.str);--}}
{{--$('#goods_index_table').dataTable().fnClearTable();--}}
{{--}else if(msg['err']==0){--}}
{{--layer.msg(msg.str);--}}
{{--}else{--}}
{{--layer.msg('删除失败！');--}}
{{--}--}}
{{--}--}}
{{--})--}}
{{--}else{--}}

{{--}--}}
{{--}--}}
{{--//释放产品SKU--}}
{{--function del_sku(id){--}}
{{--var msg =confirm("确定要释放此产品SKU吗？！！一旦释放无法恢复，请确定此产品不再使用！！！");--}}
{{--if(msg){--}}
{{--msg_again=confirm('已确定？');--}}
{{--}else{--}}
{{--return;--}}
{{--}--}}
{{--if(msg_again){--}}
{{--layer.msg('释放中，请不要进行其它操作');--}}
{{--$.ajax({--}}
{{--url:"{{url('admin/kind/del_sku')}}",--}}
{{--type:'get',--}}
{{--data:{'id':id},--}}
{{--datatype:'json',--}}
{{--success:function(msg){--}}
{{--if(msg['err']==1){--}}
{{--layer.msg(msg.str);--}}
{{--$('#goods_index_table').dataTable().fnClearTable();--}}
{{--}else if(msg['err']==0){--}}
{{--layer.msg(msg.str);--}}
{{--}else{--}}
{{--layer.msg('释放失败！');--}}
{{--}--}}
{{--}--}}
{{--})--}}
{{--}else{--}}

{{--}--}}
{{--}--}}
{{--//跳转到商品列表页--}}
{{--function  goods_info(url,num)--}}
{{--{--}}
{{--if(num == 0){--}}
{{--layer.msg('该产品无商品绑定');--}}
{{--}else{--}}
{{--window.location.href = url;--}}
{{--}--}}
{{--}--}}
{{--//产品按照分类搜索--}}
{{--$('#product_type_id').on('change',function(){--}}
{{--$('#goods_index_table').dataTable().fnClearTable();--}}
{{--});--}}
{{--//产品按照时间搜索--}}
{{--$('#seavis1').on('click',function(){--}}
{{--$('#goods_index_table').dataTable().fnClearTable();--}}

{{--});--}}
{{--//产品导出表格--}}
{{--$('#outorder').on('click',function(){--}}
{{--var url='{{url("admin/kind/outkind")}}'+'?';--}}
{{--//日期参数--}}
{{--var mintime=$('#datemin').val();--}}
{{--var maxtime=$('#datemax').val();--}}
{{--is_time = false;--}}
{{--//产品分类参数--}}
{{--var product_type_id=$('#product_type_id').val();--}}
{{--var urls = '';--}}
{{--if(mintime&&maxtime) {--}}
{{--is_time=true;--}}
{{--url+='min='+mintime+'&max='+maxtime;--}}
{{--}--}}
{{--if(product_type_id>=0) {--}}
{{--if(is_time){--}}
{{--url+='&product_type_id='+product_type_id;--}}
{{--}else{--}}
{{--url+='product_type_id='+product_type_id;--}}
{{--}--}}
{{--}else{--}}
{{--if(is_time){--}}
{{--url+='&product_type_id=0';--}}
{{--}else{--}}
{{--url+='product_type_id=0';--}}
{{--}--}}
{{--}--}}
{{--layer.msg('请稍等');--}}
{{--location.href= url;--}}
{{--});--}}
{{--//新增产品--}}
{{--$('#addgoods_kind').on('click',function(){--}}
{{--layer_show('产品添加','{{url("admin/kind/addkind")}}',1400,800);--}}
{{--});--}}
{{--function layer_img(src){--}}
{{--$('#img').attr('src',src);--}}
{{--layer.open({--}}
{{--type: 1,--}}
{{--title: false,--}}
{{--closeBtn: 0,--}}
{{--content: '浏览器滚动条已锁',--}}
{{--scrollbar: false,--}}
{{--shadeClose: true,--}}
{{--//area: '516px',--}}
{{--area: ['800px'],--}}
{{--skin: 'layui-layer-nobg', //没有背景色--}}
{{--shadeClose: true,--}}
{{--content: $('#img')--}}
{{--});--}}
{{--}--}}
{{--//产品详情--}}
{{--function goods_show(title,url,type,w,h){--}}
{{--layer_show(title,url,w,h);--}}
{{--}--}}
{{--//SKU绑定状态--}}
{{--function sku_show(title,url,type,w,h){--}}
{{--layer_show(title,url,w,h);--}}
{{--}--}}
{{--</script>--}}
{{--@endsection--}}


@extends('storage.father.static')
@section('content')
    <style>
        .laytable-cell-1-0-3, .laytable-cell-1-0-5, .laytable-cell-1-0-8, .laytable-cell-1-0-10 { /*最后的pic为字段的field*/
            height: 100%;
            max-width: 100%;
        }
    </style>
{{--表格插入图片--}}
    <img src="" id="show_big" width="100%" style="display: none">
<script type="text/html" id="test-table-switchTpl">
    <img src="/@{{ d.goods_kind_img }}" onclick="show_kind_img('产品图片','/@{{d.goods_kind_img}}')" width="50px" alt="产品图片" >
</script>
{{--表格属性信息--}}
<script type="text/html" id="test-table-attr">
    <a title="属性详情" href="javascript:;" onclick="goods_show('查看属性详情','{{url("admin/kind/show")}}?id='+ @{{ d.goods_kind_id }},2,600,500)" class="ml-5"><span class="layui-btn layui-btn-radius layui-btn-xs layui-btn-primary" style="background-color:#ccc;color:green;">查看属性详情</span></a>
</script>
{{--表格绑定产品的商品数量--}}
<script type="text/html" id="test-table-num">
    <a title="商品列表" href="javascript:;" onclick="goods_info('{{url("admin/goods/index")}}?id='+@{{d.goods_kind_id}},@{{ d.num }})" class="ml-5"><span class="layui-btn layui-btn-xs" style="background-color:#ccc;color:red;"> @{{d.num}} </span></a>
</script>
<script type="text/html" id="test-table-weight">
    @{{ parseFloat(d.goods_buy_weight) }}kg
</script>
{{--表格绑定产品的商品数量--}}
<script type="text/html" id="test-table-sku">
    @{{# if (d.goods_kind_sku_status=== '0') { }}
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;">
            <b style="color:green;"
               onclick="goods_show('SKU状态','{{url("admin/kind/sku_show")}}?id='+@{{ d.goods_kind_id }},2,1400,800)">正常</b>
        </button>
        @{{# } else if(d.goods_kind_sku_status=== '1') { }}
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;color:#ccc;">
            <b style="color:#f51322;"
               onclick="goods_show('SKU状态','{{url("admin/kind/sku_show")}}?id='+@{{ d.goods_kind_id }},2,1400,800)">已释放</b>
        </button>
        @{{# } else { }}
        <button class="layui-btn layui-btn-primary layui-btn-sm" style="border-radius: 0;color:brown;">
            <b style="color:#3a87ad;"
               onclick="goods_show('SKU状态','{{url("admin/kind/sku_show")}}?id='+@{{ d.goods_kind_id }},2,1400,800)">重用SKU</b>
        </button>
        @{{# } }}
    </script>


    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">产品列表</div>
                    <div class="layui-row">
                        {{--<div class="layui-col-md6">--}}
                        {{--<div class="layui-inline">--}}
                        {{--<label class="layui-form-label">日期范围：</label>--}}
                        {{--<div class="layui-input-inline">--}}
                        {{--<input type="text" class="layui-input" id="test-laydate-start" placeholder="开始日期">--}}
                        {{--</div>--}}
                        {{--<div class="layui-form-mid">--}}
                        {{-----}}
                        {{--</div>--}}
                        {{--<div class="layui-input-inline">--}}
                        {{--<input type="text" class="layui-input" id="test-laydate-end" placeholder="结束日期">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<span style="color: red">选择时间应该在10天内,时间不选择默认为近10天</span>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                            <div class="layui-form-item">
                                <div class="layui-inline test-table-reload-btn">
                                    <button class="layui-btn" id="addgoods_kind">新增产品</button>
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
                        <div class="layui-card-body">
                            <table class="" id="test-table-operate" lay-filter="test-table-operates"></table>
                            <script type="text/html" id="test-table-operate-barDemo">
                                <a class="layui-btn layui-btn-xs" title="修改产品属性" lay-event="edit"><i class="layui-icon">&#xe642;</i></a>
                                <a class="layui-btn layui-btn-danger layui-btn-xs" title="删除产品" lay-event="del"><i
                                            class="layui-icon">&#xe640;</i></a>
                                @{{# if(d.goods_kind_sku_status != 1){ }}
                                <a class="layui-btn layui-btn-normal layui-btn-xs" title="释放产品SKU"
                                   lay-event="release"><i class="layui-icon">&#xe64f;</i></a>
                                @{{# }else if(d.goods_kind_sku_status === '1'){  }}
                                <a class="layui-btn layui-btn-warm layui-btn-xs" title="已释放产品SKU"><i class="layui-icon">&#xe64f;</i></a>
                                @{{# }  }}
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="/admin/layuiadmin/config.js"></script>
    <script>
        var that = this;
        //var show_kind_img;
        layui.config({
            base: '/admin/layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'table','laytpl','laydate'], function(){
            var table = layui.table
                ,admin = layui.admin;
            var tableObj = table.render({
                elem: '#test-table-operate'
                ,url: "{{url('admin/kind/get_table')}}"
                ,method:'post'
                ,headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
                ,cols: [[
                    {field:'goods_kind_id',width:70, title: 'ID', sort: true}
                    ,{field:'goods_kind_name', title: '产品名'}
                    ,{field:'goods_kind_english_name', title: '产品英文名'}
                    ,{field:'goods_kind_img', title: '产品图片',align:'center', templet: '#test-table-switchTpl'}
                    ,{field:'product_type_name',width:90, title: '单品分类'}
                    ,{title:'属性', align:'center',width:140, templet: '#test-table-attr'}
                    ,{title:'绑定商品个数',align:'center',width:120, templet: '#test-table-num'}
                    ,{field:'goods_buy_weight'+'kg',width: 100,align:'center',title: '产品重量',templet: '#test-table-weight'}
                    ,{field:'goods_kind_volume',width: 140,align:'center',title: '产品体积'}
                    ,{field:'goods_kind_postage',align:'center',width: 100,title: '邮费'}
                    ,{title: 'SKU绑定状态',align:'center',width: 120,templet: '#test-table-sku'}
                    ,{field:'goods_kind_time',width: 160,align:'center', title: '添加时间'}
                    ,{width:150, align:'center', title: '操作', toolbar: '#test-table-operate-barDemo'}
                ]]
                ,page: true
            });
            //产品图片展示
       show_kind_img= function show_kind_img(name,url)
        {   
            var $=layui.jquery;
            $('#show_big').attr('src',url);
            //console.log($('#show_big').attr('url'));
            layer.open({
                type:1,
                title: false,
                scrollbar: false,
                closeBtn: 0,
                //content: ['浏览器滚动条已锁','no'],
                shadeClose: true,
                  area:'800px',
                  skin: 'layui-layer-nobg', //没有背景色
                  shadeClose: true,
                  content:$('#show_big')
            })
        }
            //搜索刷新数据
            var $ = layui.$, active = {
                reload: function(){
                    //执行重载
                    tableObj.reload({
                        page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        ,where: {
                            search:$('#test-table-demoReload').val(),
                            product_type_id:$('#product_type_id').val(),
                            min:$('#test-laydate-start').val(),
                            max:$('#test-laydate-end').val(),
                                }
                            });
                        }
                    };

                    //监听工具条（操作动作）
                    table.on('tool(test-table-operates)', function (obj) {
                        var data = obj.data;
                        if (obj.event === 'del') {
                            //删除产品
                            var msg = confirm("确定要删除此产品吗？");
                            if (msg) {
                                layer.msg('删除中');
                                $.ajax({
                                    url: "{{url('admin/kind/delkind')}}",
                                    type: 'get',
                                    data: {'id': data.goods_kind_id},
                                    datatype: 'json',
                                    success: function (msg) {
                                        if (msg['err'] == 1) {
                                            layer.msg(msg.str);
                                            //执行重载
                                            tableObj.reload({
                                                page: {
                                                    curr: 1 //重新从第 1 页开始
                                                }
                                                , where: {
                                                    search: $('#test-table-demoReload').val(),
                                                    product_type_id: $('#product_type_id').val(),
                                                    min: $('#test-laydate-start').val(),
                                                    max: $('#test-laydate-end').val(),
                                                }
                                            });
                                        } else if (msg['err'] == 0) {
                                            layer.msg(msg.str);
                                        } else {
                                            layer.msg('删除失败！');
                                        }
                                    }
                                })
                            }
                        } else if (obj.event === 'edit') {
                            //修改产品
                            that.goods_show('修改产品属性', '{{url("admin/kind/upgoods_kind")}}?id=' + data.goods_kind_id, 2, 1400, 800);
                        } else if (obj.event === 'release') {
                            //释放sku
                            var msg = confirm("确定要释放此产品SKU吗？！！一旦释放无法恢复，请确定此产品不再使用！！！");
                            if (msg) {
                                msg_again = confirm('已确定？');
                            } else {
                                return;
                            }
                            if (msg_again) {
                                layer.msg('释放中，请不要进行其它操作');
                                $.ajax({
                                    url: "{{url('admin/kind/del_sku')}}",
                                    type: 'get',
                                    data: {'id': data.goods_kind_id},
                                    datatype: 'json',
                                    success: function (msg) {
                                        if (msg['err'] == 1) {
                                            layer.msg(msg.str);
                                            //执行重载
                                            tableObj.reload({
                                                page: {
                                                    curr: 1 //重新从第 1 页开始
                                                }
                                                , where: {
                                                    search: $('#test-table-demoReload').val(),
                                                    product_type_id: $('#product_type_id').val(),
                                                    min: $('#test-laydate-start').val(),
                                                    max: $('#test-laydate-end').val(),
                                                }
                                            });
                                        } else if (msg['err'] == 0) {
                                            layer.msg(msg.str);
                                        } else {
                                            layer.msg('释放失败！');
                                        }
                                    }
                                })
                            }
                        }
                    });

                    //出发搜索事件
                    $('.test-table-reload-btn .layui-btn').on('click', function () {
                        var type = $(this).data('type');
                        active[type] ? active[type].call(this) : '';
                    });

                    //监听排序事件
                    table.on('sort(test-table-operates)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"

                        //尽管我们的 table 自带排序功能，但并没有请求服务端。
                        //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
                        tableObj.reload({
                            initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                            , where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                                field: obj.field //排序字段
                                , order: obj.type //排序方式
                                , search: $('#test-table-demoReload').val() //搜索关键字
                                , product_type_id: $('#product_type_id').val()//产品分类
                                , min: $('#test-laydate-start').val()//开始时间
                                , max: $('#test-laydate-end').val()//结束时间
                            }
                        });
                    });


                    var laydate = layui.laydate;
                    //开始日期
                    var insStart = laydate.render({
                        elem: '#test-laydate-start'
                        , done: function (value, date) {
                            if (value){
                              //更新结束日期的最小日期
                              insEnd.config.min = lay.extend({}, date, {
                                  month: date.month - 1
                              });
                              insEnd.config.max = lay.extend({}, date, {
                                  date: date.date + 10,
                                  month: date.month - 1
                              });
                            } else {
                                insEnd.config.min = '1900-1-1'
                                insEnd.config.max = {    	    		
    	    	                  year:2099,
    	    	                  month:11,//关键
                                  date:31,
                                  hours:0,
                                  minutes:0,
                                  seconds:0
    	                        }
                            }
                            //自动弹出结束日期的选择器
                            insEnd.config.elem[0].focus();
                        }
                    });
                    //结束日期
                    var insEnd = laydate.render({
                        elem: '#test-laydate-end'
                        // ,min: 0
                        , done: function (value, date) {
                            // if(date !== {}){
                            if (value) {
                              //更新开始日期的最大日期
                              insStart.config.max = lay.extend({}, date, {
                                  month: date.month - 1
                              });
                              //更新开始日期的最小日期
                              insStart.config.min = lay.extend({}, date, {
                                  date: date.date - 10,
                                  month: date.month - 1
                              });
                            } else {
                              insStart.config.min = '1900-1-1'
                              insStart.config.max = {    	    		
    	    	                year:2099,
    	    	                month:11,//关键
                                date:31,
                                hours:0,
                                minutes:0,
                                seconds:0
    	                      }
                            }
                        },
                    });

                    //产品导出表格
                    $('#outorder').on('click', function () {
                        var url = '{{url("admin/kind/outkind")}}' + '?';
                        //日期参数
                        var mintime = $('#test-laydate-start').val()//开始时间
                        var maxtime = $('#test-laydate-end').val()//结束时间
                        var search = $('#test-table-demoReload').val() //搜索关键字
                        var is_time = false;
                        //产品分类参数
                        var product_type_id = $('#product_type_id').val();
                        var urls = '';
                        if (mintime && maxtime) {
                            is_time = true;
                            url += 'min=' + mintime + '&max=' + maxtime;
                        }
                        if (product_type_id >= 0) { //产品分类
                            if (is_time) {
                                url += '&product_type_id=' + product_type_id;
                            } else {
                                is_time = true;
                                url += 'product_type_id=' + product_type_id;
                            }
                        } else {
                            if (is_time) {
                                url += '&product_type_id=0';
                            } else {
                                is_time = true;
                                url += 'product_type_id=0';
                            }
                        }
                        if (search) { //单品搜索
                            if (is_time) {
                                url += '&search=' + search;
                            } else {
                                is_time = true;
                                url += 'search=' + search;
                            }
                        }
                        layer.msg('请稍等');
                        location.href = url;
                    });

                    //新增产品
                    $('#addgoods_kind').on('click', function () {
                        that.goods_show('产品添加', '{{url("admin/kind/addkind")}}',2,1400,800);
                    });
                });

                //产品详情,SKU绑定状态
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


           /* //结束日期
            var insEnd = laydate.render({
                elem: '#test-laydate-end'
                // ,min: 0
                ,done: function(value, date){
                    // if(date !== {}){
                        //更新开始日期的最大日期
                        insStart.config.max = lay.extend({}, date, {
                            month: date.month - 1
                        });
                        //更新开始日期的最小日期
                        insStart.config.min = lay.extend({}, date, {
                            date: date.date - 10,
                            month: date.month - 1
                        });
                    // }else{
                    //     var myDate = new Date();
                    //     date.year = myDate.getFullYear();
                    //     date.month = myDate.getMonth();
                    //     date.date = myDate.getDate();
                    //     //更新结束日期的最小日期
                    //     insStart.config.max = lay.extend({}, date, {
                    //         date: date.date,
                    //         month: date.month
                    //     });
                    // }
                    // console.log(JSON.stringify(date));
                },
            });*/




                //跳转到商品列表页
                function goods_info(url, num) {
                    if (num == 0) {
                        layer.msg('该产品无商品绑定');
                    } else {
                        window.location.href = url;
                    }
                }
        //跳转到商品列表页
        function  goods_info(url,num)
        {
            if(num == 0){
                layer.msg('该产品无商品绑定');
            }else{
                window.location.href = url;
            }
        }
        
       /*  function layer_img(src){
            $('#img').attr('src',src);
            layer.open({
              type: 1,
              title: false,
              closeBtn: 0,
              content: '浏览器滚动条已锁',
              scrollbar: false,
              shadeClose: true,
              //area: '516px',
              area: ['800px'],
              skin: 'layui-layer-nobg', //没有背景色
              shadeClose: true,
              content: $('#img')
            });
       }*/
    </script>
@endsection