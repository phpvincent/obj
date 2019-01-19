@extends('admin.father.css')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="order_type_change" action="{{url('admin/message/send_mail')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>邮箱地址：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" name="send_mail" value="" id="send_mail" class="input-text valid">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>邮件内容：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    {{--<textarea type="text" class="textarea"  cols="" rows="" value="" placeholder="" id="content" name="content"></textarea>--}}
                        <script id="editor2" type="text/plain" name='editor2' style="width:100%;height:400px;"></script>
                    </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-2 col-sm-offset-2">
                    <input class="btn btn-primary size-XL radius" type="submit" value="&nbsp;&nbsp;发&nbsp;送&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
            var editor = UE.getEditor('editor2');

            $('#order_type_change').submit(function(){
            var send_mail= $('#send_mail').val();
            if(isNull(send_mail)||send_mail.length>=40||send_mail.length<=3){
                layer.msg("请填写合法邮箱！");
                return false;
            }
            var indexs = layer.load(2, {shade: [0.15, '#393D49']});
            $('#order_type_change').ajaxSubmit({
                type: 'post',
                url: "{{url('admin/message/send_mail')}}",
                success: function(data){
                    layer.close(indexs);
                    if(data.err===0){
                        layer.msg('发送成功!',{time:2*1000},function() {
                            //回调
                            editor.ready(function() {
                                editor.setContent('');
                            });
                            // $('#editor2').html("");
                            $('#send_mail').val("");
                        });
                    }else{
                        layer.msg(data.str)
                    }
                },
                error: function(XmlHttpRequest, textStatus, errorThrown){
                    layer.close(indexs);
                    layer.msg('error!');
                }
            });
            return false;
        });

        /* 判断数据是否为空 */
        function isNull(data){
            return (data == "" || data == undefined || data == null) ? true: false;
        }

    </script>
@endsection