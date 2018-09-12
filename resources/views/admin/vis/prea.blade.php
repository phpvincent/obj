@extends('admin.father.css')
@section('content')

 <div class="row cl">
		<label class="form-label col-xs-4 col-sm-3" style="color:red;">已屏蔽字段：</label>
		 @foreach($msg->area as $v)
		 @if($v!=''&&$v!=null)
 			&nbsp;&nbsp;&nbsp;<span style="background-color:#ccc;"> &nbsp;{{$v}} &nbsp;</span>	
 			@endif
 		@endforeach
</div>
<br>
<br>
<br>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-3">编辑(请使用字段名+英文键盘下的;为格式编辑)：</label>
		<div class="formControls col-xs-8 col-sm-9">
			<textarea name="" cols="" rows="" id="chvis" class="textarea" dragonfly="true" >{{$msg->pb_ziduan}}</textarea>
			例：河南;北京;郑州;....
			<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
		</div>
	</div>
<br>
<br>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
			<input class="btn btn-primary radius" id="subrea" type="button" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
@endsection
@section('js')
<script type="text/javascript">
	$('#subrea').on('click',function(){
		var msg =confirm("确定要修改屏蔽字段吗？");
		if(msg){
        		layer.msg('修改中');
        			$.ajax({
					url:"{{url('admin/vis/chvis')}}",
					type:'get',
					data:{'msg':$('#chvis').val()},
					datatype:'json',
					success:function(msg){
			           if(msg['err']==1){
			           	 layer.msg(msg.str);
			           	 /*$(".del"+id).prev("input").remove();
        				 $(".del"+id).val('已删除');*/
        				 /*dataTable.fnDestroy(false);
               			 dataTable = $("#goods_index_table").dataTable($.tablesetting);*/
               			 //搜索后跳转到第一页
               			 //dataTable.fnPageChange(0);
               			 location.reload();
			           }else if(msg['err']==0){
			           	 layer.msg(msg.str);
			           }else{
			           	 layer.msg('修改失败！');
			           }
					}
				})
        	}else{
                
        	}
	})
</script>
@endsection