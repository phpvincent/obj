@extends('admin.father.css')
@section('content')
    <div class="page-container">
        <div class="cl pd-5 bk-gray mt-20">
            <div style="width: 100%;">
                <div style="margin-bottom: 20px" class="row cl">
                    <label class="form-label col-xs-1 col-sm-1">短信状态：</label>
                    <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="status" id="status" class="select">
					<option value="all">所有</option>
					<option value="0">发送成功</option>
					<option value="1">发送失败</option>
					<option value="2">接收成功</option>
					<option value="3">接收失败</option>
				</select>
				</span>
                    </div>
                    <label class="form-label col-xs-1 col-sm-1">是否验证码：</label>
                    <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
				<select name="is_captcha" id="is_captcha" class="select">
                    <option value="all">所有</option>
					<option value="0">否</option>
					<option value="1">是</option>
				</select>
				</span>
                    </div>
                    <label class="form-label col-xs-1 col-sm-1">商品模板：</label>
                    <div class="formControls col-xs-2 col-sm-2"> <span class="select-box">
						<select name="goods_blade_type" id="goods_blade_type" class="select">
							<option value="all">所有</option>
							<option value="0">0--台湾模板</option>
						<option value="1">1--简体模板</option>
						<option value="2">2--阿联酋模板</option>
						<option value="3">3--马来西亚模板</option>
						<option value="4">4--泰国模板（旧版）</option>
						<option value="5">5--日本模板（旧版）</option>
						<option value="6">6--印度尼西亚</option>
						<option value="7">7--菲律宾</option>
						<option value="8">8--英国（旧版）</option>
						<option value="9">9--Google-PC（旧版）</option>
						<option value="10">10--美国（旧版）</option>
						<option value="11">11--越南（旧版）</option>
						<option value="12">12--沙特</option>
						<option value="13">13--沙特英文</option>
						<option value="14">14--卡塔尔</option>
						<option value="15">15--卡塔尔英文</option>
						<option value="16">16--中东阿语</option>
						<option value="17">17--中东英语</option>
                            {{--<option value="2">2--无倒计时模板</option>--}}
						</select>
				    </span></div>
                    </div>
                    <div style="margin-bottom: 20px" class="row cl">
                    <label class="form-label col-xs-1 col-sm-1">订单号：</label>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="text" name="order_sn" id="order_sn" class="input-text"></div>
                        <label class="form-label col-xs-1 col-sm-1">手机号：</label>
                        <div class="formControls col-xs-2 col-sm-2">
                        <input type="text" name="phone" id="phone" class="input-text">
                    </div><br/></div>
                <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="pl_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> </span><span class="r">共有数据：<strong>{{$counts}}</strong> 条</span><br> </div>
                <table class="table table-border table-bordered table-bg" id="goods_index_table">
                    <thead>
                    <tr>
                        <th scope="col" colspan="14">短信列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="25"><input type="checkbox" name="" value=""></th>
                        <th width="40">ID</th>
                        <th width="110">电话号码</th>
                        <th width="110">订单号</th>
                        <th width="70">单品名称</th>
                        <th width="70">单品地址</th>
                        <th width="70">单品地区</th>
                        <th width="100">验证码</th>
                        <th width="130">内容</th>
                        <th width="40">状态</th>
                        <th width="100">发布时间</th>
                        <th width="80">备注信息</th>
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
                var checkboxs=[];
                $.tablesetting = {
                    "lengthMenu": [[10, 20], [10, 20]],
                    "paging": true,
                    "info": true,
                    "searching": true,
                    "ordering": true,
                    "order": [[1, "desc"]],
                    "stateSave": false,
                    "columnDefs": [{
                        "targets": [0, 2, 3, 4, 5, 6,7,8,9,11,12],
                        "orderable": false
                    }],
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "data": {
                            phone: function () {
                                return $('#phone').val()
                            },
                            is_captcha: function () {
                                return $('#is_captcha').val()
                            },
                            goods_blade_type: function () {
                                return $('#goods_blade_type').val()
                            },
                            status: function () {
                                return $('#status').val()
                            },
                            order_sn: function () {
                                return $('#order_sn').val()
                            },
                        },
                        "url": "{{url('admin/message/get_table')}}",
                        "type": "POST",
                        'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                    },
                    "columns": [
                        {'defaultContent': "", "className": "td-manager"},
                        {"data": 'message_id'},
                        {'data': 'message_mobile_num'},
                        {'data': 'order_single_id'},
                        {'data': 'goods_name'},
                        //{'data': 'goods_url'},
                        {'defaultContent': "", "className": "td-manager"},
                        {'data': 'goods_blade_type'},
                        {'data': 'messaga_code'},
                        {'data': 'messaga_content'},
                        {'data': 'message_status'},
                        {'data': "message_gettime"},
                        {'data': 'messaga_remark'},
                        {'defaultContent': "", "className": "td-manager"},
                    ],
                    "createdRow": function (row, data, dataIndex) {
                        var status = '';
                        if (data.message_status == 0) {
                            status = '<span style="color:green;">发送成功</span>';
                        } else if (data.message_status == 1) {
                            status = '<span style="color:red;">发送失败</span>';
                        } else if (data.message_status == 2) {
                            status = '<span style="color:green;">接收成功!</span>';
                        } else if (data.message_status == 3) {
                            status = '<span style="color:red;">接收失败!</span>';
                        }
                        var blade_type = '';
                        if(data.goods_blade_type == 0 || data.goods_blade_type == 1){
                            blade_type = '台湾';
                        }else if(data.goods_blade_type == 2){
                            blade_type = '阿联酋'
                        }else if(data.goods_blade_type == 3){
                            blade_type = '马来西亚'
                        }else if(data.goods_blade_type == 4){
                            blade_type = '泰国'
                        }else if(data.goods_blade_type == 5){
                            blade_type = '日本'
                        }else if(data.goods_blade_type == 6){
                            blade_type = '印度尼西亚'
                        }else if(data.goods_blade_type == 7){
                            blade_type = '菲律宾'
                        }else if(data.goods_blade_type == 8 || data.goods_blade_type == 9){
                            blade_type = '英国'
                        }else if(data.goods_blade_type == 10){
                            blade_type = '美国'
                        }else if(data.goods_blade_type == 11){
                            blade_type = '越南'
                        }else if(data.goods_blade_type == 12 || data.goods_blade_type == 13){
                            blade_type = '沙特'
                        }else if(data.goods_blade_type == 14 || data.goods_blade_type == 15){
                            blade_type = '卡塔尔'
                        }else if(data.goods_blade_type == 16 || data.goods_blade_type == 17){
                            blade_type = '中东'
                        }

                        var checkbox='<input type="checkbox" name="aaaa" value="'+data.message_id+'">';
                        var del = '<a title="删除" href="javascript:;" onclick="del_messages(' + data.message_id + ')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
                        if(data.goods_url!=null){
                            var url = "<a href='http://"+data.goods_url+"' target='_blank'>"+data.goods_url+"</a>";
                        }else{
                            var url ='没有数据';
                        }

                        $(row).find('td:eq(12)').html(del);
                        $(row).find('td:eq(9)').html(status);
                        $(row).find('td:eq(5)').html(url);
                        $(row).find('td:eq(6)').html(blade_type);
                        $(row).find('td:eq(0)').html(checkbox);
                        $(row).addClass('text-c');
                    }
                }
                dataTable = $('#goods_index_table').DataTable($.tablesetting);
                $('#status').on('click', function () {
                    $('#goods_index_table').dataTable().fnClearTable();
                });
                $('#is_captcha').on('change', function () {
                    $('#goods_index_table').dataTable().fnClearTable();
                });
                $('#goods_blade_type').on('change', function () {
                    $('#goods_index_table').dataTable().fnClearTable();
                });
                $('#order_sn').on('input', function () {
                    $('#goods_index_table').dataTable().fnClearTable();
                });
                $('#phone').on('input', function () {
                    $('#goods_index_table').dataTable().fnClearTable();
                })
                function del_messages(id){
                    var msg =confirm("确定要删除此短信吗？");
                    if(msg){
                        layer.msg('删除中');
                        $.ajax({
                            url:"{{url('admin/message/delmessages')}}",
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
                function pl_del(){
                    xuanzhe()
                    console.log(checkboxs);
                    var msg =confirm("确定要批量删除这些短信吗？");
                    if(!msg){
                        return false;
                    }
                    var b=[];
                    var a=$('input[type="checkbox"]:checked');
                    if(checkboxs.length==0){
                        layer.msg('无选中项');
                        return false;
                    }
                    console.log(checkboxs);
                    layer.msg('删除中，请稍等!');
                    $.ajax({
                        url:"{{url('admin/message/delmessages')}}",
                        type:'get',
                        data:{'id':checkboxs,'type':'all'},
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


                }
                function xuanzhe(){
                    $(".dataTables_wrapper .table>tbody>.text-c>.td-manager>input[type='checkbox']").each(function(j) {
                        if(!this.checked){
                            var a=checkboxs.indexOf( $(this).val() )
                            if(a>=0){
                                checkboxs.splice( a, 1 );
                            }
                        }
                    });
                    console.log('1:');
                    console.log(checkboxs);
                    $(".dataTables_wrapper .table>tbody>.text-c>.td-manager>input[type='checkbox']").each(function(j) {

                        if(this.checked){
                            var a=checkboxs.indexOf( $(this).val() )
                            if(a<0){
                                checkboxs.push($(this).val());
                            }

                        }

                    });
                    console.log('2:');
                    console.log(checkboxs);
                }
            </script>
@endsection