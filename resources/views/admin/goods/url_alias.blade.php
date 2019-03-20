@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('/admin/goods/url/alias')}}">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>域名别名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$goods->goods_url_alias}}" placeholder="" id="goods_price" name="goods_url_alias">
                    <input type="text" class="input-text" style="display: none" value="{{$goods->goods_id}}" placeholder="" id="goods_price" name="goods_id">
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
            rules: rules,
            onkeyup: false,
            focusCleanup: true,
            success: "valid",
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('/admin/goods/url/alias')}}",
                    success: function (data) {
                        if(data.err==1){
                            layer.msg(data.str,{time:2*1000},function() {
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
        var rules={
            goods_url_alias:{
                required:true,
                maxlength:15
            },
            goods_id:{
                required: true,
                number:true
            }
        }
    </script>
@endsection