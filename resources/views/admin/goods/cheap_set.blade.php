@extends('admin.father.css')
@section('content')
<style>
.zhekou,.jianmian{
	display: none;
}
</style>
<article class="page-container">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">货币类型：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  disabled="disabled" value="{{\App\currency_type::where('currency_type_id',\App\goods::where('goods_id',$goods_id)->first(['goods_currency_id'])['goods_currency_id'])->first(['currency_type_name'])['currency_type_name']}}" placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
			<br>
			<br>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">单品定价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"  disabled="disabled" value="{{\App\goods::where('goods_id',$goods_id)->first(['goods_price'])['goods_price']}}" placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
		</div>
		
	<form class="form form-horizontal" id="form-addcheap-add" action="/admin/comment/save_com" method="post">
		{{csrf_field()}}
		<input type="hidden" name="goods_id" value="{{$goods_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>优惠卷类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_cheap_type" class="select">
					<option value="0" selected="selected">立减卷/现金卷</option>
					<option value="1">折扣卷</option>
					<option value="2">减免卷</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl lijian">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>优惠金额：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" onkeyup="this.value=this.value.replace(/[^1-9]*/g,'') "  value="1" placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
		</div>
		<div class="row cl zhekou">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>优惠折扣：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" disabled onkeyup="this.value=this.value.replace(/[^1-9]/g,'') " 
 onafterpaste="this.value=this.value.replace(/[^1-9]/g,'') "maxlength="1"  value="1" placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
		</div>
		<div class="row cl jianmian">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>满足金额：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text"disabled  onafterpaste="this.value=this.value.replace(/[^1-9]/g,'') " value="1" placeholder="" id="articlesort" name="goods_cheap_remark">
			</div>
		</div>
		<div class="row cl" style="">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>生效时间：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<input type="text" class="Wdate" id="d122" name="goods_cheap_start_time" value="2018-10-1 23:00:50" onclick="WdatePicker({isShowWeek:true,readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',onpicked:function() {$dp.$('d122_1').value=$dp.cal.getP('W','W');$dp.$('d122_2').value=$dp.cal.getP('W','WW');}})"/>
			</div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">文章内容：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor" type="text/plain" style="width:100%;height:400px;"></script> 
			</div>
		</div> -->
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button onclick="" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
			</div>
		</div>
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
	Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "H+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
	}
		$('#d122').attr('value',new Date().Format("yyyy-MM-dd HH:mm:ss"));
		$(".select").change(function(){
			// console.log($(this).val())
			var val = $(this).val()
			if(val == 0){
          $(".lijian").show();
          $(".zhekou").hide();
		  $(".zhekou input").attr('disabled',true)
		  $(".lijian input").attr('disabled',false)
		  $(".jianmian input").attr('disabled',true)
          $(".jianmian").hide();
        }else if(val == 1){
			$(".lijian").hide();
          $(".zhekou").show();
          $(".jianmian").hide();
		  $(".zhekou input").attr('disabled',false)
		  $(".lijian input").attr('disabled',true)
		  $(".jianmian input").attr('disabled',true)
        }else if(val ==2){
			$(".lijian").show();
			$(".zhekou").hide();
			$(".jianmian").show();
			$(".zhekou input").attr('disabled',true)
		  $(".lijian input").attr('disabled',false)
		  $(".jianmian input").attr('disabled',false)
		}
      });
	})
	//表单验证
	$("#form-addcheap-add").validate({
		rules:{
			
			goods_cheap_start_time:{
				required:true,
			},
		
		},
		onkeyup:function(element) { $(element).valid(); },
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/goods/cheap/set')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('增加成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",2000);
                        	window.parent.location.reload();
						});
					}else{
						layer.msg('增加失败!'+data.str);
					}
				},
                error: function(XmlHttpRequest, textStatus, errorThrown){
					layer.msg('error!');
				}});
			var index = parent.layer.getFrameIndex(window.name);
			//parent.$('.btn-refresh').click();
			/*parent.layer.close(index);*/
		}
	});
	

</script>
@endsection