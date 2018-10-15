@extends('admin.father.css')
@section('content')
<style>
    .riqi{
        text-align:center;
        position: absolute;
        right: 70px;
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
    .WdateDiv .Wselday{
        background-color: #222!important;
        color: #fff;
    }
    
</style>
<article class="content">
    <div style="color: #f51322;font-size: 14px;margin: 0 auto;width: 600px;">注意：日历中红色方块为尚未录入花费信息日期，记录花费起始日期为商品添加日期,只可添加2日前花费</div>
    <form class="form form-horizontal" id="spend-add" enctype="multipart/form-data" action="{{url('admin/pay/add_spend')}}" method="post">
        {{csrf_field()}}
        <div class="riqi">
            <div>请选择日期</div>
            <div id="date"></div>
        </div>
        
        <div style="" class="neirong">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">产生花费日期：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <input type="hidden" class="input-text"  placeholder="" id="order_send" name="create_time">
                    <span class="riqi_zhanshi"></span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">花费平台：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <div class="select-box" >
                        <select name="spend_platform" id="admin_name" class="select" >
                            <option value="1">雅虎</option>
                            <option value="2" >谷歌</option>
                            <option value="3" selected >FB</option>
                        </select>
					</div> 
                </div>
            </div>
            
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">钱币种类：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <span class="select-box">
                        <select name="spend_currency_id" id="" class="select">
                            @foreach($currency_type as $item)
                            <option value="{{ $item->currency_type_id }}">{{ $item->currency_type_name }}</option>
                            @endforeach
                        </select>
					</span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">花费金额：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <input type="text" class="input-text"  placeholder="" id="spend_money" name="spend_money">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <text id="submit_status" style="display:none;"></text>
                    <button class="btn btn-primary radius" id="button1" onclick="submintStatus(1)" type="button"><i class="Hui-iconfont"></i> 提交并继续录入</button>
                    <button class="btn btn-primary radius" id="button0" onclick="submintStatus(0)" type="button"><i class="Hui-iconfont"></i> 提交</button>
                </div>
            </div>
            {{--商品id--}}
            <input type="hidden" id="spend_goods_id" name="spend_goods_id" value="{{$id}}">
            {{--表单提交状态：1：提交并继续录入；0：提交--}}
            <input type="hidden" id="goods_status" name="goods_status" value="">
            {{--商品是否在可以录入花费周期内；true：在 false：不在--}}
            <text id="bool" style="display: none"></text>
            {{--是否为超级管理员--}}
            <text id="is_root" style="display: none">{{ Auth::user()->is_root }}</text>
        </div>
    </form>
    {{--table表格--}}
    @if(Auth::user()->is_root == 1)
        <div class="page-container neirong">
            <table class="table table-border table-bordered table-bg" id="pay_index_table">
                <thead>
                <tr>
                    <th scope="col" colspan="15">花费详情</th>
                </tr>
                <tr class="text-c">
                    <th>花费日期</th>
                    <th>花费平台</th>
                    <th>钱币种类</th>
                    <th>花费金额</th>
                    <th>录入方式</th>
                    <th>录入人</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    @else
        <div class="page-container neirong">
            <table class="table table-border table-bordered table-bg" id="pay_index_table">
                <thead>
                <tr>
                    <th scope="col" colspan="15">花费详情</th>
                </tr>
                <tr class="text-c">
                    <th>花费日期</th>
                    <th>花费平台</th>
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
    @endif
</article>

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
    $('#order_send').val(stringDate);
    $(".riqi_zhanshi").text(stringDate);
    //加载完成事件
    var id = "{{$id}}";
    var is_root = $('#is_root').text();

    if(is_root == 1){
        $.tablesetting = {
            'paging':false,
            "searching" : false,
            "bSort": false,
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5],
            }],
            "ajax": {
                "data":{
                    id:id,
                    time:function(){return $(".riqi_zhanshi").text()},
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
                {"data": 'spend_author_id'},
                {'defaultContent':"","className":"td-manager"},
            ],
            "createdRow":function(row,data,dataIndex){
                var info='<a title="删除花费" href="javascript:;" onclick="del_order(\''+data.spend_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a>';
                $(row).find('td:eq(6)').html(info);
                $(row).addClass('text-c');
            }
        }
    }else{
        $.tablesetting = {
            'paging':false,
            "searching" : false,
            "bSort": false,
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4],
            }],
            "ajax": {
                "data":{
                    id:id,
                    time:function(){return $(".riqi_zhanshi").text()},
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
    }


    dataTable = $('#pay_index_table').DataTable($.tablesetting);
    //日历数据
    layer.load(1 ,{shade: [0.15, '#393D49']});
    $.ajax({
        url: "{{url('admin/pay/spend_entry')}}",
        type: 'get',
        data: {'id': id},
        datatype: 'json',
        success: function (data) {

            if (data.err === '1') {
                var c = data.spend_entry;
                $('#bool').text(data.bool);
                WdatePicker({
                    eCont: 'date',
                    onpicked: function (dp) {  
                             
                        selectDatediff(dp.cal.getDateStr(), id, data.bool,dp);
                    },
                     specialDates: c,
                      maxDate: '%y-%M-#{%d-2}',
                       minDate: data.goods_up_time
                })
                
            } else {
                window.location = window.location;
            }
            layer.closeAll('loading');
        }
    })

    //判断提交与提交继续录入
    function submintStatus(a) {
        $('#button1').attr('type','submit');
        $('#button0').attr('type','submit');
        $('#goods_status').val(a);
        $("#spend-add").validate({
            rules:{
                spend_money:{
                    required:true,
                    number:true,
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var create_time = $('#order_send').val();
                if(!create_time){
                    layer.msg('请选择花费录入时间！');
                    return false;
                }
                var bool = $('#bool').text();
                if(bool === 'false'){
                    layer.msg('花费产生两日后录入，请查看花费产生时间！');
                    return false;
                };

                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/pay/add_spend')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg(data.msg,{time:2*1000},function() {
                                if($('#goods_status').val() === '0'){
                                    //回调
                                    index = parent.layer.getFrameIndex(window.name);
                                    setTimeout("parent.layer.close(index);",2000);
                                    window.parent.location.reload();
                                }else{
                                    window.location.reload();
                                    $('#spend_money').val('');
                                    $('#pay_index_table').dataTable().fnClearTable();
                                    $('#pay_index_table').DataTable().ajax.reload();
                                }
                            });
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!');
                    }
                });
            }
        });
    }
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
        }
    }

    //选择查看花费时间
    function selectDatediff(a, id, bool,c){
        setTimeout(() => {
            // console.log($("#date iframe").contents().find(".WdayTable td.WdayOn"))
            $("#date iframe").contents().find(".WdayTable td.WdayOn").attr("onmouseout","this.className='WdayOn'")
            $("#date iframe").contents().find(".WdayTable td.WwdayOn").attr("onmouseout","this.className='WdayOn'")
                        }, 30);
      

        if(!bool){
            layer.msg('抱歉，暂时未到录入花费时间');
            return false;
        }
        $(".riqi_zhanshi").text(a);
        $("#order_send").val(a);
        $('#pay_index_table').dataTable().fnClearTable();
        $('#pay_index_table').DataTable().ajax.reload();
    }

    //操作按钮函数
    function goods_getaddr(title,url,type,w,h){
        layer_show(title,url,w,h);
    }

</script>
@endsection
