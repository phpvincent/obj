client = function(){
var videoEl=document.getElementById('divVideo');

if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
	(function() {
        	function log(info) {
        }
        function forceSafariPlayAudio() {
            videoEl.load(); // iOS 9   还需要额外的 load 一下, 否则直接 play 无效
            videoEl.play(); // iOS 7/8 仅需要 play 一下
        }

        var videoEl = document.getElementById('divVideo');

        // 可以自动播放时正确的事件顺序是
        // loadstart
        // loadedmetadata
        // loadeddata
        // canplay
        // play
        // playing
        // 
        // 不能自动播放时触发的事件是
        // iPhone5  iOS 7.0.6 loadstart
        // iPhone6s iOS 9.1   loadstart -> loadedmetadata -> loadeddata -> canplay
        videoEl.addEventListener('loadstart', function() {
            log('loadstart');
        }, false);
        videoEl.addEventListener('loadeddata', function() {
            log('loadeddata');
        }, false);
        videoEl.addEventListener('loadedmetadata', function() {
            log('loadedmetadata');
        }, false);
        videoEl.addEventListener('canplay', function() {
            log('canplay');
        }, false);
        videoEl.addEventListener('play', function() {
            log('play');
            // 当 audio 能够播放后, 移除这个事件
        window.removeEventListener('touchstart', forceSafariPlayAudio, false);
        }, false);
        videoEl.addEventListener('playing', function() {
            log('playing');
        }, false);
        videoEl.addEventListener('pause', function() {
            log('pause');
        }, false);

        // 由于 iOS Safari 限制不允许 audio autoplay, 必须用户主动交互(例如 click)后才能播放 audio,
        // 因此我们通过一个用户交互事件来主动 play 一下 audio.
        window.addEventListener('touchstart', forceSafariPlayAudio, false);
    })();
    
	//播放暂停加图标

    // var f=true;
    // $('#divVideo').on('touchstart',function(){
	 //   		if(!f){
		// 	 		videoEl.play();
		// 			setTimeout(function(){
		// 				$('#temp').hide();
		// 			},100);
		// 			f=true;
	 //   		}else{
	 //   			videoEl.pause();
		// 		videoEl.controls=false;
		// 		$('#temp').show();
		// 		f=false;
	 //   		}
    // });
    // $('<img id="temp" src="img/temp.png" >').appendTo($('#divVideo').parent());
   
     $('#divVideo').on('touchstart',function(){
        if(videoEl.played){
            videoEl.controls=false;
            videoEl.pause();
            $('#temp').show();
//	        $(document).scroll(function(){
//	            videoEl.pause();
//	        });
        }
    });
    $('<img id="temp" src="https://nrshop.s3-ap-southeast-1.amazonaws.com/ueditor/image/20171227/1514352154777604.png" width="20" height="20">').appendTo($('#divVideo').parent());
    $('#temp').attr('style','position:absolute;display:block;width:80px;height:80px;display:none;left: 50%;top: 50%;');
    var videoH=$('#divVideo').height();
    var videoW=$('#divVideo').width();
    $('#temp').css('margin-top',-80);
    $('#temp').css('margin-left',-40);
    
    $('#temp').on('touchstart',function(){
        if(videoEl.paused){
            videoEl.controls=false;
            videoEl.play();
            $('#temp').hide();

        }
    });
} else if (/(Android)/i.test(navigator.userAgent)) {
    	
videoEl.addEventListener('play',function(){
	videoEl.play();
},false);
   
} else {
	videoEl.play();
};


$('.bannerqli:eq(0)').on('touchstart',function(){
	videoEl.muted=true;
	$('#temp').hide();
});
}



