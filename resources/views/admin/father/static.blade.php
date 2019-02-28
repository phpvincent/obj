  <link rel="stylesheet" href="{{asset('/admin/layuiadmin/layui/css/layui.css')}}" media="all">
  <link rel="stylesheet" href="{{asset('/admin/layuiadmin/style/admin.css')}}" media="all">
@yield('content')
  <script src="{{asset('/admin/layuiadmin/layui/layui.js')}}"></script>
  <script src="{{asset('/admin/layuiadmin/lib/index.js')}}"></script>
  <script src="{{asset('/admin/layuiadmin/layui/layui.js?t=1')}}"></script>  
  <script src="{{asset('/admin/layuiadmin/lib/admin.js')}}"></script>  
  <script src="{{asset('/admin/layuiadmin/modules/common.js')}}"></script>  
@yield('js')