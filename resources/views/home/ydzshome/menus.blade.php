@extends('home.ydzshome.header')
@section('content')
<div class="breadcrumbs">
<a href="/" title="home" style="width: 3%;height: 3%"><img src="/img/home.jpg"></a>
<span></span>
<a href="javascript:void(0)">{!! config("language.footer-name.$type.".\App\goods::get_language($site->sites_blade_type)) !!}</a>
</div>
<p style="line-height: 26px; padding: 0 10px;">
	<div class="page-title">
	<h1><b>{!! config("language.footer-name.$type.".\App\goods::get_language($site->sites_blade_type)) !!}</b></h1>
	</div>
	<br><br><div style="width: 80%;margin: 0 auto;"><p style="text-align:center;"><img src="/img/site.png"></p><br/>{!! config("language.".$type.".".\App\goods::get_language($site->sites_blade_type)) !!}</div>
</p>
@endsection