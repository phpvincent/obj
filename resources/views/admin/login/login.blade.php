<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Expires" content="0"> 
<title>后台管理</title>
<link href="/css/admin/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/layer/layer.js"></script>
</head>

<body>
<div class="login_box">
  @if(count($errors)>0)
                   
                        <script type="text/javascript">var errors='';</script>
                         @foreach($errors->all() as $error)
                         <script type="text/javascript">errors+='{{ $error }}'+"<br/>" </script>
                         @endforeach
                         <script type="text/javascript">layer.msg(errors)</script>    
  @endif
      <div class="login_l_img"><img src="/images/login-img.png" /></div>
      <div class="login">
          <div class="login_logo"><a href="#"><img src="/images/ydzs.jpg" /></a></div>
          <div class="login_name">
               <p>后台信息管理系统</p>
          </div>
          <form method="post" action="{{ route('login') }}">
              <input name="username" type="text"   placeholder="用户名"  value="{{old('username')}}" >
<!--               <span id="password_text" onclick="this.style.display='none';document.getElementById('password').style.display='block';" >密码</span>
 -->              <input name="password" type="password" id="password" placeholder="密码" value="" />
               <div class="form-group">
                <img src="{{captcha_src()}}" onclick="this.src='http://{{$_SERVER['SERVER_NAME']}}/captcha/default?l6rrkGyy'+Math.random()" style="margin-left: 80px;"> 
                 <br/>
                   <input type="text" class="form-control" id="captcha" placeholder="验证码" autocomplete="off" name="captcha">
               </div>
               {{csrf_field()}}
              <input value="登录" style="width:100%;" type="submit">
          </form>
      </div>
      <div class="copyright">一代宗师国医馆 版权所有©2016-2018 技术支持电话：000-00000000</div>
</div>
<div style="text-align:center;">
</div>
</body>
</html>
