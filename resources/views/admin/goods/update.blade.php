@extends('admin.father.css')
@section('content')
<article class="page-container">
	{{--<div class="config" style="display: none;" id="configclo">--}}
					{{--属性名:<input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="goods_config_name" name="goods_config_name[]">--}}
				{{--属性值（请用英文分号 <font size="5">;</font> 隔开。例：黄色;白色;蓝色;）:<input type="text" style="width: 30%;" class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">--}}
				{{----}}
				{{--</div>--}}
    {{--商品属性信息--}}
    <div class="config" style="display: none;" attr="newConfig" id="configclo">
        <div class="row" style="margin-left: 0px;">
            属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" value="" placeholder="" id="goods_config_name" name="goods_config_name">
			<input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="0" name="num">
		</div>
        <div class="con-value">
            <div class="row" style="height: 40px;" >
                <div class="col-xs-4 col-sm-4" style="display: inline">
                    <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config">
                </div>
                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                    <div class="uploader-thum-container">
                        <input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                    </div>
                </div>
                <div style="display: inline;">
                    <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                </div>
            </div>
        </div>
    </div>
    {{--商品属性值--}}
    <div class="row" style="height: 40px;display: none;"  attr="newConfig" id="configclo-value">
        <div class="col-xs-4 col-sm-4" style="display: inline">
            属性值: <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">
        </div>
        <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
            <div class="uploader-thum-container">
                <input type="file" name="config_imgs[]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
            </div>
        </div>
    </div>

	<form class="form form-horizontal" id="form-goods-update" enctype="multipart/form-data" action="{{url('admin/goods/post_update')}}">
		{{csrf_field()}}
		<input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_name}}" placeholder="" id="goods_name" name="goods_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_real_name}}" placeholder="" id="goods_real_name" name="goods_real_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="goods_msg" cols="" rows="" id="goods_msg" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="$.Huitextarealength(this,200)">{{$goods->goods_msg}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品原价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_real_price}}" placeholder="" id="goods_real_price" name="goods_real_price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品定价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_price}}" placeholder="" id="goods_price" name="goods_price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品促销活动名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_cuxiao_name}}" placeholder="" id="goods_cuxiao_name" name="goods_cuxiao_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>促销类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_cuxiao_type" id="goods_cuxiao_type" class="select">
					<option value="0" @if($goods->goods_cuxiao_type=='0') selected="selected" @endif>单件销售</option>
					<option value="1" @if($goods->goods_cuxiao_type=='1') selected="selected"  @endif>买几送几</option>
					<option value="2" @if($goods->goods_cuxiao_type=='2') selected="selected"  @endif>满件优惠</option>
					<option value="3" @if($goods->goods_cuxiao_type=='3') selected="selected"  @endif>自定义套餐</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模板类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_blade_type" id="goods_blade_type" class="select">
					<option value="0" @if($goods->goods_blade_type=='0') selected="selected" @endif>0--正常模板</option>
					<option value="1" @if($goods->goods_blade_type=='1') selected="selected"  @endif>1--展示模板</option>
					<option value="2" @if($goods->goods_blade_type=='2') selected="selected"  @endif>2--无倒计时模板</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>单品类型：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="goods_type" id="goods_type" class="select">
					@foreach($type as $val)
					<option value="{{$val->goods_type_id}}" @if($goods->goods_type==$val->goods_type_id) selected="selected" @endif>{{$val->goods_type_name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>
		<div class="row cl"	id="cuxiaohtml">
			<!-- <div class="formControls col-xs-8 col-sm-9" >
			</div> -->
		</div>
		@if(\App\goods_config::where('goods_primary_id',$goods->goods_id)->count()<=0)
		<div class="row cl" style="margin-left: 2%">
			<label class="form-label col-xs-4 col-sm-2"> </label>
			<input type="button" class="btn btn-default" value="添加商品附带属性" id="addcon" isalive='off'/>
            <input type="button" class="btn btn-default" style="display: none" value="1" id="num1"/>
        </div>
		{{--<div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; padding: 5px;display: none;" id="conhtml">--}}
			{{--<span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>--}}
				{{--<div class="config">--}}
                    {{--<div>--}}
                        {{--<lable>属性名:</lable> <input type="text" style="width: 10%;" class="input-text" value="" placeholder="" id="goods_config_name" name="goods_config_name[]">--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<lable>属性值:</lable> （请用英文分号 <font size="5">;</font> 隔开。例：黄色;白色;蓝色;）:<input type="text" style="width: 30%;" class="input-text" value="" placeholder="" id="goods_config" name="goods_config[]">--}}
                    {{--</div>--}}
				{{--</div>--}}

		{{--</div>--}}

            <div style="margin:0px auto;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; padding: 5px;display: none;" id="conhtml">
                <span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
                <div class="config" id="configclo">
                    <div class="row" style="margin-left: 0px;">
                        属性名: <input type="text" style="width: 10%;margin-top:10px;" class="input-text attribute" attr='goods_config_name[0][msg]' value="" placeholder="" id="goods_config_name" name="goods_config_name[0][goods_config_name]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="1" name="num">
                    </div>
                    <div class="con-value">
                        <div class="row" style="height: 40px;" >
                            <div class="col-xs-4 col-sm-4" style="display: inline">
                                <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="" placeholder="" id="goods_config" name="goods_config_name[0][msg][0][goods_config]">
                            </div>
                            <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                <div class="uploader-thum-container">
                                    <input type="file" name="goods_config_name[0][msg][0][config_imgs]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                </div>
                            </div>
                            <div style="display: inline;">
                                <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		@else
        {{--商品属性--}}
		<div class="row cl" style="margin-left: 2%">
			<label class="form-label col-xs-4 col-sm-2"> </label>
			{{--<input type="button" class="btn btn-default" value="移除商品附带属性" id="addcon" isalive='on'/>--}}
			<input type="button" class="btn btn-default" style="display: none" value="{{count($goods_config)}}" id="num"/>
		</div>
		<div style="margin:0px auto;margin-bottom:100px;border: 1px dashed #000;border-radius: 3%; width: 73%;margin-left:18%; padding: 5px;" id="conhtml">
			<span class="btn btn-primary" title="添加" id="addconfig"><i class="Hui-iconfont">&#xe600;</i></span><span class="btn btn-primary" id="rmconfig" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span><br>
            @foreach($goods_config as $k=>$v)
				<div class="config">
                    <div class="row" style="margin-left: 0px;">
                        <label for="goods_config_name">属性名:</label> <input type="text" style="width: 10%;margin-top:10px;" attr='goods_config_name[{{$k}}][msg]' class="input-text attribute" value="{{$v->goods_config_msg}}" placeholder="" id="goods_config_name" name="goods_config_name[{{$k}}][goods_config_name]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="{{$v->goods_config_id}}" name="goods_config_name[{{$k}}][id]">
                        <input type="text" style="width: 10%;margin-top:10px;display: none" class="input-text attribute" value="{{count($v->config_msg)}}" name="num">
				    </div>
                    <div id="con-value">
                    @if(count($v->config_msg) > 0)
                        @foreach($v->config_msg as $key=>$item)
                        <div class="row" style="height: 40px;" >
                            <div class="col-xs-4 col-sm-4" style="display: inline">
                                <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text" value="{{$item['config_val_msg']}}" placeholder="" id="goods_config" name="goods_config_name[{{$k}}][msg][{{$key}}][goods_config]">
								<input type="text" style="width: 60%;margin-top:10px;display: none " class="input-text" value="{{$item['config_val_id']}}" name="goods_config_name[{{$k}}][msg][{{$key}}][id]">
							</div>
                            <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                <div class="uploader-thum-container">
                                    <input type="file" name="goods_config_name[{{$k}}][msg][{{$key}}][config_imgs]" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                </div>
							</div>
							@if($key == 0)
                            <div style="display: inline;">
                                <span class="btn btn-primary addconfig-value" style="margin-top:10px; " title="添加" onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                            </div>
							@endif
                        </div>
                        @endforeach
                    @else
                        <div id="con-value">
                            <div class="row" style="height: 40px;" >
                                <div class="col-xs-4 col-sm-4" style="display: inline">
                                    <label>属性值:</label> <input type="text" style="width: 60%;margin-top:10px; " class="input-text attribute" value="" placeholder="" id="goods_config" name="goods_config[]">
                                </div>
                                <div class="formControls col-xs-3 col-sm-3" style="display: inline;">
                                    <div class="uploader-thum-container">
                                        <input type="file" name="config_imgs[]" onclick="uploadFile(this)" width="420" height="280" style="margin-top: 15px;" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
                                    </div>
                                </div>
                                <div style="display: inline;">
                                    <span class="btn btn-primary" style="margin-top:10px; " title="添加"  onclick="addConfig(this)"><i class="Hui-iconfont">&#xe600;</i></span><span style="margin-top:10px; " class="btn btn-primary" onclick="rmConfig(this)" title="删除"><i class="Hui-iconfont">&#xe6a1;</i></span>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif
                    </div>
				</div>
			@endforeach
		</div>
		
		@endif

        <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">附带视频(仅限mp4/mpeg格式)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				@if($goods->goods_video!=''||$goods->goods_video!=null)<video src="/{{$goods->goods_video}}"	controls="" preload="none" width="420" height="280"
		data-setup="{}"></video>@else 	<label class="form-label col-xs-4 col-sm-2">暂无数据</label>@endif
				<input type="file" id="goods_video" class="input-text" value="{{$goods->goods_video}}" placeholder="" id="goods_video" name="goods_video" accept="audio/mp4,video/mp4,video/mpeg,video/mpeg">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否附带视频:</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					是 <input type="radio" id="is_video" class="is_video" name="is_video" @if($goods->goods_video!=null) checked="checked" @endif value="1" >
					否 <input type="radio" id="is_video" class="is_video" name="is_video" @if($goods->goods_video==null) checked="checked" @endif value="0" >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品库存：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_num}}" placeholder="" id="goods_num" name="goods_num">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品倒计时展示：</label>
			<div class="formControls col-xs-8 col-sm-9">
				时:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[0]}}" placeholder="" id="goods_end1" name="goods_end1">
				分:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[1]}}" placeholder="" id="goods_end2" name="goods_end2">
				秒:<input type="text" style="width: 10%;" class="input-text" value="{{explode(':',$goods->goods_end)[2]}}" placeholder="" id="goods_end3" name="goods_end3"><div style="border:2px dashed #ccc;">展示形式:<img src="/images/djs.png"></div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品评论数展示：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_comment_num}}" placeholder="" id="goods_comment_num" name="goods_comment_num">
				<div style="border:2px dashed #ccc;">展示形式:<img src="/images/comm.png"></div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品发布者：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->admin_name}}" disabled placeholder="" id="admin_name" name="admin_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>封面图：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<div class="uploader-thum-container">
					<input type="file" name="fm_imgs[]" width="420" height="280" multiple="multiple"	accept="image/png,image/gif,image/jpg,image/jpeg">
				</div>
			</div>
		</div>
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>对应域名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->url}}"  placeholder="" id="url" name="url">
				正常单品:<input type="checkbox" id="is_zz" name="is_zz" @if($goods->is_zz=='0') checked="checked" @endif value="0" >
				遮罩单品:<input type="checkbox" id="is_zz" name="is_zz" @if($goods->is_zz=='1') checked="checked" @endif value="1" >
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">fb像素(没有则留空)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_pix}}" placeholder="" id="goods_pix" name="goods_pix">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">YaHoo像素(没有则留空)：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_yahoo_pix}}" placeholder="" id="goods_yahoo_pix" name="goods_yahoo_pix">
			</div>
		</div>
	<!-- 	<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">是否上线：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="check-box">
					<input type="checkbox" id="is_online" name="is_online" @if($goods->is_online=='1') checked="checked" @endif value="1" >
					<label for="checkbox-pinglun">&nbsp;</label>
				</div>
			</div>
		</div> -->

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品描述：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor1" type="text/plain" name='editor1' style="width:100%;height:400px;">{!!$goods->goods_des_html!!}</script> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品规格：</label>
			<div class="formControls col-xs-8 col-sm-9"> 
				<script id="editor2" type="text/plain" name='editor2' style="width:100%;height:400px;">{!!$goods->goods_type_html!!}</script> 
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">单品采购地址：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_buy_url}}" placeholder="" id="goods_buy_url" name="goods_buy_url">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">单品采购备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$goods->goods_buy_msg}}" placeholder="" id="goods_buy_msg" name="goods_buy_msg">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
				<!-- <button onClick="article_save();" class="btn btn-secondary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 保存草稿</button>
				<button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button> -->
			</div>
		</div>
		<input type="hidden" name="recheck" value="{{isset($_GET['recheck'])?$_GET['recheck']:0}}">
	</form>
