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
		<!-- <dl id="menu-picture">
			<dt><i class="Hui-iconfont">&#xe613;</i> 图片管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="picture-list.html" data-title="图片管理" href="javascript:void(0)">图片管理</a></li>
			</ul>
		</dd>
	</dl> -->
	
</div>
</aside>