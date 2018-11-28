@extends('admin.father.css')
@section('content')
    <div class="page-container">

        <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
		<button type="submit" class="btn btn-success" style="border-radius: 8%;" id="outgoods" name=""><i
                    class="Hui-iconfont">&#xe640;</i> 数据导出</button>
		<button type="button" class="btn btn-secondary radius" style="border-radius: 8%;" id="addgoods" name=""><i
                    class="Hui-iconfont">&#xe61f;</i> 数据导出</button>
		<button type="button" class="btn btn-warning radius" style="border-radius: 8%;" id="addgoods_type" name=""><i
                    class="Hui-iconfont">&#xe61f;</i> 进货</button></div>
        <br>
        <div style="width: 100%;">
            <div style="margin-bottom: 20px" class="row cl">
                <label class="form-label col-xs-1 col-sm-1">国家：</label>
                <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="template_type_id" id="template_type_id" class="select">
					<option value="">所有</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->template_type_id }}">{{ $template->template_type_country }}</option>
                    @endforeach
				</select>
				</span>
                </div>
                <label class="form-label col-xs-1 col-sm-1">是否本地仓库：</label>
                <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="is_local" id="is_local" class="select">
                    <option value="">所有</option>
					<option value="0">是</option>
					<option value="1">否</option>
				</select>
				</span>
                </div>
                <label class="form-label col-xs-1 col-sm-1">仓库状态：</label>
                <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="storage_status" id="storage_status" class="select">
                    <option value="">所有</option>
					<option value="0">无效</option>
					<option value="1">有效</option>
				</select>
				</span>
                </div>
                {{--<div style="margin-bottom: 20px" class="row cl">--}}
                {{--<label class="form-label col-xs-1 col-sm-1">产品名称：</label>--}}
                {{--<div class="formControls col-xs-2 col-sm-2"> <span class="select-box">--}}
                {{--<select name="goods_kind" id="goods_kind" class="select">--}}
                {{--<option value="0">所有</option>--}}
                {{--</select>--}}
                {{--</span> </div>--}}
                <br/></div>


            <table class="table table-border table-bordered table-bg" id="storage_index_table">
                <thead>
                <tr>
                    <th scope="col" colspan="14">仓库列表</th>
                </tr>
                <tr class="text-c">
                    <th width="25"><input type="checkbox" name="" value=""></th>
                    <th width="240">编号</th>
                    <th width="210">仓库名</th>
                    <th width="210">地区</th>
                    <th width="170">海外</th>
                    <th width="170">状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')

    <script type="text/javascript">
        $.tablesetting = {
            "lengthMenu": [[10, 20], [10, 20]],
            "paging": true,
            "info": true,
            "searching": true,
            "ordering": true,
            "order": [[1, "desc"]],
            "stateSave": false,
            "columnDefs": [{
                "targets": [0, 2, 3, 4, 5],
                "orderable": false
            }],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "data": {
                    template_type_id: function () {
                        return $('#template_type_id').val()
                    },
                    is_local: function () {
                        return $('#is_local').val()
                    },
                },
                "url": "{{url('admin/storage/get_table')}}",
                "type": "GET",
                'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            },
            "columns": [
                {'defaultContent': "", "className": "td-manager"},
                {"data": 'storage_id'},
                {'data': 'storage_name'},
                {'data': 'storage_name'},
                {'data': 'is_local'},
                {'data': 'storage_status'},
                {'defaultContent': "", "className": "td-manager"},
            ],
            "createdRow": function (row, data, dataIndex) {
                var info = '<a title="查看产品列表" href="javascript:;" onclick="kind_list(' + data.storage_id + ')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="查看产品列表"><i class="Hui-iconfont Hui-iconfont-copy"></i></span></a><a title="编辑" href="javascript:;" onclick="goods_update(\'商品编辑\',\'{{url("admin/goods/chgoods")}}?id=' + data.goods_id + '\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除" href="javascript:;" onclick="del_goods(\'' + data.goods_id + '\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
                var is_local = data.is_local == 1 ? '本地' : '海外';
                $(row).find('td:eq(6)').html(info);
                $(row).find('td:eq(4)').html(is_local);
                $(row).find('td:eq(5)').html(data.storage_status == 1 ? '有效' : '<span class="label label-default radius" style="color:red;">无效</span>');
                $(row).addClass('text-c');
            }
        }
        dataTable = $('#storage_index_table').DataTable($.tablesetting);
        $('#seavis2').on('click', function () {
            $('#storage_index_table').dataTable().fnClearTable();
        });
        $('#template_type_id').on('change', function () {
            $('#storage_index_table').dataTable().fnClearTable();
        });
        $('#is_local').on('change', function () {
            $('#storage_index_table').dataTable().fnClearTable();
        });
        $('#storage_status').on('change', function () {
            $('#storage_index_table').dataTable().fnClearTable();
        });
        function del_goods(id) {
            var msg = confirm("确定要删除此商品吗？");
            if (msg) {
                layer.msg('删除中');
                $.ajax({
                    url: "{{url('admin/goods/delgoods')}}",
                    type: 'get',
                    data: {'id': id},
                    datatype: 'json',
                    success: function (msg) {
                        if (msg['err'] == 1) {
                            layer.msg(msg.str);
                            $('#storage_index_table').dataTable().fnClearTable();
                        } else if (msg['err'] == 0) {
                            layer.msg(msg.str);
                        } else {
                            layer.msg('删除失败！');
                        }
                    }
                })
            } else {

            }
        }

        function goods_online(id) {
            var msg = confirm("确定要启用此商品吗？");
            if (msg) {
                layer.msg('启用中');
                $.ajax({
                    url: "{{url('admin/goods/online')}}",
                    type: 'get',
                    data: {'id': id},
                    datatype: 'json',
                    success: function (msg) {
                        if (msg['err'] == 1) {
                            layer.msg(msg.str);
                            $('#storage_index_table').dataTable().fnClearTable();
                        } else if (msg['err'] == 0) {
                            layer.msg(msg.str);
                        } else {
                            layer.msg('启动失败！');
                        }
                    }
                })

            } else {

            }
        }

        function kind_list(id) {
            window.location.href = '{{url("/admin/storage/kinds/index")}}?storage_id=' + id;
        }

        function goods_close(id) {
            var msg = confirm("确定要下线此商品吗？");
            if (msg) {
                layer.msg('操作中');
                $.ajax({
                    url: "{{url('admin/goods/close')}}",
                    type: 'get',
                    data: {'id': id},
                    datatype: 'json',
                    success: function (msg) {
                        if (msg['err'] == 1) {
                            layer.msg(msg.str);
                            $('#storage_index_table').dataTable().fnClearTable();
                            /*$(".del"+id).prev("input").remove();
                         $(".del"+id).val('已删除');*/
                        } else if (msg['err'] == 0) {
                            layer.msg(msg.str);
                        } else {
                            layer.msg('下线失败！');
                        }
                    }
                })

            } else {

            }
        }

        $('#outgoods').on('click', function () {
            location.href = '{{url("admin/goods/outgoods")}}';
        })
        $('#addgoods').on('click', function () {
            layer_show('新品添加', '{{url("admin/goods/addgoods")}}', 1400, 800);
        })
        $('#addgoods_type').on('click', function () {
            layer_show('种类添加', '{{url("admin/goods/addgoods_type")}}', 400, 300);
        })
        $('#addgoods_kind').on('click', function () {
            layer_show('产品添加', '{{url("admin/kind/addkind")}}', 600, 500);
        })

        function goods_update(title, url, type, w, h) {
                    @if(\App\goods_check::first()['goods_is_check']==0)
            var msg = confirm("确定要修改此商品吗？将触发核审机制！");
                    @else
            var msg = confirm("确定要修改此商品吗？");
            @endif
            if (msg) {
                layer_show(title, url, w, h);
            }
        }

        function goods_show(title, url, type, w, h) {
            layer_show(title, url, w, h);
        }

        $('#goods_type').on('change', function () {
            var goods_type = $(this).val();
            /*var arr1=new Array();
             arr1['goods_type']=goods_type;console.log(arr1);
            arr1=JSON.stringify( arr1 );*/
            var arr = "{\"goods_type\":\"" + goods_type + "\"}";
            dataTable.search(arr).draw();
        })
    </script>
@endsection