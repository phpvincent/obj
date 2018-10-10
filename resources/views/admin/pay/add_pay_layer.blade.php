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
    <form class="form form-horizontal" id="spend-add" enctype="multipart/form-data" action="{{url('admin/pay/add_spend')}}" method="post">
        {{csrf_field()}}
        <div class="riqi">
            <div>请选择日期</div>
            <div id="date"></div>
            <span class="riqi_zhanshi" style="display: none"></span>
        </div>
        
        <div style="display:none;" class="neirong">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">录入日期：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <input type="hidden" class="input-text"  placeholder="" id="order_send" name="create_time">
                    <span class="riqi_zhanshi"></span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">投放平台：</label>
                <div class="formControls col-xs-6 col-sm-4">
                    <div class="select-box" >
                        <select name="spend_platform" id="admin_name" class="select" >
                            <option value="1">雅虎</option>
                            <option value="2" >谷歌</option>
                            <option value="3" >FB</option>
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
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont"></i> 提交</button>
                </div>
            </div>
            {{--<input type="hidden" name="spend_goods_id" value="">--}}
            <input type="hidden" id="spend_goods_id" name="spend_goods_id" value="{{$id}}">
         <!-- <li  class="date">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>快递单号：</label>
            <input type="text" onfocus="WdatePicker({onpicking:function(dq){selectDatediff(dq.cal.getNewDateStr());},specialDates:['2018-09-21','2018-09-23','2018-09-26','2018-09-27'], dateFmt:'yyyy-MM-dd', maxDate:'%y-%M-%d' })" id="datemin" class="input-text Wdate" style="width:186px;">
         </div> -->
         
        </div>
    </form>
</article>

@section('js')
<script>
    function selectDatediff(a,c){
        for(var i in c){
            console.log(c[i]==a);
            // if(c[i]==a){
                $(".riqi_zhanshi").text(a);
                $("#order_send").val(a);
                $(".riqi").hide(400);
                $(".content .neirong").show(400);
            // }else{
            // }
        }
    }

    $(function(){
        var id = $('#spend_goods_id').val();
        $.ajax({
            url:"{{url('admin/pay/spend_entry')}}",
            type:'get',
            data:{'id':id},
            datatype:'json',
            success:function(data){
                if(data.err === '1'){
                    var c = data.spend_entry;
                    WdatePicker({eCont:'date',onpicked:function(dp){selectDatediff(dp.cal.getDateStr(),c);},specialDates:c, maxDate:'%y-%M-#{%d-2}',minDate:data.goods_up_time})
                }else{
                    window.location = window.location;
                }
            }
        })
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
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/pay/add_spend')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg(data.msg,{time:2*1000},function() {
                                //回调
                                index = parent.layer.getFrameIndex(window.name);
                                setTimeout("parent.layer.close(index);",2000);
                                window.parent.location.reload();
                            });
                        }else{
                            layer.msg(data.msg);
                        }
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!');
                    }});
                // var index = parent.layer.getFrameIndex(window.name);
                //parent.$('.btn-refresh').click();
                /*parent.layer.close(index);*/
            }
        });
    })



</script>
@endsection
