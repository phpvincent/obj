jQuery(document).ready(function() {
			var banh = jQuery(".banner").height();
			var banw = jQuery("#mySwiper1").width();
			var videol = jQuery("#mySwiper1 video").length;
			var imgl = jQuery("#mySwiper1 img.banner-img").length;
			if(videol) {
				client();
				jQuery("#divVideo").get(0).play();
				jQuery(".bannerq").show();
				//声音按钮
				jQuery('<img id="vocie" src="https://nrshop.s3-ap-southeast-1.amazonaws.com/ueditor/image/20171227/1514352154695304.png" width="30" height="30">').appendTo($('.bannerq'));
				jQuery('#vocie').attr('style','position:absolute;right:2%;top:-18px;width: 30px;');
				jQuery('#vocie').on('click',function(){
					var videos= document.getElementById("divVideo").muted;
					if(videos){
						document.getElementById('vocie').setAttribute('src','https://nrshop.s3-ap-southeast-1.amazonaws.com/ueditor/image/20171227/1514352155817300.png');
						document.getElementById("divVideo").muted=false;
						//jQuery("#divVideo").get(0).volume(0);
					}else{
					    document.getElementById('vocie').setAttribute('src','https://nrshop.s3-ap-southeast-1.amazonaws.com/ueditor/image/20171227/1514352154695304.png');
					    document.getElementById("divVideo").muted=true;
					    //jQuery("#divVideo").get(0).volume=(1);    
					}
				});
				//滚动时静音播放
				var flag = false;
				jQuery(document).scroll(function() {
					var scrollTop = $(document).scrollTop()+50;
					var tt = jQuery("#mySwiper1 .swiper-wrapper").css("transform").replace(/[^0-9\-,]/g, '').split(',')[4];
					function scroll_showVideo() {
						if(scrollTop > banh) {
							if(!flag){
								jQuery("#divVideo").hide();
								jQuery("#divVideo").get(0).pause();
								jQuery("#vocie").hide();
		//						jQuery("#divVideo").get(0).muted=true;
		//						document.getElementById('vocie').setAttribute('src','img/vocie_n.png');
							}
							flag=true;
						}else{
							if(flag){
								if(tt==0){
									jQuery("#divVideo").show();
									jQuery("#divVideo").get(0).play();
									jQuery("#vocie").show();
									$('#temp').hide();
								}
							}
							flag=false;
						}
					}
					scroll_showVideo();
				});
				if(imgl){
					var banhj = jQuery("#swiper-slide").height()-60;
//					jQuery("#divVideo").attr("style","margin:0 auto;max-width: 100%;height: "+banhj+"px;");
//					var voidhei = jQuery("#divVideo").height();
//					var banhjh = (banhj/(15/16)-voidhei)/2-30;
					jQuery("#divVideo").attr("style","margin:0 auto;max-width: 100%;height: inherit;background-color:#000;width:100%;"); // 高度改了"+banhj+"
//					$('#temp').css('margin-top',-50+banhjh);
					var mySwiper1 = new Swiper('#mySwiper1', {
						pagination: '.swiper-pagination',
						paginationType: 'fraction',
						onSlideChangeStart: function() {
							if(videol) {
								jQuery("#divVideo").show();
								//jQuery("#divVideo").get(0).play();修改
								jQuery(".bannerq li").removeClass('bactive');
								var index = mySwiper1.activeIndex;
								if(index < 2) {
									jQuery(".bannerq li").eq(mySwiper1.activeIndex).addClass('bactive');
									if(index==0){//修改
										jQuery("#divVideo").get(0).play();
										jQuery("#vocie").show();
		//								jQuery("#divVideo").get(0).muted=true;
		//								document.getElementById('vocie').setAttribute('src','img/vocie_n.png');
										$('#temp').hide();
									}else{
										jQuery("#divVideo").get(0).pause();
										jQuery("#vocie").hide();
										jQuery("#divVideo").hide();
									}
								} else {
									jQuery(".bannerq li").eq(1).addClass('bactive');
									jQuery("#divVideo").get(0).pause();
									jQuery("#vocie").hide();
								}
							} else {
								jQuery(".bannerq").hide();
							}
						}
					});
					jQuery(".bannerq li").on('touchstart mousedown', function(e) {
						e.preventDefault();
						jQuery(".bannerq li").removeClass('bactive')
						jQuery(this).addClass('bactive')
						var active = jQuery(this).index();
						if(active == 0) {
							mySwiper1.slideTo(0);
							jQuery("#divVideo").show();
							jQuery("#vocie").show();
							jQuery("#divVideo").get(0).play();
		//					jQuery("#divVideo").get(0).muted=true;
		//					document.getElementById('vocie').setAttribute('src','img/vocie_n.png');
						} else {
							mySwiper1.slideTo(1);
							jQuery("#divVideo").hide();
							jQuery("#divVideo").get(0).pause();//修改
							jQuery("#vocie").hide();
						}
					});
					jQuery(".bannerq li").click(function(e) {
						e.preventDefault();
					});
				}else{
					jQuery(".banner").attr("style","padding-bottom: 40px;")
					jQuery(".bannerq li").hide();
					jQuery("#divVideo").attr("style","margin:0 auto;width: 100%;");
					$('#temp').css('margin-top',-40);
				}
			} else {
				jQuery(".bannerq").hide();
				if(imgl > 1){
					var mySwiper1 = new Swiper('#mySwiper1', {
						pagination: '.swiper-pagination',
						//paginationType: 'fraction',
						autoplay: 5000,
						loop : true,
					});
				}
				
			}	
		});