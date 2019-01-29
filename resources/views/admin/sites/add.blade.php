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
.deletes{
    cursor: pointer;
}
</style>
    <article class="page-container">
        <form class="form form-horizontal" id="form-role-update" enctype="multipart/form-data" action="{{url('admin/admin/addrole')}}" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点轮播图：</label>
                <!-- {{--图片===>关联商品--}}
                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                    {{--<input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">--}}
                {{--</div>--}}
                {{--<label class="form-label col-xs-4 col-sm-2">尺码图片：</label>--}}
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="file" id="size_file" class="input-text" value="" placeholder="" id="size_file" name="size_file" accept="image/png,image/gif,image/jpg,image/jpeg">
                </div> -->
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
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>站点分类：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>特殊分类：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="" id="role_name" name="role_name">
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
                role_name:{
                    required:true,
                },

            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "{{url('admin/admin/addrole')}}",
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
                //parent.$('.btn-refresh').click();
                /*parent.layer.close(index);*/
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
		$(this).parent().remove();
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
						// str+='<li data-id='+value.goods_kind_id+'>'+value.goods_kind_name+'</li>'
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