</article>
@endsection
@section('js')
<script type="text/javascript">
    get_cuxiao_html($('#goods_cuxiao_type').val());

	(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
		});

	});

	$('#goods_cuxiao_type').on('change',function(){
		var now=$(this).val();
		get_cuxiao_html(now);
	})
	
	function get_cuxiao_html(now){
			          $('#cuxiaohtml').html('<div  style="margin:0px auto;width:50%;float:right;"><img src="/images/loading.gif"> </div>');
		$.ajax({
					url:"{{url('admin/goods/getcuxiaohtml')}}",
					type:'get',
					data:{'id':now,'goods_id':"{{$goods->goods_id}}"},
					datatype:'json',
					success:function(msg){
			          $('#cuxiaohtml').html(msg);
					}
				})
	}

	//表单验证
	$("#form-goods-update").validate({
		rules:{
			goods_name:{
				required:true,
			},
			goods_real_name:{
				required:true,
			},
			goods_msg:{
				required:true,
			},
			goods_real_price:{
				required:true,
				number:true,
			},
			goods_price:{
				required:true,
				number:true,
			},
			goods_cuxiao_name:{
				required:true,
			},
			goods_num:{
				required:true,
				digits:true,
			},
			goods_end1:{
				required:true,
				digits:true,
			},
			goods_end2:{
				required:true,
				digits:true,
			},
			goods_end3:{
				required:true,
				digits:true,
			},
			goods_comment_num:{
				required:true,
				digits:true,
			},
			admin_name:{
				required:true,
			},
			url:{
				required:true,
			},
			commentdatemax:{
				required:true,
			},

		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
				var msg =confirm("确定要修改此商品吗？");
				if(msg){
									$(form).ajaxSubmit({
							type: 'post',
							url: "{{url('admin/goods/post_update')}}",
							success: function(data){
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
							}});
						var index = parent.layer.getFrameIndex(window.name);
						//parent.$('.btn-refresh').click();
						/*parent.layer.close(index);*/
					}
				}
		
	});

	$('#goods_video').on('change',function(){
		$(this).prev().hide(1000);
	})

    //富文本编辑器
    UE.getEditor('editor1');
	UE.getEditor('editor2');
	function removeIframe(){
	var index = parent.layer.getFrameIndex(window.name);
	setTimeout(function(){parent.layer.close(index)}, 500); 
		}
		$('.is_video').on('click',function(){
			var val=$(this).val();
			if(val==0){
				$(this).parent().parent().parent().prev().hide(400);
			}else if(val==1){
				$(this).parent().parent().parent().prev().show(400);
			}
		})

		//删除属性名+属性值
		$('#addcon').on('click',function(){
		var isalive=$(this).attr('isalive');
			if(isalive!='on'){
				$('#conhtml').show(300);
				$(this).val('移除商品附加属性');
				$(this).attr('isalive','on');
			}else{
				$('#conhtml').hide(300);
				while($('.config').length>1){
					$('.config').last().remove();
				}
				$(this).val('添加商品附加属性');
				$(this).attr('isalive','off');
			}
		})

	//新增属性名+属性值
	$('#addconfig').on('click',function(){
			var configdiv=$('#configclo').clone();
            //属性名键值
            if($('#num').val() == undefined){
                var a = $('#num1').val();
            }else{
                var a = $('#num').val();
            }
		    configdiv.children('.row').find('input:first').attr('name','goods_config_name['+a+'][goods_config_name]');
		    configdiv.children('.row').find('input').attr('attr','goods_config_name['+a+'][msg]');
            configdiv.children('div:last').children('.row').children('.col-sm-4').find('input').attr('name','goods_config_name['+a+']'+'[msg][0][goods_config]');
		    configdiv.children('div:last').children('.row').children('.col-sm-3').find('input').attr('name','goods_config_name['+a+']'+'[msg][0][config_imgs]');
        	a++;
            if($('#num').val() == undefined){
                $('#num1').val(a)
            }else{
                $('#num').val(a)
            }
			configdiv.show(200);
			$('#conhtml').append(configdiv);
		})

	//删除属性名+属性值
    $("#rmconfig").on('click',function(){
        if($('.config').length>1 && $('.config:last').attr('attr') == 'newConfig' ){
            $('.config').last().remove();
        }
    })

    // 新增属性
    function addConfig(obj){
        var configdiv=$('#configclo-value').clone();
        //属性值键值
        var k = $(obj).parent().parent().parent().prev().find('input:last').val();
		//属性值名称
		var msg = $(obj).parent().parent().parent().prev().find('input:first').attr('attr');
        configdiv.children('.col-sm-4').find('input').attr('name',msg+'['+k+']'+'[goods_config]');
        configdiv.children('.col-sm-3').find('input').attr('name',msg+'['+k+']'+'[config_imgs]');
        console.log(configdiv.children('.col-sm-3').find('input').attr('name'));
        configdiv.show(200);
        k++;
        $(obj).parent().parent().parent().prev().find('input:last').val(k);
        $(obj).parent().parent().parent().append(configdiv);
    }

    // 删除属性(控制原有数据不可删除)
    function rmConfig(obj){
        if($(obj).parent().parent().parent().children("div.row").length>1){
            if($(obj).parent().parent().parent().children("div.row:last").attr('attr') == 'newConfig'){
                $(obj).parent().parent().parent().children("div.row:last").remove();
            }
        }else{
            layer.msg('如果想要删除，请通过虚线框内第一个减号进行删除');
        }
    }
</script>
@endsection