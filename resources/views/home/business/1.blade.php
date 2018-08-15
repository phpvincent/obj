<!DOCTYPE HTML>
<html>
<head>
<title>企业官网</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<!-- <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> -->
<!-- fonts -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
<!-- /fonts -->
<!-- css files -->
<link href="business/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="business/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="business/css/viewbox.css" rel="stylesheet" type="text/css" media="all" />
<link href="business/css/jQuery.lightninBox.css" rel="stylesheet" type="text/css" media="all" />
<link href="business/css/service.css" rel="stylesheet" type="text/css" media="all" />
<link href="business/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- /css files -->
<!-- js files -->
<style type="text/css">
	@foreach($imgs['about'] as $key => $v)
	.cover-slider__slide:nth-child({{$key+1}}) {
	background-image: url("{{$v->business_img_url}}");
	}
	@endforeach
	section.testimonial {
	padding:100px 0;
	background:url({{$imgs['bg']->last()->business_img_url}}) no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:100% 100%;
	-webkit-background-size:100% 100%;
	-moz-background-size:100% 100%;
	-o-background-size:100% 100%;
	-ms-background-size:100% 100%;
	}
	section.address-agileits {
	padding:100px 0;
	background:url({{$imgs['bg']->first()->business_img_url}}) no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:100% 100%; 
	-webkit-background-size:100% 100%;
	-moz-background-size:100% 100%;
	-o-background-size:100% 100%;
	-ms-background-size:100% 100%;
	}
	
	section.contact-w3l {
	padding:100px 0;
	background:url({{$imgs['bg']->toArray()[1]['business_img_url']}}) no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
	section.portfolio-wthree {
	padding:100px 0;
	background:url(../images/portfolio.jpg) no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:100% 100%;
	-webkit-background-size:100% 100%;
	-moz-background-size:100% 100%;
	-o-background-size:100% 100%;
	-ms-background-size:100% 100%;
}
@foreach($imgs['goods'] as $key => $v)
	.ch-img-{{$key+1}} { 
		background-image: url({{$v->business_img_url}});
	}
	.ch-info .ch-info-back{{$key+1}} { 
		@if(isset($imgs['special'][$key]))
		background-image: url({{$imgs['special'][$key]['business_img_url']}});
		@else
		background-image: url({{$v->business_img_url}});
		@endif
	}
@endforeach
	
</style>
<script src="business/js/modernizr.js"></script>
<!-- /js files -->
</head>
<body>
<!-- navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
        <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav cl-effect-5">
				<li class="active"><a href="#homesles" class="page-scroll"><span data-hover="Home">Home</span></a></li>
				<li><a href="#about" class="page-scroll"><span data-hover="About">About</span></a></li>
				<li><a href="#service" class="page-scroll"><span data-hover="Services">Services</span></a></li>
				<li><a href="#group" class="page-scroll"><span data-hover="group">group</span></a></li>
				<li><a href="#EVENTS" class="page-scroll"><span data-hover="EVENTS">EVENTS</span></a></li>
				<li><a href="#contact" class="page-scroll"><span data-hover="Contact">Contact</span></a></li>
			</ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<!-- /navigation -->
<!-- banner section -->
<section class="banner-w3ls" id="homesles">
	<div class='header'>
		<div class="logo-agileits">
			<a class="logo-w3ls" href="http://www.phpvincent.top"><h1>YDZS</h1></a>
		</div>	
	</div>	
</section>
<!-- /banner section -->
<!-- about section -->
<section class="about-agileits" id="about">
	<div class="container">
		<div class="col-md-5 col-md-push-7 about-agile2">
			<div class="about-agileinfo">
				<h2>About Us</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis semper felis, id suscipit arcu venenatis nec. Etiam non ligula ac massa bibendum molestie. Nam sit amet augue nulla. </p>
				<p>Quisque pulvinar consectetur erat non ornare. Nulla facilisi. Phasellus condimentum turpis vel elit mollis tempus. Nulla at luctus ante. Nullam et nulla interdum, blandit quam et, vehicula nibh.</p>
			</div>
		</div>
		<div class="col-md-7 col-md-pull-5 about-agile1">
			<div class="cover-slider__wrap">
				<ul class="cover-slider">
					@foreach($imgs['about'] as $key => $v)
					<li class="cover-slider__slide">
						<span class="hide">Alt Tag</span>
					</li>
					@endforeach
					<!--  -->
				</ul>
			</div>
		</div>
		<div class="clearfix"></div>	
	</div>
</section>
<!-- /about section -->
<!-- address -->
<section class="address-agileits">
	<div class="container">
		<div class="col-lg-4 col-md-4 addr-agileinfo1">
			<div class="addr-w3-agile">
				<div class="col-xs-4 addr-agileits1">
					<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1b">
						<i class="hi-icon fa fa-mobile" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-xs-8 addr-agileits2">
					<div class="addr-w3l">
						<h3>Phone Number</h3>
						<p>+12 345 6789</p>
						<p>+10 101 1010</p>
					</div>	
				</div>	
				<div class="clearfix"></div>
			</div>	
		</div>
		<div class="col-lg-4 col-md-4 addr-agileinfo2">
			<div class="addr-w3-agile">
				<div class="col-xs-4 addr-agileits1">
					<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1b">
						<i class="hi-icon fa fa-map-marker" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-xs-8 addr-agileits2">
					<div class="addr-w3l">
						<h3>Address</h3>
						<p>27 Jack Street,</p>
						<p>Chicago, USA</p>
					</div>	
				</div>
				<div class="clearfix"></div>
			</div>
		</div>	
		<div class="col-lg-4 col-md-4 addr-agileinfo3">
			<div class="addr-w3-agile">
				<div class="col-xs-4 addr-agileits1">
					<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1b">
						<i class="hi-icon fa fa-envelope-o" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-xs-8 addr-agileits2">
					<div class="addr-w3l">
						<h3>Email Us</h3>
						<p><a href="mailto:support@company.com">mail@example.com</a></p>
						<p><a href="mailto:support@company.com">mail@example.com</a></p>
					</div>	
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 addr-agileinfo3">
			<div class="addr-w3-agile">
				<div class="col-xs-4 addr-agileits1">
					<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1b">
						<i class="hi-icon fa fa-facebook" aria-hidden="true"></i>
					</div>
				</div>
				<div class="col-xs-8 addr-agileits2">
					<div class="addr-w3l">
						<h3>Facebook</h3>
						<p><a href="mailto:support@company.com">mail@example.com</a></p>
					</div>	
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>	
	</div>
</section>
<!-- /address -->
<!-- <div class="tlinks">Collect from <a href="http://www.cssmoban.com/" >网页模板</a></div> -->
<!-- services section -->
<section class="service-wthree" id="service">
	<div class="container">
		<h3 class="text-center">Our Services</h3>
		<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-1">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-1"></div>
								<div class="ch-info-back1">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">Lorem ipsum dolor</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-2">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-2"></div>
								<div class="ch-info-back2">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">adipiscing elit</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-3">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-3"></div>
								<div class="ch-info-back3">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">congue augue at</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-4">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-4"></div>
								<div class="ch-info-back4">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">Nulla ex arcu</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-5">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-5"></div>
								<div class="ch-info-back5">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">pharetra quam</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6">
			<ul class="ch-grid">
				<li>
					<div class="ch-item ch-img-6">				
						<div class="ch-info-wrap">
							<div class="ch-info">
								<div class="ch-info-front ch-img-6"></div>
								<div class="ch-info-back6">
									<h4>YDZS-Chinese Medicine Museum</h4>
									<p>Best In Service</p>
								</div>	
							</div>
						</div>
					</div>
				</li>
			</ul>
			<h5 class="text-center">eu molestie arcu</h5>
			<p class="serv-p2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pellentesque congue augue at posuere.</p>	
		</div>
		<div class="clearfix"></div>
	</div>
</section>
<!-- /services section -->
<!-- testimonial section -->
<section class="testimonial">
	<div class="container">
		<h3 class="text-center" id="group">Our Clients Word</h3>
		<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="2000" data-pause="hover">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
				<li data-target="#myCarousel" data-slide-to="3"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				
				<div class="item active">
					<div class="col-lg-8 col-md-8 col-sm-8 test-agile1">
						<p><i class="fa fa-quote-left" aria-hidden="true"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla mattis libero ut dolor facilisis, eget auctor lacus congue. Curabitur ex nisl, vestibulum vitae consequat eu, tristique et enim. Suspendisse potenti. Quisque at est at nisl vulputate aliquam in quis augue. Sed a pulvinar ipsum. Praesent eget scelerisque arcu. <i class="fa fa-quote-right" aria-hidden="true"></i></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 test-agile2">
						<img src="business/images/group1.jpg" class="img-circle img-responsive" alt="">
					</div>
					<div class="clearfix"></div>
				</div>
				
				<div class="item">
					<div class="col-lg-8 col-md-8 col-sm-8 test-agile1">
						<p><i class="fa fa-quote-left" aria-hidden="true"></i> Quisque at est at nisl vulputate aliquam in quis augue. Aliquam vitae fermentum metus. Aenean placerat elit nibh, et malesuada felis dignissim tristique. Sed a pulvinar ipsum. Praesent eget scelerisque arcu.  Vestibulum eleifend lacus ut dignissim placerat. <i class="fa fa-quote-right" aria-hidden="true"></i></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 test-agile2">
						<img src="business/images/test-img2.jpg" class="img-circle img-responsive" alt="">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="item">
					<div class="col-lg-8 col-md-8 col-sm-8 test-agile1">
						<p><i class="fa fa-quote-left" aria-hidden="true"></i> Sed a pulvinar ipsum. Pellentesque interdum, nisl nec vehicula dapibus, lacus eros sagittis metus, ut tincidunt dui tortor vitae dui. Praesent eget scelerisque arcu. Vestibulum eleifend lacus ut dignissim placerat. Quisque at est at nisl vulputate aliquam in quis augue. <i class="fa fa-quote-right" aria-hidden="true"></i></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 test-agile2">
						<img src="business/images/test-img3.jpg" class="img-circle img-responsive" alt="">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="item">
					<div class="col-lg-8 col-md-8 col-sm-8 test-agile1">
						<p><i class="fa fa-quote-left" aria-hidden="true"></i> Vivamus lacinia scelerisque egestas. Aliquam sapien erat, convallis faucibus posuere eget, elementum a metus. Vestibulum eleifend lacus ut dignissim placerat. Quisque at est at nisl vulputate aliquam in quis augue. Sed a pulvinar ipsum. Pellentesque interdum, nisl nec vehicula dapibus. <i class="fa fa-quote-right" aria-hidden="true"></i></p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 test-agile2">
						<img src="business/images/test-img4.jpg" class="img-circle img-responsive" alt="">
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>		
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>	
		</div>
	</div>
</section>
<!-- /testimonial section -->
<!-- portfolio section -->
<!-- <section class="portfolio-wthree" id="portfolio">
	<div class="container">
		<h3 class="text-center">Our Portfolio</h3>
		<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<section class="tabs">
	        <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
		    <label for="tab-1" class="tab-label-1">Audi</label>
		
	        <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
		    <label for="tab-2" class="tab-label-2">Mercedes</label>
		
	        <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3" />
		    <label for="tab-3" class="tab-label-3">BMW</label>
			
			<input id="tab-4" type="radio" name="radio-set" class="tab-selector-4" />
		    <label for="tab-4" class="tab-label-4">Rollsroyce</label>
            
			<div class="clear-shadow"></div>
				
		    <div class="content">
			    <div class="content-1">
					<a href="images/port-img1.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img1.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img2.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img2.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img3.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img3.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img4.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img4.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img5.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img5.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img6.jpg" class="lightninBox" data-lb-group="1"><img src="business/images/port-img6.jpg" alt="" class="img-responsive"/></a>	
				</div>
			    <div class="content-2">
					<a href="images/port-img7.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img7.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img8.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img8.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img9.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img9.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img10.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img10.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img11.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img11.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img12.jpg" class="lightninBox" data-lb-group="2"><img src="business/images/port-img12.jpg" alt="" class="img-responsive"/></a>
				</div>
			    <div class="content-3">
					<a href="images/port-img13.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img13.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img14.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img14.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img15.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img15.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img16.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img16.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img17.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img17.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img18.jpg" class="lightninBox" data-lb-group="3"><img src="business/images/port-img18.jpg" alt="" class="img-responsive"/></a>
				</div>
				<div class="content-4">
					<a href="images/port-img19.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img19.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img20.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img20.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img21.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img21.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img22.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img22.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img23.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img23.jpg" alt="" class="img-responsive"/></a>
					<a href="images/port-img24.jpg" class="lightninBox" data-lb-group="4"><img src="business/images/port-img24.jpg" alt="" class="img-responsive"/></a>
				</div>
		    </div>
		</section>
	</div>
</section> -->
<!-- /portfolio section -->
<!-- events section -->
<section class="event-agileinfo" id="EVENTS">
	<div class="container">
		<h3 class="text-center">Our Events</h3>
		<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<div class="col-lg-4 col-md-4 col-sm-4 event-wthree1">
			<div class="event-w3ls1">
				   <a href="#" class="event-w3l" data-toggle="modal" data-target="#largeModal"><h4>Lorem ipsum dolor</h4></a>
				<p class="event-agile1">2016-2017</p>
			</div>	
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 event-wthree2">
			<p class="event-w3-agile1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec libero neque, varius nec eleifend in, egestas eget lectus. Integer non tempus ante, non blandit lectus. </p>
		</div>
		<div class="clearfix"></div>
		<div class="event-w3-agileits">
			<div class="col-lg-8 col-md-8 col-sm-8 event-wthree2">
				<p class="event-w3-agile2">Nulla dui ligula, sollicitudin non bibendum non, mattis eget lectus. Aliquam quis blandit odio. Aenean semper erat luctus enim suscipit dictum. Suspendisse vestibulum cursus egestas.</p>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 event-wthree1">
				<div class="event-w3ls2">
					<a href="#" class="event-w3l" data-toggle="modal" data-target="#largeModal"><h4>adipiscing elit</h4></a>
					<p class="event-agile1">2017-2018</p>
				</div>	
			</div>
			<div class="clearfix"></div>
		</div>	
		<div class="col-lg-4 col-md-4 col-sm-4 event-wthree1">
			<div class="event-w3ls1">
				<a href="#" class="event-w3l" data-toggle="modal" data-target="#largeModal"><h4>vestibulum cursus</h4></a>
				<p class="event-agile1">2018-2019</p>
			</div>	
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 event-wthree2">
			<p class="event-w3-agile1"> Aenean semper erat luctus enim suscipit dictum. Suspendisse vestibulum cursus egestas. Proin rutrum maximus massa mollis pharetra. Nam elit neque, sodales sed varius sit amet.</p>
		</div>
		<div class="clearfix"></div>
		<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Car-Hub</h4>
					</div>
					<div class="modal-body">
						<div class="col-lg-6 col-md-6">
							<img src="business/images/pop-img.jpg" alt="" class="img-responsive">
						</div>
						<div class="col-lg-6 col-md-6">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam facilisis semper felis, id suscipit arcu venenatis nec. Etiam non ligula ac massa bibendum molestie. Nam sit amet augue nulla. </p>
							<p>Quisque pulvinar consectetur erat non ornare. Nulla facilisi. Phasellus condimentum turpis vel elit mollis tempus. Nulla at luctus ante. Nullam et nulla interdum, blandit quam et, vehicula nibh.</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /events section -->
<!-- works section -->
<!-- <section class="work-agileinfo" id="work">
	<div class="container">
		<h3 class="text-center">Our Works</h3>
		<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 work-wthree">
			<div class="grid">
				<figure class="effect-moses">
					<img src="business/images/work-img1.jpg" alt="" class="img-responsive"/>
					<figcaption>
						<h4>Car Hub</h4>
						<p>Click It</p>
						<a href="images/work-img1.jpg" class="thumbnail" title="Car-Hub">View more</a>
					</figcaption>			
				</figure>
			</div>
			<a href="#" class="work-agile" data-toggle="modal" data-target="#largeModal"><h5 class="text-center">Lorem ipsum dolor</h5></a>
			<p class="work-w3l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sed elit sed ipsum semper tristique. </p>	
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 work-wthree">
			<div class="grid">
				<figure class="effect-moses">
					<img src="business/images/work-img2.jpg" alt="" class="img-responsive"/>
					<figcaption>
						<h4>Car Hub</h4>
						<p>Click It</p>
						<a href="images/work-img2.jpg" class="thumbnail" title="Car-Hub">View more</a>
					</figcaption>			
				</figure>
			</div>
			<a href="#" class="work-agile" data-toggle="modal" data-target="#largeModal"><h5 class="text-center">adipiscing elit</h5></a>
			<p class="work-w3l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sed elit sed ipsum semper tristique. </p>	
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 work-wthree">
			<div class="grid">
				<figure class="effect-moses">
					<img src="business/images/work-img3.jpg" alt="" class="img-responsive"/>
					<figcaption>
						<h4>Car Hub</h4>
						<p>Click It</p>
						<a href="images/work-img3.jpg" class="thumbnail" title="Car-Hub">View more</a>
					</figcaption>			
				</figure>
			</div>
			<a href="#" class="work-agile" data-toggle="modal" data-target="#largeModal"><h5 class="text-center">semper tristique</h5></a>
			<p class="work-w3l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sed elit sed ipsum semper tristique. </p>	
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 work-wthree">
			<div class="grid">
				<figure class="effect-moses">
					<img src="business/images/work-img4.jpg" alt="" class="img-responsive"/>
					<figcaption>
						<h4>Car Hub</h4>
						<p>Click It</p>
						<a href="images/work-img4.jpg" class="thumbnail" title="Car-Hub">View more</a>
					</figcaption>			
				</figure>
			</div>
			<a href="#" class="work-agile" data-toggle="modal" data-target="#largeModal"><h5 class="text-center">Nam urna orci</h5></a>
			<p class="work-w3l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sed elit sed ipsum semper tristique. </p>	
		</div>
		<div class="clearfix"></div>
	</div>
</section> -->
<!-- /works section -->
<!-- contact section -->
<section class="contact-w3l" id="contact">
	<div class="container">
		<h3 class="text-center">Our Contacts</h3>
		<p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<form action="" method="post" name="sentMessage" id="contactForm" novalidate>
            <div class="col-lg-4 col-md-4 col-sm-4">    
				<div class="control-group form-group">
                    <div class="controls">
                        <label>Full Name:</label>
                        <input type="text" class="form-control" id="name" required data-validation-required-message="Please enter your name.">
                        <p class="help-block"></p>
                    </div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">	
                <div class="control-group form-group">
					<div class="controls">
                        <label>Phone Number:</label>
						<input type="tel" class="form-control" id="phone" required data-validation-required-message="Please enter your phone number.">
                    </div>
                </div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">			
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Email Address:</label>
                        <input type="email" class="form-control" id="email" required data-validation-required-message="Please enter your email address.">
                    </div>
                </div>
			</div>
			<div class="clearfix"></div>
			<div class="col-lg-12">	
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Message:</label>
                        <textarea rows="10" cols="100" class="form-control" id="message" required data-validation-required-message="Please enter your message" maxlength="999" style="resize:none"></textarea>
					</div>
                </div>
                <div id="success"></div>
                <!-- For success/fail messages -->
			</div>
			<div class="col-lg-12">	
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
			<div class="clearfix"></div>	
		</form>	
	</div>
</section>
<!-- /contact section -->
<!-- footer -->
<div class="footer">
	<p class="text-center">Copyright &copy; 2016.Company name All rights reserved.More Templates <a href="http://www.phpvincent.top/" target="_blank" title="tellus">tellus</a> - Collect from <a href="http://www.cssmoban.com/" title="blade" target="_blank">blade</a></p>
</div>
<!-- /footer -->
<!-- back to top -->
<a href="#0" class="cd-top">Top</a>
<!-- /back to top -->
<!-- js files -->
<script src="business/js/jquery.min.js"></script>
<script src="business/js/bootstrap.min.js"></script>
<script src="business/js/smoothscroll.js"></script>
<script src="business/js/jquery.easing.min.js"></script>
<script src="business/js/grayscale.js"></script>
<script src="business/js/jqBootstrapValidation.js"></script>
<script src="business/js/contact_me.js"></script>
<!-- js for back to top -->
<script src="business/js/top.js"></script>
<!-- /js for back to top -->
<!-- js for work section -->
<script src="business/js/jquery.viewbox.min.js"></script>
<script>

	$(function(){
			 $("input,textarea").jqBootstrapValidation({
	        preventSubmit: true,
	        submitError: function($form, event, errors) {
	            // something to have when submit produces an error ?
	            // Not decided if I need it yet
	        },
	        submitSuccess: function($form, event) {
	            event.preventDefault(); // prevent default submit behaviour
	            // get values from FORM
	            var name = $("input#name").val();
	            var phone = $("input#phone").val();
	            var email = $("input#email").val();
	            var message = $("textarea#message").val();
	            var firstName = name; // For Success/Failure Message
	            // Check for white space in name for Success/Fail message
	            if (firstName.indexOf(' ') >= 0) {
	                firstName = name.split(' ').slice(0, -1).join(' ');
	            }
	            $.ajax({
	                url: "{{url('business/form')}}",
	                type: "POST",
	                data: {
	                    name: name,
	                    phone: phone,
	                    email: email,
	                    message: message,
	                    _token:"{{csrf_token()}}"
	                },
	                cache: false,
	                success: function() {
	                    // Success message
	                    $('#success').html("<div class='alert alert-success'>");
	                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
	                        .append("</button>");
	                    $('#success > .alert-success')
	                        .append("<strong>Your message has been sent. </strong>");
	                    $('#success > .alert-success')
	                        .append('</div>');

	                    //clear all fields
	                    $('#contactForm').trigger("reset");
	                },
	                error: function() {
	                    // Fail message
	                    $('#success').html("<div class='alert alert-danger'>");
	                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
	                        .append("</button>");
	                    $('#success > .alert-danger').append("<strong>Sorry " + firstName + " it seems that my mail server is not responding...</strong> Could you please email me directly to <a href='mailto:me@example.com?Subject=Message_Me from myprogrammingblog.com;>me@example.com</a> ? Sorry for the inconvenience!");
	                    $('#success > .alert-danger').append('</div>');
	                    //clear all fields
	                    $('#contactForm').trigger("reset");
	                },
	            })
	        },
	        filter: function() {
	            return $(this).is(":visible");
	        },
	    });

	    $("a[data-toggle=\"tab\"]").click(function(e) {
	        e.preventDefault();
	        $(this).tab("show");
	    });
	});


	/*When clicking on Full hide fail/success boxes */
	$('#name').focus(function() {
	    $('#success').html('');
		/*$('.thumbnail').viewbox();
		$('.thumbnail-2').viewbox();
			
		(function(){
			var vb = $('.popup-link').viewbox();
			$('.popup-open-button').click(function(){
				vb.trigger('viewbox.open');
			});
			$('.close-button').click(function(){
				vb.trigger('viewbox.close');
			});
		})();*/
			
		/*(function(){
			var vb = $('.popup-steps').viewbox({navButtons:false});
				
			$('.steps-button').click(function(){
				vb.trigger('viewbox.open',[0]);
			});
			$('.next-button').click(function(){
				vb.trigger('viewbox.open',[1]);
			});
			$('.prev-button').click(function(){
				vb.trigger('viewbox.open',[0]);
			});
			$('.ok-button').click(function(){
				vb.trigger('viewbox.close');
			});
		})();*/
	});
</script>
<!-- /js for work section -->
<!-- js for about section -->
<script src="business/js/index.js"></script>
<!-- /js for about section -->
<!-- js for portfolio section -->
<script src="business/js/jQuery.lightninBox.js"></script>
<script type="text/javascript">
$(".lightninBox").lightninBox();
</script>
<!-- /js for portfolio section -->
<!-- js for banner -->
<script src="business/js/bgfader.js"></script>
<script>
var myBgFader = $('.header').bgfader([
	@foreach($imgs['fm'] as $key => $v)
  '{{$v->business_img_url}}',
  @endforeach
], {
  'timeout': 3000,
  'speed': 3000,
  'opacity': 0.4
})
myBgFader.start()
</script>
<!-- /js for banner -->
<!-- /js files -->
</body>
</html>