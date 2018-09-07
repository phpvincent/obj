@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/copy_goods')}}">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单商品名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="goods_price" name="goods_name">
                    <input type="text" class="input-text" style="display: none" value="{{$id}}" placeholder="" id="goods_price" name="id">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 提交</button>
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        //表单验证
        $("#form-goods-update").validate({
            rules: {
                goods_name: {
                    required: true,
                }
            },
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/goods/copy_goods')}}",
                    success: function (data) {
                        if(data.err==1){
                            layer.msg('复制成功!',{time:2*1000},function() {
                                //回调
                                index = parent.layer.getFrameIndex(window.name);
                                setTimeout("parent.layer.close(index);",2000);
                                window.parent.location.reload();
                            });
                        }else{
                            layer.msg(data.str);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!');
                    }
                });
                   var index = parent.layer.getFrameIndex(window.name);
            }
        })
    </script>
@endsection