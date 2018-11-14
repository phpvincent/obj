<style>
	.deletes{
		font-size:18px;
		display: inline-block;
    	padding-left: 10px;
		cursor:pointer;
	}
	.site-block {
		padding: 20px;
		border: 1px solid #eee;
	}
	.site-text {
		position: relative;
	}
	.layui-form-item {
		margin-bottom: 15px;
		clear: both;
		*zoom: 1;
	}
	.layui-form-label {
		float: left;
		display: block;
		padding: 9px 15px;
		width: 80px;
		font-weight: 400;
		line-height: 20px;
		text-align: right;
	}
	.layui-input-block {
		 margin-left: 110px;
		 min-height: 36px;
	 }
	.layui-input, .layui-textarea {
		display: block;
		width: 100%;
		padding-left: 10px;
		border-color: #e6e6e6;
	}
	.layui-input, .layui-select, .layui-textarea {
		height: 38px;
		line-height: 1.3;
		line-height: 38px\9;
		border-width: 1px;
		border-style: solid;
		background-color: #fff;
		border-radius: 2px;
		border-color: #e6e6e6;
	}
	.layui-btn {
		display: inline-block;
		height: 38px;
		line-height: 38px;
		padding: 0 18px;
		background-color: #009688;
		color: #fff;
		white-space: nowrap;
		text-align: center;
		font-size: 14px;
		border: none;
		border-radius: 2px;
		cursor: pointer;
	}
	.layui-btn-primary {
		border: 1px solid #C9C9C9;
		background-color: #fff;
		color: #555;
	}
</style>
	<div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; " id="pzhtml">
		<input type="button" class="btn btn-default" value="增加配置项" id="addpz" style="margin-left:18%;" />
		<label class="form-label col-xs-4 col-sm-2"> </label>
		@if($cuxiao!=null)
		@foreach($cuxiao as $key)
		
					<div>
					促销名:<input type="text" style="width: 10%;" class="input-text" value="{{$key->cuxiao_msg}}" placeholder="" id="cuxiao_msg" name="cuxiao_msg[{{$key->cuxiao_id}}]">
					件数:<input type="text" style="width: 10%;" class="input-text" value="{{explode(',',$key->cuxiao_config)[0]}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" id="cuxiao_num" name="cuxiao_num[{{$key->cuxiao_id}}]">
					价格:<input type="text" style="width: 10%;" class="input-text" value="{{explode(',',$key->cuxiao_config)[1]}}" placeholder="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" id="cuxiao_prize" name="cuxiao_prize[{{$key->cuxiao_id}}]">
					赠品:<select name="cuxiao_special[{{$key->cuxiao_id}}]" class="select slectchange"  style="width:30%;" id="slectchange1" onchange="add_giveaway(this)">
							<option value="0" >无</option>
								@foreach(\App\price::get() as $v)
							<option value="{{$v->price_id}}"';@if($v->price_id==$key->special_price_id) selected="selected" style="float:right;" @endif  >{{$v->price_name}}</option>
								@endforeach
							<option value="-1">添加赠品</option>
						</select>
						<span class="deletes"><i class="Hui-iconfont"></i></span>
					</div>
		
		@endforeach
		@else
		<div>促销名:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_msg" name="new_cuxiao[0][msg]">
			件数:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" placeholder="" id="cuxiao_num" name="new_cuxiao[0][num]">
			价格:<input type="text" style="width: 10%;" class="input-text" value="" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d*\.?\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" placeholder="" id="goods_end2" name="new_cuxiao[0][price]">
			赠品:<select name="new_cuxiao[0][free]" class="select slectchange" style="width:30%;" id="slectchange1" onchange="add_giveaway(this)">
				<option value="0" >无</option>
				@foreach(\App\price::get() as $v)
					<option value="{{$v->price_id}}">{{$v->price_name}}</option>
				@endforeach
				<option value="-1">添加赠品</option>
			</select>
			<span class="deletes"><i class="Hui-iconfont"></i></span></div>
		@endif
	</div>
	<div style="display: none" id="hidden_div">
		<div>促销名:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="cuxiao_msg" name="new_cuxiao[0][msg]" disabled="disabled">
			件数:<input type="text" style="width: 10%;" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" class="input-text" value="" placeholder="" id="cuxiao_num" name="new_cuxiao[0][num]" disabled="disabled">
			价格:<input type="text" style="width: 10%;" onkeyup="(this.v=function(){this.value=this.value.replace(/^\\D*([0-9]\\d*\\.?\\d{0,2})?.*$/,'$1');}).call(this)" onblur="this.v();" class="input-text" value="" placeholder="" id="goods_end2" name="new_cuxiao[0][price]" disabled="disabled">
			赠品:<select name="new_cuxiao[0][free]" class="select slectchange" style="width:30%;"  onchange="add_giveaway(this)" disabled="disabled">
				<option value="0" >无</option>
				@foreach(\App\price::get() as $v)<option value="{{$v->price_id}}">{{$v->price_name}}</option> @endforeach
				<option value="-1">添加赠品</option>
			</select>
			<span class="deletes"><i class="Hui-iconfont"></i></span></div>
	</div>

