<aside class="Hui-aside">
	<div class="menu_dropdown bk_2">
		@foreach($rules as $v)
		<dl id="menu-article">
			@if($v->rule_level=='0')
			<dt><i class="Hui-iconfont">{{$v->rule_icon}}</i>	{{$v->rule_name}}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					@foreach($rules as $val)
						@if($val->rule_level==$v->rule_id)
					<li><a data-href="{{$val->rule_url}}" data-title="{{$val->rule_name}}" href="javascript:void(0)">{{$val->rule_name}}</a></li>
					 	@endif
					@endforeach
				</ul>
			</dd>
			@endif
		</dl>
		@endforeach
		@if(\Auth::user()->admin_storage==1||\Auth::user()->is_root==1)
		<dl id="menu-picture">
			<dt><i class="Hui-iconfont">&#xe613;</i> 仓储信息管理系统<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ol>
					<li><a data-href="/admin/storage/index" data-title="进入系统" onclick="parent.location.href='/admin/storage/index';" >进入系统</a></li>
			</ol>
			</dd>
		</dl>
		@endif
</div>
</aside>