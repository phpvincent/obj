@extends('admin.father.css') 
@section('content')
<style>
/* 搜索下拉框 */
.box{
    position: absolute;
    top: 36px;
    z-index: 999;
    width: 100%;
    overflow-y: auto;
    padding-right: 30px;
    box-sizing: border-box;
    height: 132px;
    border: 1px solid #ddd;
    background:#fff;
}
.box ul{

    background-color: #fff;
}
.box li{
    padding: 0 15px;
    cursor:pointer;
}
.box li:nth-child(odd){background:#F4F4F4;}
.deletes,.xinpin_deletes,.miaosha_deletes,.remai_deletes{
    cursor: pointer;
}
.xinpin_add,.miaosha_add,.remai_add{
    cursor: pointer;
    display: inline-block;
    margin-left:6px;
    border:1px solid #666;
    padding:2px 6px;
}
.title{
    font-size:20px;
    color:#333
}
</style>
    <article class="page-container">
        <form class="form form-horizontal" id="form-role-update" enctype="multipart/form-data" action="{{url('admin/sites/add')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="site_name" name="site_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>模板类型：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
					<select name="goods_blade_type" id="goods_blade_type" class="select">
						<option value="0" >0--台湾模板</option>
						<option value="1">1--简体模板</option>
						<option value="2">2--阿联酋模板</option>
						<option value="3">3--马来西亚模板</option>
						<option value="4">4--泰国模板（旧版）</option>
						<option value="5">5--日本模板（旧版）</option>
						<option value="6">6--印度尼西亚</option>
						<option value="7">7--菲律宾</option>
						<option value="8">8--英国（旧版）</option>
						<option value="9">9--Google-PC（旧版）</option>
						<option value="10">10--美国（旧版）</option>
						<option value="11">11--越南（旧版）</option>
						<option value="12">12--沙特</option>
						<option value="13">13--沙特英文</option>
						<option value="14">14--卡塔尔</option>
						<option value="15">15--卡塔尔英文</option>
						<option value="16">16--中东阿语</option>
						<option value="17">17--中东英语</option>
					</select>
					</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点轮播图：</label>
                <div style="margin:0px auto; width: 73%;margin-left:18%; " id="pzhtml">
                    <input type="button" class="btn btn-default" value="增加轮播图" id="addpz" style="margin-left:18%;" />
                    <div  style="margin-top:6px;    position: relative; " >
                        <div>
                            关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">
                            <input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">
                            轮播图片:<input type="file" id="size_file"style="width: 22%;" class="input-text" value="" placeholder=""name="size_file" accept="image/png,image/gif,image/jpg,image/jpeg">
                            <span class="deletes"><i class="Hui-iconfont"></i></span>
                        </div>
                        <div class="box" style="display: none;">
                            <ul>
                            </ul>
					    </div>
                    </div>
	            </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-2 col-sm-2"><span class="c-red">*</span>站点分类：</label>
                <div class="col-xs-10 col-sm-10">
                    @foreach($goods_type as $item)
                    <div style="margin-top: 10px">
                        <label>商品分类:</label> <input type="text" readonly style="width: 20%;vertical-align:middle; " class="input-text" value="{{$item->goods_type_name}}" placeholder="" id="goods_config">
                        <label>展示分类:</label> <input type="text" style="width: 20%;vertical-align:middle; " class="input-text" value="" placeholder="" id="goods_config" name="">
                        <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">
                        <input type="checkbox" id="config_isshow" class="price" name="" style="vertical-align:middle;cursor:pointer;" value="1"><label for="price">隐藏分类</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>特殊分类：</label>
                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                    {{--<input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">--}}
                {{--</div>--}}
                <div class="col-xs-10 col-sm-10">
                    <div class="xinpin">
                        <div>
                        <label class="title" for="">新品推荐</label><span class="xinpin_add">添加</span>
                        </div>
                        <div style="margin-top:10px;    position: relative;">
                            <div>
                                关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">
                                <input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">
                                <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">
                                <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                            </div>
                            <div class="box" style="display: none;">
                                <ul>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                    <div class="miaosha" style="margin-top:10px">
                        <div>
                        <label class="title" for="">秒杀抢购</label><span class="miaosha_add">添加</span>
                        </div>
                        <div class="miaosha_1"style="margin-top:10px;    position: relative;">
                            <div>
                                关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">
                                <input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">
                                <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">
                                <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                            </div>
                            <div class="box" style="display: none;">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="remai" style="margin-top:10px">
                        <div>
                        <label class="title" for="">热卖推荐</label><span class="remai_add">添加</span>
                        </div>
                        <div style="margin-top:10px;    position: relative;">
                            <div>
                                关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">
                                <input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">
                                <label>排序:</label> <input type="text" style="width: 15%;vertical-align:middle; " class="input-text" value="0" onkeyup="(this.v=function(){this.value=this.value.replace(/^\D*([0-9]\d{0,4})?.*$/,'$1');}).call(this)" onblur="this.v();"  id="goods_config" name="">
                                <span class="xinpin_deletes" style="margin-left:8px"><i class="Hui-iconfont"></i></span>
                            </div>
                            <div class="box" style="display: none;">
                                <ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交</button>
                </div>
            </div>
        </form>
    </article>
@endsection
@section('js')
    <script type="text/javascript">
        $("#form-role-update").validate({
            rules:{
                site_name:{
                    required:true,
                },

            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/sites/add')}}",
                    success: function(data){
                        if(data.err==1){
                            layer.msg('添加成功!',{time:2*1000},function() {
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
            }
        });
        var index=1;
	$("#addpz").on("click",function(){
		var html='<div  style="margin-top:6px;    position: relative; " >'
                        +'<div>'
                            +'关联商品:<input type="text"style="width: 10%;" class="input-text chanpin"  value="" placeholder="" id="chanpin_prize">'
                            +'<input type="text" style="display: none;" class="input-text chanpin"autocomplete="off" id="goods_kind" name="goods_kind" value="">'
                            +'轮播图片:<input type="file" id="size_file"style="width: 22%;" class="input-text" value="" placeholder=""name="size_file" accept="image/png,image/gif,image/jpg,image/jpeg">'
                            +'<span class="deletes"><i class="Hui-iconfont"></i></span>'
                        +'</div>'
                        +'<div class="box" style="display: none;">'
                            +'<ul>'
                            +'</ul>'
					    +'</div>'
                    +'</div>';
		$("#pzhtml").append(html);
		index+=1;
	});
    $('body').on("click",".deletes",function(){
		$(this).parent().parent().remove();
	})
    // 新品推荐添加
    $('.xinpin_add').on("click",function(){
        var $text=$(".xinpin").children(":first").next();
        $text.after($text.clone(true));
    })
	$('body').on("click",".xinpin_deletes",function(){
		$(this).parent().parent().remove();
	})
    // 秒杀添加
    $(".miaosha_add").click(function () {
        var $text=$(".miaosha").children(":first").next();
        $text.after($text.clone(true));
   });
	$('body').on("click",".miaosha_deletes",function(){
		$(this).parent().parent().remove();
	})
    // 热卖添加
    $('.remai_add').on("click",function(){
        var $text=$(".remai").children(":first").next();
        $text.after($text.clone(true));
    })
	$('body').on("click",".remai_deletes",function(){
		$(this).parent().parent().remove();
	})
    // 搜索下拉框
	$("body").on('focus','.chanpin',function(){
        $(this).parent().next().show(400)  ;
        var datathis= $(this).parent().next().children("ul");
		// $('.box_+id').show(400);
		var a=$(this).val();
		$.ajax({
			//请求方式
			type:'GET',
			url:'{{url("admin/goods/goods_kind_s")}}?name='+a,
			dataType:'json',
			data:{},
			success:function(data){
				xialaCheck =false;
				var str='';
				jQuery.each(data,function(key,value){
                        str+='<li data-id='+value.goods_kind_id + '>'+value.goods_kind_name+'</li>'
				}) 
				datathis.html(str);
			},
			error:function(jqXHR){

			}
		});
	});
	// function xiala(){
    $('body').on('input propertychange','.chanpin', function() {
		$(this).next('#goods_kind').val('');
        var datathis= $(this).parent().next().children("ul");
		datathis.empty();
		$(this).parent().next().show(400);
		var a=$(this).val();
        console.log($(this))
		$.ajax({
			//请求方式
			type:'GET',
			url:'{{url("admin/goods/goods_kind_s")}}?name='+a,
			dataType:'json',
			data:{},
			success:function(data){
				var str='';
				if(data.length !=0 ){
					jQuery.each(data,function(key,value){ 
                            str+='<li data-id='+value.goods_kind_id + '>'+value.goods_kind_name+'</li>'
					}) 
					datathis.html(str);
				}else{
					datathis.html('<span >没有相应产品</span>');
				}
			},
			error:function(jqXHR){

			}
		});
	})
	
	$('body').on('blur','.chanpin',function(){
        var ab=$(this).next().val();
        if( ab ==''){
            $(this).val('')
        }
		 $('.box').hide(400);
	});
	function chanbingCheck(){
		var Check=true;
		var a=$(this).val();
		$.ajax({
			type:'GET',
			url:'{{url("admin/goods/goods_kind_s")}}?name='+'',
			dataType:'json',
			async:false,
			data:{},
			success:function(data){

				jQuery.each(data,function(key,value){ 
					if(a==value.goods_kind_name){
						Check=false;
					} 
				});
				if(Check){
					var target_top = $("#goods_kind_name").offset().top;
					// $("html,body").animate({scrollTop: target_top}, 1000);  //带滑动效果的跳转
					$("html,body").scrollTop(target_top);
					setTimeout('layer.alert("此产品不存在,请选择产品！");',1200); 
				}
			},
			error:function(jqXHR){

			}
		});
		if(Check){
			return false;
		}else{
			return true;
		}
	}
	$('body').on('mousedown','.box li',function(){

		$('.box').hide(400);
		var content=$(this).text();
		var content_id=$(this).attr('data-id');
        $(this).parent().parent().prev().find(".chanpin").val(content);
        $(this).parent().parent().prev().find("#goods_kind").val(content_id);
		// $('.chanpin').val(content);
		// $('#goods_kind').val(content_id);
		$('.box ul').empty();
	})

    </script>
@endsection