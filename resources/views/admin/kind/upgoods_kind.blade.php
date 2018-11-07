@extends('admin.father.css')
@section('content')
    <article class="page-container">
        {{--新增产品form--}}
        <div class="row cl">
            <label style="text-align: left;" class="form-label col-xs-4 col-sm-3">产品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
            <input readonly type="text" name="goods_type_chose" id="goods_type_chose" style="display: none"  value="{{$goods_kinds_id}}">
             <div class="select-box">{{$goods_kinds}}</div>
            </div>
        </div>
        <div class="row cl" id="form-goodskind-update">

        </div>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
    $(function () {
        var id=$('#goods_type_chose').val();
        ajax_tables(id);
    });
    //ajax请求属性参数
    function ajax_tables(id){
        $.ajax({
            url:"{{url('admin/kind/post_update')}}",
            type:'get',
            data:{'id':id},
            datatype:'json',
            success:function(msg){
                $('#form-goodskind-update').html(msg);
            }
        })
    }
    $('#goods_kind_id').on('change',function(){
        var id=$(this).val();
        ajax_tables(id);
    })
    </script>
@endsection