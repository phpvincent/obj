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
    </style>
<article class="content">
    <div class="riqi">
        <div>请选择日期</div>
        <div id="date"></div>
    </div>
    <div class="page-container neirong" style="display: none">
        <table class="table table-border table-bordered table-bg" id="pay_index_table">
            <thead>
            <tr>
                <th scope="col" colspan="15">花费详情</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="30">花费日期</th>
                <th width="30">投放平台</th>
                <th width="30">钱币种类</th>
                <th width="30">花费金额</th>
                <th width="30">录入方式</th>
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
        function selectDatediff(a,c,id){
            for(var i in c){
                $(".riqi").hide(400);
                $(".content .neirong").show(400);
                $.tablesetting = {
                    "stateSave": false,
                    "columnDefs": [{
                        "targets": [0, 1, 2, 3, 4, 5],
                        "orderable": false
                    }],
                    "ajax": {
                        "url": "{{url('admin/pay/get_show_table')}}",
                        "type": "POST",
                        'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        'data': {'time':a,'id':id}
                    },
                    "columns": [
                        {'defaultContent': "", "className": "td-manager"},
                        {"data": 'spend_time'},
                        {"data": 'spend_platform'},
                        {"data": 'spend_currency'},
                        {"data": 'goods_money'},
                        {"data": 'spend_platform'},
                        {'defaultContent': "", "className": "td-manager"},
                    ],
                }
                dataTable = $('#pay_index_table').DataTable($.tablesetting);
                $('#seavis1').on('click', function () {
                    $('#pay_index_table').dataTable().fnClearTable();
                })
            }
        }
        $(function() {
            var id = "{{$id}}";
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
                                selectDatediff(dp.cal.getDateStr(), c, id);
                            }, specialDates: c, maxDate: '%y-%M-#{%d-2}', minDate: data.goods_up_time
                        })
                    } else {
                        window.location = window.location;
                    }
                }
            })
        })
        //操作按钮函数
        function goods_getaddr(title,url,type,w,h){
            layer_show(title,url,w,h);
        }
    </script>

@endsection