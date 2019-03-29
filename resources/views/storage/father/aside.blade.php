<div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="/admin/storage/home">
            <span>仓储信息管理系统</span>
          </div>           
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
             <li data-name="home" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon layui-icon-home"></i>
                <cite>主页</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" class="layui-this">
                  <a lay-href="/admin/storage/blade?type=home/console.html">控制台</a>
                </dd>
            </li>
            @foreach($rules as $v)
              @if($v->rule_level==='0' && $v->rule_system===1)
              <li data-name="home" class="layui-nav-item">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon">{{$v->rule_icon}}</i>
                <cite>{{$v->rule_name}}</cite>
              </a>
              <dl class="layui-nav-child">
                @foreach($rules as $val)
                  @if($val->rule_level==$v->rule_id && $val->rule_system===1)
                    <dd data-name="console" class="">
{{--                      <a data-href="{{$val->rule_url}}" data-title="{{$val->rule_name}}" href="javascript:void(0)">{{$val->rule_name}}</a>--}}
                      <a lay-href="{{$val->rule_url}}">{{$val->rule_name}}</a>
                    </dd>
                  @endif
                @endforeach
              </dl>
            </li>
              @endif
            @endforeach
             <li data-name="home" class="layui-nav-item ">
              <a href="javascript:;" lay-tips="辅助工具" lay-direction="2">
                <i class="layui-icon layui-icon-star"></i>
                <cite>辅助工具</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="console" >
                  <a lay-href="http://baidu.com">Baidu</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="/admin/message/send_phone">短信推送</a>
                </dd>
                <dd data-name="console">
                  <a lay-href="/admin/message/send_mail">邮件推送</a>
                </dd>
                 <dd data-name="console">
                  <a lay-href="/admin/storage/jsq">科学计算器</a>
                </dd>
              </dl>
            </li>
          </ul>
         
 
        </div>
      </div>
