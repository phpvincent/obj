@extends('home.ydzshome.header')
@section('content')
<p style="line-height: 26px; padding: 0 10px;">
	<br><br><div style="width: 80%;margin: 0 auto;"><p style="text-align:center;"><img src="/images/ydzs.png"></p><br/>{!! config("language.".$type.".".\App\goods::get_language($site->sites_blade_type)) !!}</div>
</p>
@endsection