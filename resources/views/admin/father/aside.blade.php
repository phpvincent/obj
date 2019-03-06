<div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="/admin/storage/home">
            <span>信息管理系统</span>
          </div>
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            @foreach($rules as $v)
              @if($v->rule_level==='0' && $v->rule_system===0)
              <li data-name="home" class="layui-nav-item">
              <a href="javascript:;" lay-tips="主页" lay-direction="2">
                <i class="layui-icon">{{$v->rule_icon}}</i>
                <cite>{{$v->rule_name}}</cite>
              </a>
              <dl class="layui-nav-child">
                @foreach($rules as $val)
                  @if($val->rule_level==$v->rule_id && $val->rule_system===0)
                    <dd data-name="console" class="layui-this">
{{--                      <a data-href="{{$val->rule_url}}" data-title="{{$val->rule_name}}" href="javascript:void(0)">{{$val->rule_name}}</a>--}}
                      <a lay-href="{{$val->rule_url}}">{{$val->rule_name}}</a>
                    </dd>
                  @endif
                @endforeach
              </dl>
            </li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
