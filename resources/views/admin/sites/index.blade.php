@extends('admin.father.css')
@section('content')
    <div class="page-container">
        <div class="text-c"> 日期范围：
            <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d %H:%m:%s\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss', minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d %H:%m:%s' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <!-- <input type="text" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name=""> -->
            <button type="submit" class="btn btn-success" id="seavis" name=""><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>

            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                <button type="submit" class="btn btn-success" style="border-radius: 8%;" id="add-site" name=""><i class="Hui-iconfont">&#xe604;</i> 新增站点</button>
                </span>
                <br>
                <div class="mt-20 skin-minimal">
                    <div id="select-admin">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">账户名：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                            <span class="select-box">
                                <select name="admin_id" id="admin_id" class="select">
					                <option value="0">所有</option>
                                    @foreach($admins as $val)
                                        <option value="{{$val->admin_id}}" >{{$val->admin_name.'('.$val->admin_show_name.')'}}</option>
                                    @endforeach
                                </select>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <table class="table table-border table-bordered table-bg" id="vis_index_table">
                    <thead>
                    <tr>
                        <th scope="col" colspan="15">站点列表</th>
                    </tr>
                    <tr class="text-c">
                        <th width="40">ID</th>
                        <th width="80">站点名称</th>
                        <th width="60">使用模板</th>
                        <th width="60">绑定域名</th>
                        <th width="60">是否启用</th>
                        <th width="60">发布人</th>
                        <th width="30">创建时间</th>
                        <th width="60">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        </div>
    </div>
    </div>

@endsection
@section('js')

    <script type="text/javascript">
        $.tablesetting={
            "lengthMenu": [[10,20],[10,20]],
            "paging": true,
            "info":   true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "desc" ]],
            "stateSave": false,
            "columnDefs": [{
                "targets": [1,2,3,4,5,6],
                "orderable": false
            }],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{url('admin/sites/get_table')}}",
                "type": "POST",
                "data":{
                    mintime:function(){return $('#datemin').val()},
                    maxtime:function(){return $('#datemax').val()},
                    admin_id:function(){return $('#admin_id').val()},
                },
                'headers': { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
            },
            "columns": [
                {"data":'sites_id'},
                {"data":'sites_name'},
                {"data":'sites_blade_type'},
                {'defaultContent':"","className":"td-manager"},
                {'defaultContent':"","className":"td-manager"},
                {'data':'admin_show_name'},
                {'data':'created_at'},
                {'defaultContent':"","className":"td-manager"}
            ],

            "createdRow":function(row,data,dataIndex){
                var info='<a title="编辑" href="javascript:;" onclick="sites_update(\'站点编辑\',\'{{url("admin/sites/post_update")}}?id='+data.sites_id+'\',\'2\',\'1400\',\'800\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></span></a><a title="删除" href="javascript:;" onclick="del_sites(\''+data.sites_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="删除"><i class="Hui-iconfont">&#xe609;</i></span></a><a title="复制" href="javascript:;" onclick="site_copy('+data.sites_id+')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="复制"><i class="Hui-iconfont Hui-iconfont-copy"></i></span></a>';
                if(data.url_type==0||data.url_type==null){
                    var isroot='<span class="label label-default radius">×</span>';
                    if(data.url_url!=null){
                        info+='<a title="启用" href="javascript:;" onclick="goods_online(\''+data.url_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="启用"><i class="Hui-iconfont">&#xe601;</i></span></a>'
                    }else{
                        info+='<a title="域名绑定" href="{{url("admin/url/goods_url")}}"  class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="域名绑定"><i class="Hui-iconfont">&#xe601;</i></span></a>'
                    }

                }else{
                    var isroot='<span class="label label-success radius">√</span>';
                    info+='<a title="停止" href="javascript:;" onclick="goods_close(\''+data.url_id+'\')" class="ml-5" style="text-decoration:none"><span class="btn btn-primary" title="停止"><i class="Hui-iconfont">&#xe6e4;</i></span></a>'
                }
                var url='<a href="http://'+data.url_url+'" style="margin:0px auto;" target="view_window" >'+data.url_url ? data.url_url : ''+'</a>';

                /*var info='<a title="编辑" href="javascript:;" onclick="member_edit(\'编辑\',\'member-add.html\',4,\'\',510)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="member_del(this,1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';*/
                $(row).find('td:eq(7)').html(info);
                $(row).find('td:eq(4)').html(isroot);
                $(row).find('td:eq(3)').html(url);
                $(row).addClass('text-c');
            }
        }
        dataTable =$('#vis_index_table').DataTable($.tablesetting);
        // $('#seavis').on('click',function(){
        //     dataTable.draw(); //重绘表格
        // })
        // $('#getvis').on('click',function(){
        //     $('#select-admin').toggle(300);
        // })
        // $('.radio-pb').on('click',function(){
        //     dataTable.draw();
        // });
        $('#admin_id').on('change',function(){
            dataTable.ajax.reload();
            var args = dataTable.ajax.params();
        });
        $('#add-site').on('click',function () {
            layer_show('新增站点','/admin/sites/add',1200,800);
        });
        //删除站点
        function del_sites(id) {
            var msg =confirm("确定要删除此站点吗？删除站点后将自动解除绑定域名。");
            if(msg){
                layer.msg('删除中');
                $.ajax({
                    url:"{{url('admin/sites/delete_site')}}",
                    type:'get',
                    data:{'id':id},
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.msg(msg.str);
                            $('#vis_index_table').dataTable().fnClearTable();
                        }else if(msg['err']==0){
                            layer.msg(msg.str);
                        }else{
                            layer.msg('解封失败！');
                        }
                    }
                })
            }else{

            }
        }
        //启动站点
        function goods_online(id){
            var msg =confirm("确定要启用此站点吗？");
            if(msg){
                layer.msg('启用中');
                $.ajax({
                    url:"{{url('admin/goods/online')}}",
                    type:'get',
                    data:{'id':id},
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.msg(msg.str);
                            $('#vis_index_table').dataTable().fnClearTable();
                        }else if(msg['err']==0){
                            layer.msg(msg.str);
                        }else{
                            layer.msg('启动失败！');
                        }
                    }
                })

            }else{

            }
        }
        //关闭站点
        function goods_close(id){
            var msg =confirm("确定要下线此站点吗？");
            if(msg){
                layer.msg('操作中');
                $.ajax({
                    url:"{{url('admin/goods/close')}}",
                    type:'get',
                    data:{'id':id},
                    datatype:'json',
                    success:function(msg){
                        if(msg['err']==1){
                            layer.msg(msg.str);
                            $('#vis_index_table').dataTable().fnClearTable();
                            /*$(".del"+id).prev("input").remove();
                         $(".del"+id).val('已删除');*/
                        }else if(msg['err']==0){
                            layer.msg(msg.str);
                        }else{
                            layer.msg('下线失败！');
                        }
                    }
                })

            }else{

            }
        }
        $('#outvis').on('click',function(){
            location.href='{{url("admin/vis/outvis")}}'+'?mintime='+$('#datemin').val()+'&maxtime='+$('#datemax').val()+'&chvis='+$('#admin_vis').val()+'&ispb='+$('input[name="ispb"]:checked').val()+'&search='+$('[type="search"]').val();
        })
        function sites_update(title,url,type,w,h){
            layer_show(title,url,w,h);
        }
        function site_copy(id) {
            layer_show('复制单品','{{url("/admin/sites/site_copy")}}?id='+id,400,300);
        }
    </script>
@endsection