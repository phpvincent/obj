@extends('admin.father.css')
@section('content')
    <article class="page-container">

        <form class="form form-horizontal" id="order_type_change" action="{{url('admin/order/remarks')}}" method="post">
            <input type="hidden" name="id" id="order_id" value="{{$order->order_id}}">
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-3" style="display: inline-block;text-align: right"><span class="c-red">*</span>订单编号：</label>
                <div class="col-xs-8 col-sm-8">
                    <input type="text" class="input-text" readonly value="{{$order->order_single_id}}" placeholder="" id="order_single_id" name="order_single_id">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-3" style="display: inline-block;text-align: right"><span class="c-red">*</span>备注内容：</label>
                <div class="col-xs-8 col-sm-8">
                    <textarea type="text" class="textarea"  cols="" rows="" placeholder="" id="content" name="content" maxlength="200" dragonfly="true">{{$order->order_service_remarks}}</textarea>
                </div>
            </div>
            {{csrf_field()}}
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;保存备注&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">

        $('#order_type_change').submit(function(){
            var content=$('#content').val();
            // console.log(content.length);
            if(isNull(content)) {
                layer.msg("备注内容不能为空！");
                return false;
            }
            var indexs = layer.load(2, {shade: [0.15, '#393D49']})
            $('#order_type_change').ajaxSubmit({
                type: 'post',
                url: "{{url('admin/order/remarks')}}",
                success: function(data){
                    layer.close(indexs);
                    if(data.msg==0){
                        layer.msg('保存成功!',{time:2*1000},function() {
                            //回调
                            index = parent.layer.getFrameIndex(window.name);
                            setTimeout("parent.layer.close(index);",100);
                            parent.shuaxin();
                        });
                    }else{
                        layer.msg('保存失败!')
                    }
                },
                error: function(XmlHttpRequest, textStatus, errorThrown){
                    layer.close(indexs);
                    layer.msg('error!');
                }
            });
            return false;
        })
        function isNull(data){
            return (data == "" || data == undefined || data == null) ? true: false;
        }
    </script>
@endsection