<script type="text/javascript">
	$('#addpz').on('click',function(){

	})
	$('.slectchange').on('change',function(){
					if($(this).val()!=0){
						$(this).next().removeAttr("disabled");
					}else if($(this).val()==0){
						$(this).next().attr('disabled','true');
					}
				})
	$("#addpz").on("click",function(){
	    var count = $("#pzhtml").children('div').length;
	    var html = $("#hidden_div").html();
        // var reg = new RegExp('disabled="disabled"',"g");//g,表示全部替换。
		html = html.replace(new RegExp('disabled="disabled"',"g"),"");
		html = html.replace(new RegExp('new_cuxiao[0]',"g"), 'new_cuxiao[' + count + ']')
		$("#pzhtml").append(html);
	})
	$('body').on("click",".deletes",function(){
		$(this).parent().remove();
	})
	$('body').on("click", ".lay-submit", function (node) {
	   var name = $("#giveaway_name").val();
	   if (name == null || name == undefined || name == '') {
	       layer.msg('赠品名称不能为空！');
	       return false;
	   }
	   var file =  $('#giveaway_file')[0].files[0];
	   if (file == null || file == undefined || file == '' ) {
	       layer.msg('请上传赠品图片，图片大小不能超过8M！');
           return false;
	   }
        var formFile = new FormData();
        formFile.append("giveaway_file", file);
        formFile.append('giveaway_name', name);
		formFile.append('_token', '{{ csrf_token() }}')
		$.ajax({
			url:'{{url("admin/goods/add_giveaway")}}',
			data:formFile,
			type:'POST',
            dataType:"json",
            contentType: false, // 关关关！必须得 false
            processData: false,
			success:function (data) {
				if (data.err == 1) {
                    $(".slectchange option[value='-1']").remove();
                    $(".slectchange").append("<option value='" + data.data.price_id + "'>"+data.data.price_name + "</option>");
                    $(".slectchange").append("<option value='-1'>添加元素</option>");
                    $(".current_giveaway").val(data.data.price_id)
					console.log( $(".current_giveaway").val())
                    alert(data.str);
                    layer.closeAll();
				} else {
				    alert(data.str);
				}
            }
		})
    });
	// $('body').on("click", '.layui-btn-primary', function () {
	//     console.log(12)
	// 	$(".layui-input").val('');
    // })
	function add_giveaway(node) {
		if(node.value == -1) {
            layer.open({
            	type:1,
            	title:'添加赠品',
                skin: 'demo-class',
                area: ['500px', '300px'],
                fix: false, //不固定
                maxmin: true,
                shade:0.4,
            	content:
				'<html>'+
                    '    <div class="layui-form-item">\n' +
                    '        <label class="layui-form-label">赠品名称</label>\n' +
                    '        <div class="layui-input-block">\n' +
                    '            <input type="text" id="giveaway_name" name="giveaway_name" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="layui-form-item">\n' +
                    '        <label class="layui-form-label">图片</label>\n' +
                    '        <div class="layui-input-block">\n' +
                    '            <input type="file" id="giveaway_file" name="giveaway_file" required lay-verify="required" placeholder="请选择图片" autocomplete="off" class="layui-input">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="layui-form-item">\n' +
                    '        <div class="layui-input-block">\n' +
                    '            <button class="layui-btn lay-submit" lay-filter="formDemo">立即提交</button>\n' +
                    // '            <button type="reset" class="layui-btn layui-btn-primary">重置</button>\n' +
                    '        </div>\n' +
                    '    </div></html>\n'
            });
            $(node).val(0);
            $(".slectchange").removeClass('current_giveaway');
            $(node).addClass('current_giveaway');
		}

    }
</script>
