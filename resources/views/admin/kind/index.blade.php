@extends('admin.father.css')
@section('content')
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">
		<button type="button" class="btn btn-primary-outline radius" style="border-radius: 8%;" id="addgoods_kind" name=""><i class="Hui-iconfont">&#xe61f;</i> 添加新产品</button></span> <span class="r">共有数据：<strong>{{$counts}}</strong> 条</span> </div>
         <label class="form-label col-xs-1 col-sm-1">单品分类：</label>
            <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
                <select name="product_type_id" id="product_type_id" class="select">
                    <option value="0">所有</option>
                    @foreach(\App\product_type::all() as $k => $v)
                    <option value="{{$v->product_type_id}}">{{$v->product_type_name}}</option>
                    @endforeach
                </select>
                </span>
            </div>
    <br>
    </div>
    <table class="table table-border table-bordered table-bg" id="goods_index_table">
        <thead>
        <tr>
            <th scope="col" colspan="14">单品列表</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="110">产品名</th>
            <th width="110">属性</th>
            <th width="110">绑定商品个数</th>
            <th width="110">采购备注</th>
            <th width="110">采购地址</th>
            <th width="70">添加时间</th>
            <th width="100">操作</th>
        </tr>
        </thead>
    </table>
@endsection
@section('js')
    <script type="text/javascript">
        $.tablesetting={
            "lengthMenu": [[10,20],[10,20]],
            "paging": true,
            "info":   true,
            "searching": true,
            "ordering": true,
            "order": [[ 1, "desc" ]],
            "stateSave": false,
            "columnDefs": [{
                "targets": [0,2,3,4,5,6,7],
                "orderable": false
            }],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "data":{
                product_type_id:function(){return $('#product_type_id').val()},
                },
                "url": "{{url('admin/kind/get_table')}}",
                "type": "POST",
                'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            },
            "columns": [
                {'defaultContent':"","className":"td-manager"},
                {"data":'goods_kind_id'},
                {'data':'goods_kind_name'},
                {'defaultContent':"","className":"td-manager"},
                {'defaultContent':"","className":"td-manager"},
                {'data':'goods_buy_msg'},
                {'data':'goods_buy_url'},
                {'data':'goods_kind_time'},
                {'defaultContent':"","className":"td-manager"},
            ],
            "createdRow":function(row,data,dataIndex){
                // {'data':'num'},
                var info='<a title="修改产品属性" href="javascript:;" onclick="goods_show(\'修改产品属性\',\'{{url("admin/kind/upgoods_kind")}}?id='+data.goods_kind_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="修改产品属性"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除产品" href="javascript:;" onclick="del_goods('+data.goods_kind_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除产品"><i class="Hui-iconfont">&#xe6e2;</i></span></a>';
                var check='<a title="属性详情" href="javascript:;" onclick="goods_show(\'查看属性详情\',\'{{url("admin/kind/show")}}?id='+data.goods_kind_id+'\',\'2\',\'600\',\'500\')" class="ml-5"><span class="label label-default radius" style="background-color:#ccc;color:green;">查看属性详情</span></a>';
                var num='<a title="商品列表" href="javascript:;" onclick="goods_info(\'{{url("admin/goods/index")}}?id='+data.goods_kind_id+'\',\''+ data.num + '\')" class="ml-5"><span class="label label-default radius" style="background-color:#ccc;color:red;">'+ data.num +'</span></a>';
                $(row).find('td:eq(8)').html(info);
                $(row).find('td:eq(3)').html(check);
                $(row).find('td:eq(4)').html(num);
                $(row).addClass('text-c');
            }
        };
        dataTable =$('#goods_index_table').DataTable($.tablesetting);
        function del_goods(id){
            var msg =confirm("确定要删除此产品吗？");
            if(msg){
                layer.msg('删除中');
                $.ajax({
                    url:"{{url('admin/kind/delkind')}}",
                    type:'get',
                    data:{'id':id},
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.msg(msg.str);
                            $('#goods_index_table').dataTable().fnClearTable();
                        }else if(msg['err']==0){
                            layer.msg(msg.str);
                        }else{
                            layer.msg('删除失败！');
                        }
                    }
                })
            }else{

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
         $('#product_type_id').on('change',function(){
            $('#goods_index_table').dataTable().fnClearTable();
         });
        //新增产品
        $('#addgoods_kind').on('click',function(){
            layer_show('产品添加','{{url("admin/kind/addkind")}}',1400,800);
        });

        //产品详情
        function goods_show(title,url,type,w,h){
            layer_show(title,url,w,h);
        }
    </script>
@endsection