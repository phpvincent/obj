@extends('admin.father.css')
@section('content')
<style>
.zhekou,.jianmian{
	display: none;
}
</style>
<article class="page-container">

	<form class="form form-horizontal" id="form-addcomment-add" action="/admin/comment/save_com" method="post">
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
				<input type="text" class="input-text" value="1"  placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
		</div>
		<div class="row cl zhekou">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>优惠折扣：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" disabled class="input-text"onkeyup="this.value=this.value.replace(/[^1-9]/g,'') " 
 onafterpaste="this.value=this.value.replace(/[^1-9]/g,'') "maxlength="1"  value="1" placeholder="" id="articlesort" name="goods_cheap_msg" >
			</div>
		</div>
		<div class="row cl jianmian">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>满足金额：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" disabled class="input-text" value="1" placeholder="" id="articlesort" name="goods_cheap_remark">
			</div>
		</div>
		<div class="row cl" style="">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>生效时间：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<input type="text" class="Wdate" id="d122" name="goods_cheap_start_time" value="2018-10-1 23:00:50" onclick="WdatePicker({isShowWeek:true,readOnly:true,dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'%y-%M-%d',onpicked:function() {$dp.$('d122_1').value=$dp.cal.getP('W','W');$dp.$('d122_2').value=$dp.cal.getP('W','WW');}})"/>
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
	var dates = new Date();
	var timestamp=Date.parse(dates);
	var max=432000;
	var min=0;
	timestamp=timestamp-(Math.floor(Math.random()*(max-min+1)+min))*1000;
	var date = new Date(timestamp);
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    
         var second=date.getSeconds().toString();
         if(second.length<=1){
         	second='0'+second;
         }
         var hour=date.getHours().toString();
         if(hour.length<=1){
         	hour='0'+hour;
         }
         var minute=date.getMinutes().toString();
         if(minute.length<=1){
         	minute='0'+minute;
         }
         var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + hour + seperator2 + minute + seperator2+second;
		$('#d122').attr('value',currentdate);
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
	$("#form-addcomment-add").validate({
		rules:{
			com_name:{
				required:true,
				minlength:2,
				maxlength:50,
			},
			com_phone:{
				required:true,
				rangelength:[5,11],
			},
			com_order:{
				required:true,
				range:[1,100],
			},
			com_msg:{
				required:true,				
			},
		},
		onkeyup:function(element) { $(element).valid(); },
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit({
				type: 'post',
				url: "{{url('admin/comment/save_com')}}",
				success: function(data){
					if(data.err==1){
						layer.msg('更改成功!',{time:2*1000},function() {
						//回调
							index = parent.layer.getFrameIndex(window.name);
							setTimeout("parent.layer.close(index);",2000);
                        	window.parent.location.reload();
						});
					}else{
						layer.msg('更改失败!');
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
	$list = $("#fileList"),
	$btn = $("#btn-star"),
	state = "pending",
	uploader;
	var uploader = WebUploader.create({
		auto: true,
		swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',
	
		// 文件接收服务端。
		server: 'fileupload.php',
	
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: '#filePicker',
	
		// 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
		resize: false,
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		}
	});
	uploader.on( 'fileQueued', function( file ) {
		var $li = $(
			'<div id="' + file.id + '" class="item">' +
				'<div class="pic-box"><img></div>'+
				'<div class="info">' + file.name + '</div>' +
				'<p class="state">等待上传...</p>'+
			'</div>'
		),
		$img = $li.find('img');
		$list.append( $li );
	
		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb( file, function( error, src ) {
			if ( error ) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}
	
			$img.attr( 'src', src );
		}, thumbnailWidth, thumbnailHeight );
	});
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
		var $li = $( '#'+file.id ),
			$percent = $li.find('.progress-box .sr-only');
	
		// 避免重复创建
		if ( !$percent.length ) {
			$percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
		}
		$li.find(".state").text("上传中");
		$percent.css( 'width', percentage * 100 + '%' );
	});
	
	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file ) {
		$( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
	});
	
	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file ) {
		$( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
	});
	
	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on( 'uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress-box').fadeOut();
	});
	uploader.on('all', function (type) {
        if (type === 'startUpload') {
            state = 'uploading';
        } else if (type === 'stopUpload') {
            state = 'paused';
        } else if (type === 'uploadFinished') {
            state = 'done';
        }

        if (state === 'uploading') {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on('click', function () {
        if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });
		/*var ue = UE.getEditor('editor');*/

</script>
@endsection