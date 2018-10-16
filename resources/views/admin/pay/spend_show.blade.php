@extends('admin.father.css')
@section('content')
    <style>
        .riqi{
            text-align:center;
        }
        .content {
            padding-top:20px;
        }
        .content .neirong .row{
            margin-bottom:10px;
        }
        .content .neirong label{
            text-align:right;
            padding:0;
        }
        .neirong table{
            width: 100%!important
        }
    </style>
<article class="content">
    <div class="riqi">
        <div>请选择日期</div>
        <div id="date"></div>
        <span id="create_time" style="display: none"></span>
    </div>
    <div class="page-container neirong" style=" ">
        <table class="table table-border table-bordered table-bg" id="pay_index_table">
            <thead>
            <tr>
                <th scope="col" colspan="15">花费详情</th>
            </tr>
            <tr class="text-c">
                <th>花费日期</th>
                <th>投放平台</th>
                <th>钱币种类</th>
                <th>花费金额</th>
                <th>录入方式</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
</article>
@endsection
@section('js')
    <script type="text/javascript">
        // 获取两天前日期
        Date.prototype.format = function (format) {
            var args = {
                "M+": this.getMonth() + 1,
                "d+": this.getDate(),
                "h+": this.getHours(),
                "m+": this.getMinutes(),
                "s+": this.getSeconds(),
                "q+": Math.floor((this.getMonth() + 3) / 3), //quarter

                "S": this.getMilliseconds()
            };
            if (/(y+)/.test(format)) format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
            for (var i in args) {
                var n = args[i];

                if (new RegExp("(" + i + ")").test(format)) format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? n : ("00" + n).substr(("" + n).length));
            }
            return format;
        };
        var curDate = new Date();
        var stringDate = new Date(curDate.getTime() - 48*60*60*1000).format("yyyy-MM-dd");
        $('#create_time').text(stringDate);
        // 表格数据填充
        var id = "{{$id}}";
        $.tablesetting = {
            'paging':false,
            "searching" : false,
            "bSort": false,
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4],
            }],
            "ajax": {
                'data': {
                    time: function(){return $('#create_time').text()},
                    id:id,
                },
                "url": "{{url('admin/pay/get_show_table')}}",
                "type": "POST",
                'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            },
            "columns": [
                {"data": 'spend_time'},
                {"data": 'spend_platform'},
                {"data": 'spend_currency'},
                {"data": 'spend_money'},
                {"data": 'is_impload'},
                {'defaultContent':"","className":"td-manager"},
            ],
            "createdRow":function(row,data,dataIndex){
                var info='<a title="删除花费" href="javascript:;" onclick="del_order(\''+data.spend_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
                $(row).find('td:eq(5)').html(info);
                $(row).addClass('text-c');
            }
        }
        dataTable = $('#pay_index_table').DataTable($.tablesetting);

        // 删除商品花费
        function del_order(id){
            var msg =confirm("确定要删除此商品花费信息吗？");
            if(msg){
                layer.msg('删除中');
                $.ajax({
                    url:"{{url('admin/pay/del_spend')}}",
                    type:'get',
                    data:{'id':id},
                    datatype:'json',
                    success:function(data){
                        if(data.err === 1){
                            layer.msg(data.msg);
                            $('#pay_index_table').dataTable().fnClearTable();
                            $('#pay_index_table').DataTable().ajax.reload();
                        }else if(data.err === 0){
                            layer.msg(data.msg);
                        }else{
                            layer.msg('删除失败！');
                        }
                    }
                })
            }else{

            }
        }

        //选择查看花费时间
        function selectDatediff(a, id, bool){
        //td点击添加背景色；
        setTimeout(() => {
            // console.log($("#date iframe").contents().find(".WdayTable td.WdayOn"))
            $("#date iframe").contents().find(".WdayTable td.WdayOn").attr("onmouseout","this.className='WdayOn'")
            $("#date iframe").contents().find(".WdayTable td.WwdayOn").attr("onmouseout","this.className='WdayOn'")
                        }, 30);
            if(!bool){
                layer.msg('抱歉，暂时未到录入花费时间');
                return false;
            }
            $('#create_time').text(a);
            // $(".riqi").hide(400);
            $(".content .neirong").show(400);
            $('#pay_index_table').dataTable().fnClearTable();
            $('#pay_index_table').DataTable().ajax.reload();
            // $('#pay_index_table').dataTable().ajax.reload();
        }
        layer.load(1 ,{shade: [0.15, '#393D49']});
            $.ajax({
                url: "{{url('admin/pay/spend_entry')}}",
                type: 'get',
                data: {'id': id},
                datatype: 'json',
                success: function (data) {
                    if (data.err === '1') {
                        var c = data.spend_entry;
                            WdatePicker({
                                eCont: 'date', onpicked: function (dp) {
                                    selectDatediff(dp.cal.getDateStr(), id, data.bool);
                                }, specialDates: c, maxDate: '%y-%M-#{%d-2}', minDate: data.goods_up_time
                            })
                           //默认日期选中，背景色；
                           setTimeout(() => {
                               $("#date iframe").contents().find(".WdayTable td.WspecialDay:last").attr({onmouseout:"this.className='WdayOn'",class:'WdayOn'})
                           },100)
                    } else {
                        window.location = window.location;
                    }
                    layer.closeAll('loading');
                }
            })
        //操作按钮函数
        function goods_getaddr(title,url,type,w,h){
            layer_show(title,url,w,h);
        }
    </script>

@endsection