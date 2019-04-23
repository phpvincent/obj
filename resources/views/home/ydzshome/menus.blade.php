@extends('home.ydzshome.header')
@section('content')
<!-- @if($is_monitor==1&&in_array('2',explode(',',\App\worker_monitor::first(['worker_monitor_route_type'])['worker_monitor_route_type'])))
            <script type="text/javascript" src="/js/jQuery.min.js"></script>
            <script type="text/javascript" src="/js/moudul/websockets.js?v=1.0"></script>   
        @endif -->
<style>
@media screen and (min-width: 780px) {
	.cd-main-content .breadcrumbs, .category-products, .load {
    margin: 40px auto;
    width: 80%;
	margin-top: 50px;
	border:none;
	padding:0
}}
</style>
<div class="breadcrumbs">
<a href="/" title="home" style="width: 24px;height: 24px"><img src="/img/home.jpg"></a>
<span></span>
<a href="javascript:void(0)">{!! config("language.footer-name.$type.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
</div>
<p style="line-height: 26px; padding: 0 10px;">
	<div class="page-title">
	<h1><b>{!! config("language.footer-name.$type.".\App\goods::get_language($site->sites_blade_type)) !!}</b></h1>
	</div>
	<br><br><div style="width: 80%;margin: 0 auto;line-height: 20px;"><p style="text-align:center;"><img width="6%"; src="{{ asset('img/site.png') }}"></p><br/>{!! config("language.".$type.".".\App\goods::get_language($site->sites_blade_type)) !!}</div>
</p>
<br>
<br>
<br>
<div class="new-sale-big" style="width: 100%;">
				<!-- <a href="/"><img src="/img/zlt.jpg"/></a> -->
	<a href="/footer/about">
	<img src="/img/site_img/ourstory.jpg">
	</a>
</div>
@endsection