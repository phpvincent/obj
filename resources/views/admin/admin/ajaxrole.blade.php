

<div class="formControls col-xs-8 col-sm-9">
	@foreach($allrule as $key => $v)
		@if($v->rule_level=='0')
				<dl class="permission-list">
					<dt>
						<label>
							<input type="checkbox" value="{{$v->rule_id}}" name="rules[]" id="user-Character-0" @if(in_array($v->rule_id,$useid)) checked="checked" @endif >
							{{$v->rule_name}}</label>
					</dt>
					<dd>
						<dl class="cl permission-list2">
							<!-- <dt>
								<label class="">
									<input type="checkbox" value="" name="user-Character-0-0" id="user-Character-0-0">
									栏目管理</label>
							</dt> -->
							<dd>
								@foreach($allrule as $k =>$val)
									@if($val->rule_level==$v->rule_id)
								<label class="">
									<input type="checkbox" value="{{$val->rule_id}}" name="rules[]" id="user-Character-0-0-0" @if(in_array($val->rule_id,$useid)) checked="checked" @endif >
									{{$val->rule_name}}</label>
									@endif
								@endforeach
<!-- 								<label class="c-orange"><input type="checkbox" value="" name="user-Character-0-0-0" id="user-Character-0-0-5"> 只能操作自己发布的</label>
 -->							</dd>
						</dl>	
						</dd>
				</dl>
				
		@endif
	@endforeach
				
			</div>
		</form>


<script type="text/javascript">
	$(function(){
	$(".permission-list dt input:checkbox").click(function(){
		$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
	});
	$(".permission-list2 dd input:checkbox").click(function(){
		var l =$(this).parent().parent().find("input:checked").length;
		var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
		if($(this).prop("checked")){
			$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
			$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
		}
		else{
			if(l==0){
				$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
			}
			if(l2==0){
				$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
			}
		}
	});
});
</script>
