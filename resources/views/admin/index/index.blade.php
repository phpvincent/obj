@extends('admin.father.css')
@section('content')
<div class="page-container">
	{{--<p class="f-20 text-success">欢迎使用信息管理系统！</p>--}}
	{{--<p>登录次数：{{Cookie::get('l_num')}} </p>--}}
	{{--<p>上次登录IP：{{Cookie::get('l_ip')}} 上次登录时间：{{Cookie::get('l_time')}}</p>--}}
	@if(Auth::user()->is_root == '1')
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th colspan="7" scope="col">信息统计</th>
			</tr>
			<tr class="text-c">
				<th>统计</th>
				<th>订单数</th>
				<th>单品数</th>
				<th>账户数</th>
				<th>域名数</th>
				<th>浏览量</th>
			</tr>
		</thead>
		<tbody>
			<tr class="text-c">
				<td>所有</td>
				<td>{{\App\order::where('is_del','0')->count()}}</td>
				<td>{{\App\goods::where('is_del','0')->count()}}</td>
				<td>{{\App\admin::where('admin_use','1')->count()}}</td>
				<td>{{\App\url::count()}}</td>
				<td>{{\App\vis::count()}}</td>
			</tr>
	<!-- 		<tr class="text-c">
				<td>今天</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
			<tr class="text-c">
				<td>昨天</td>
				<td>0</td>
				<td>1</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
			<tr class="text-c">
				<td>本周</td>
				<td>2</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr>
			<tr class="text-c">
				<td>本月</td>
				<td>2</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td>0</td>
			</tr> -->
		</tbody>
	</table>
	@endif
	<table class="table table-border table-bordered table-bg mt-20">
		<thead>
			<tr>
				<th colspan="2" scope="col">服务器信息</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="30%">服务器操作系统</th>
				<td><span id="lbServerName">@if(Auth::user()->is_root==1) {{PHP_OS}}@else 权限不足无法显示 @endif</span></td>
			</tr>
			<tr>
				<td>客户端设备类型 </td>
				<td>{{$_SERVER['HTTP_USER_AGENT']}}</td>
			</tr>
			<tr>
				<td>客户端语言 </td>
				<td>{{$_SERVER['HTTP_ACCEPT_LANGUAGE']}}</td>
			</tr>
			<tr>
				<td>客户端地区 </td>
				<td>{{$data['country'].'-'.$data['area'].'-'.$data['region'].'-'.$data['city'].'-'.$data['county']}}</td>
			</tr>
			<tr>
				<td>客户端网络类型 </td>
				<td>{{$data['isp']}}</td>
			</tr>
			<tr>
				<td>服务器时间 </td>
				<td>{{date("Y-m-d H:i:s")}}</td>
			</tr>
			<tr>
				<td>服务器时区 </td>
				<td>{{date_default_timezone_get()}}</td>
			</tr>
			<tr>
				<td>PHP运行方式</td>
				<td>@if(Auth::user()->is_root==1) {{ php_sapi_name()}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>服务器IP地址</td>
				<td>@if(Auth::user()->is_root==1) {{$_SERVER["SERVER_NAME"]}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>服务器域名 </td>
				<td>@if(Auth::user()->is_root==1) {{$_SERVER['HTTP_HOST']}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>服务器编译类型 </td>
				<td>@if(Auth::user()->is_root==1) {{$_SERVER['SERVER_SOFTWARE']}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>服务器端口 </td>
				<td>@if(Auth::user()->is_root==1){{ $_SERVER['SERVER_PORT']}} @else 权限不足无法显示 @endif</td>
			</tr>
			
			<tr>
				<td>服务器语言 </td>
				<td>@if(Auth::user()->is_root==1) {{ $_SERVER['HTTP_ACCEPT_LANGUAGE']}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>最大执行时间 </td>
				<td>@if(Auth::user()->is_root==1) {{ get_cfg_var("max_execution_time")."秒 "}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>脚本运行占用最大内存 </td>
				<td>@if(Auth::user()->is_root==1) {{ get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无"}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>ZEND版本 </td>
				<td>@if(Auth::user()->is_root==1) {{zend_version()}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>当前路径</td>
				<td>@if(Auth::user()->is_root==1) {{dirname(dirname(__FILE__))}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>当前进程用户名</td>
				<td>@if(Auth::user()->is_root==1) {{Get_Current_User()}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>PHP安装路径</td>
				<td>@if(Auth::user()->is_root==1) {{DEFAULT_INCLUDE_PATH}}@else 权限不足无法显示 @endif</td>
			</tr>
			
			<tr>
				<td>系统所在文件夹 </td>
				<td>@if(Auth::user()->is_root==1) {{base_path()}}@else 权限不足无法显示 @endif</td>
			</tr>
			<tr>
				<td>服务器端信息 </td>
				<td>@if(Auth::user()->is_root==1) {{$_SERVER ['SERVER_SOFTWARE']}}@else 权限不足无法显示 @endif</td>
			</tr>
			
		
		</tbody>
	</table>
</div>
@endsection
@section('js')
@endsection