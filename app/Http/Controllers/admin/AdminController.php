<?php

namespace App\Http\Controllers\admin;

use App\role;
use App\rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\admin;
use Illuminate\Support\Facades\Auth;
use DB;
class AdminController extends Controller
{
    public function index(){
    	
    	$counts=admin::count();
    	return view('admin.admin.index')->with(compact('counts'));
    }

    /** 添加账户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function addadmin(Request $request){
    	if($request->isMethod('get')){
    		$roles=\App\role::get();
            $languages = admin::$LANGUAGES;
    		return view('admin.admin.addadmin')->with(compact('roles','languages'));
    	}elseif($request->isMethod('post')){
    	    $data=$request->except('_token');
    		$isuse=\App\admin::where('admin_name',$data['admin_name'])->first();
    		if($isuse!=null){
	                    return response()->json(['err'=>0,'str'=>'添加失败,账户名已被使用!']);
    		}
    		$admin=new admin();
    		$admin->admin_name=$data['admin_name'];
    		$admin->admin_is_order=$data['admin_is_order'];
    		$admin->password=password_hash($data['password'], PASSWORD_BCRYPT);
            $admin->admin_group=$data['admin_group_id'];
            $admin->languages=$data['languages'];
            $admin->admin_storage=$data['admin_storage'];
            $admin->admin_worker=$data['admin_worker'];
            $admin->admin_show_name=($data['admin_show_name']==null?$data['admin_name']:$data['admin_show_name']);
            if($data['attr'] == 0){
                $admin->admin_data_rule= $data['admin_data_rule0'];
            }else{
                $admin->admin_data_rule = $data['admin_data_rule1'];
            }
    		if($data['admin_role_id']==0){
    			$admin->is_root='1';
    			$admin->admin_role_id='1';
    		}else{
    			$admin->admin_role_id=$data['admin_role_id'];
    		}
    		$msg=$admin->save();
    		if($msg){
    			 $ip=$request->getClientIp(); 
    			$time=date('Y-m-d H:i:s',time());
    			\Log::notice("【".$ip."】".Auth::user()->admin_name."于【".$time."]添加了".$data['admin_name'].'-'.\App\role::where('role_id',$data['admin_role_id'])->first()['role_name']."账户");
                operation_log($ip,"添加账户成功，账户名称：".$data['admin_name'],json_encode($data));
    			return response()->json(['err'=>1,'str'=>'添加成功']);
	        }else{
    		    return response()->json(['err'=>0,'str'=>'添加失败']);
	        }
    	}
    }

    /** list列表信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request){
    		$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('admin')
            ->where(function($query){
                if(Auth::user()->is_root!='1'){
                    $query->whereIn('admin_id',\App\admin::get_group_ids(Auth::user()->admin_id));
                }
            })
	        ->count();
	        $newcount=DB::table('admin')
	        ->select('admin.*','role.role_name'	)
	        ->leftjoin('role','admin.admin_role_id','role.role_id')
	        ->orwhere(function($query) use($search){
	        	$query->where('admin.admin_name','like',"%$search%");
	        	$query->where('admin.admin_id','like',"%$search%");
	        	$query->where('role.role_name','like',"%$search%");
	        })
            ->where(function($query)use($request){
                if($request->input('group_name')!=0){
                    $query->where('admin_group',$request->input('group_name'));
                }
            })
	        ->count();
	        $data=DB::table('admin')
	        ->select('admin.*','role.role_name')
	        ->leftjoin('role','admin.admin_role_id','role.role_id')
	        ->orwhere(function($query) use($search){
	        	$query->where('admin.admin_name','like',"%$search%");
	        	$query->where('admin.admin_id','like',"%$search%");
	        	$query->where('role.role_name','like',"%$search%");
	        })
            ->where(function($query)use($request){
                if($request->input('group_name')!=0){
                    $query->where('admin_group',$request->input('group_name'));
                }
            })
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        foreach($data as $key => $v){
                $data[$key]->admin_group=\App\admin_group::where('admin_group_id',$v->admin_group)->first()['admin_group_name'];
	        	$goodsids=DB::table('goods')->where('goods_admin_id',$v->admin_id)->get(['goods_id'])->toArray();
		    	$newids='';
                $goodsidarr=[];
		    	foreach($goodsids as $k => $val){
		    		$newids.=$val->goods_id.',';
                    $goodsidarr[]=$val->goods_id;
		    	}
		    	$newids=rtrim($newids,',');
		    	if($newids==null){
		    		$data[$key]->day_sale=0;
		    	}else{
		    	    $time = date('Y-m-d',time());
                    //1.获取今天数据订单
                    $orders = \App\order::where('order_time','like',$time.'%')->where('order_goods_admin_id',$v->admin_id)->where(function($query){
                        $query->whereIn('order.order_type',\App\order::get_sale_type());
                        $query->where('order.is_del','0');
                    })->get();
                    $day_sales = 0;
                    if(!$orders->isEmpty()){
                        foreach ($orders as $item)
                        {   
                            $day_sales += $item->order_price * $item->currency_has_order->exchange_rate;
                        }
                    }
                    $data[$key]->day_sale=sprintf("%.2f",$day_sales);
//                    $day_sale=DB::select("select sum(`order`.order_price) as day_sale from `order`  where DateDiff(order.order_time,now())=0 and order.order_goods_id in ($newids)");
//                    if($day_sale[0]->day_sale==null){
//										$day_sale[0]->day_sale=0;
//										}
		    	}
/*                $day_sale=DB::table('order')->where([['order.order_admin_id',$v->admin_id],["DateDiff(order.order_time,now())",'0']])->sum('order.order_price');
*/           	
                $goods_num=DB::table('goods')->where([['goods.goods_admin_id',$v->admin_id],['goods.is_del','0']])->count();
                $data[$key]->goods_num=$goods_num;
                $orders_num=DB::table('order')->whereIn('order.order_goods_id',$goodsidarr)->where('order.is_del','0')->count();
                $data[$key]->orders_num=$orders_num;
                if($v->is_root=='1'){
                	$data[$key]->role_name="超级管理员";
                }
	        }
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }

    /** 删除商户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deladmin(Request $request){
    	$id=$request->input('id');
    	$admin_name  = admin::where('admin_id',$id)->value('admin_name');
    	$msg=\App\admin::where('admin_id',$id)->delete();
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'删除账户成功,账户名称：'.$admin_name);
            return response()->json(['err'=>1,'str'=>'删除成功']);
	   	}else{
		   	return response()->json(['err'=>0,'str'=>'删除失败']);
	   	}
    }

    /** 账户设置为超管
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ch_root(Request $request){
    	$id=$request->input('id');
        $admin_name = admin::where('admin_id',$id)->value('admin_name');
        $msg=\App\admin::where('admin_id',$id)->first();
    	$msg->is_root='1';
    	$msg1=$msg->save();
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'设置账户超管权限,账户名称：'.$admin_name);
	   	    return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }

    /** 取消账户超管权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cl_root(Request $request){
    	$id=$request->input('id');
    	$admin_name = admin::where('admin_id',$id)->value('admin_name');
    	$msg=\App\admin::where('admin_id',$id)->first();
    	$msg->is_root='0';
    	$msg1=$msg->save();
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'取消账户超管权限,账户名称：'.$admin_name);
	   	    return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }

    /** 禁用账户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unuse(Request $request){
    	$id=$request->input('id');
        $admin_name = admin::where('admin_id',$id)->value('admin_name');
        $msg=\App\admin::where('admin_id',$id)->first();
    	$msg->admin_use='0';
    	$msg1=$msg->save();
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'禁用账户成功,账户名称：'.$admin_name);
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }

    /** 启用账户
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function opuse(Request $request){
    	$id=$request->input('id');
        $admin_name = admin::where('admin_id',$id)->value('admin_name');
        $msg=\App\admin::where('admin_id',$id)->first();
    	$msg->admin_use='1';
    	$msg=$msg->save();
    	if($msg){
            $ip = $request->getClientIp();
            //加log日志
            operation_log($ip,'启用账户成功,账户名称：'.$admin_name);
	   	    return response()->json(['err'=>1,'str'=>'更改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
	   	}
    }

    /** 修改账户信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function upadmin(Request $request){
    	if($request->isMethod('get')){
            $languages = admin::$LANGUAGES;
            $admin=\App\admin::where('admin_id',$request->input('id'))->first();
    		return view('admin.admin.upadmin')->with(compact('admin','languages'));
    	}else if($request->isMethod('post')){
//    		$data=$request->all();
    		$data=$request->except('_token');
            $id=$request->input('admin_id');
    		$admin=\App\admin::where('admin_id',$id)->first();
    		$admin->admin_name=$data['admin_name'];
    		$admin->admin_is_order=$data['admin_is_order'];
            $admin->admin_group=$data['admin_group_id'];
            $admin->languages=$data['languages'];
            $admin->admin_storage=$data['admin_storage'];
            $admin->admin_worker=$data['admin_worker'];
            $admin->admin_show_name=($data['admin_show_name']==null?$data['admin_name']:$data['admin_show_name']);
            if($data['attr'] == 0){
                $admin->admin_data_rule= $data['admin_data_rule0'];
            }else{
                $admin->admin_data_rule = $data['admin_data_rule1'];
            }
    		if($data['role_id']==0){
    			$admin->is_root='1';

    		}else{
    			$admin->admin_role_id=$data['role_id'];

    		}
    		if($data['password']!=''&&$data['password']!=null){
    			$admin->password=password_hash($data['password'], PASSWORD_BCRYPT);
                 \Log::notice(\Auth::user()->admin_name.'于'.date('Y-m-d H:i:s',time()).'修改了'.$admin->admin_name.'['.$admin->admin_id.']的密码，新密码为:'.$data['password']);
    		}
    		$msg=$admin->save();
    		if($msg){
                $ip = $request->getClientIp();
                //加log日志
                operation_log($ip,'修改账户信息成功,账户名称：'.$data['admin_name'],json_encode($data));
	   	    	return response()->json(['err'=>1,'str'=>'更改成功']);
		   	}else{
			   	    	return response()->json(['err'=>0,'str'=>'更改失败']);
		   	}
    	}
    }

    /** 添加角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function addrole(Request $request){
    	if($request->isMethod('get')){
    		return view('admin.admin.addrole');
    	}else if($request->isMethod('post')){
    		$role=new \App\role;
    		$role->role_name=$request->input('role_name');
    		$msg=$role->save();
    		if($msg){
                $ip = $request->getClientIp();
                //加log日志
                operation_log($ip,'新增角色,角色名称：'.$request->input('role_name'));
	   	    	return response()->json(['err'=>1,'str'=>'添加成功']);
		   	}else{
			   	    	return response()->json(['err'=>0,'str'=>'添加失败']);
		   	}
    	}
    }

    /** 权限分配
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chrole(Request $request){
    	if($request->isMethod('get')){
    		return view('admin.admin.chrole');
    	}else if($request->isMethod('post')){
    		$id=$request->input('id');
    		$rules=DB::table('role')
    		->select('role.*','rule.*')
    		->leftjoin('role_rule','role.role_id','role_rule.roleid')
    		->leftjoin('rule','role_rule.ruleid','rule.rule_id')
    		->where('role_rule.roleid',$id)
    		->get();
    		$useid=[];
    		foreach ($rules as $key => $value) {
    			$useid[]=$value->rule_id;
    		}
    		$allrule=\App\rule::get();

    		return view('admin.admin.ajaxrole')->with(compact('rules','allrule','useid'));
    	}
    }

    /** 分配角色权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkbox(Request $request){
    	$data=$request->all();
    	$id=$request->input('role_id');
    	\App\role_rule::where('roleid',$id)->delete();
    	$array = '';
    	foreach($data['rules'] as $v){
    		$role_rule=new \App\role_rule;
    		$role_rule->roleid=$id;
    		$role_rule->ruleid=$v;
    		$role = $role_rule->save();
    		if($role){
    		    $array .= rule::where('rule_id',$v)->value('rule_name') .',';
            }
    	}
        $ip = $request->getClientIp();
        //加log日志
        operation_log($ip,role::where('role_id',$id)->value('role_name').' 权限配置成功,拥有权限：'.$array);
	   	return response()->json(['err'=>1,'str'=>'分配成功']);
    }

    //个人信息弹窗
    public function layershow(){
    	$admin=\App\admin::where('admin_id',Auth::user()->admin_id)->first();
    	$admin->admin_role_id=\App\role::where('role_id',$admin->admin_role_id)->first()['role_name'];
    	$admin_goods_count=\App\goods::where('goods_admin_id',$admin['admin_id'])->where('is_del','0')->count();
    	$id=Auth::user()->admin_id;
    	$goodsids=DB::table('goods')->where('goods_admin_id',$id)->get(['goods_id'])->toArray();
    	$newids='';
    	foreach($goodsids as $key => $v){
    		$newids.=$v->goods_id.',';
    	}
    	$newids=rtrim($newids,',');
    	if($newids!=''&&$newids!=null){
                $allow=\App\order::get_sale_type(false);
    	    	$daysale=DB::select("select sum(`order`.order_price) as day_sale from `order`  where DateDiff(order.order_time,now())=0 and order.order_goods_id in ($newids) and order.order_type in ({$allow})");
    	    	if($daysale[0]->day_sale==null){
		    		$daysale=0;
		    	}else{
		    		$daysale=$daysale[0]->day_sale;
		    	}
    	}else{
    		$daysale=0;
    	}
    	
    	return view('admin.admin.layershow')->with(compact('admin','admin_goods_count','daysale'));
    }

    /** 添加分组
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function addgroup(Request $request){
        if($request->isMethod('get')){
            $group=\App\admin_group::get();
            return view('admin.admin.addgroup')->with(compact('group'));
        }elseif($request->isMethod('post')){
            $group=new \App\admin_group();
            $group->admin_group_name=$request->input('admin_group_name');
            $group->admin_group_rule=$request->input('admin_group_rule');
            $msg=$group->save();
            if($msg){
                $ip = $request->getClientIp();
                //加log日志
                operation_log($ip,'添加分组成功,新组名：'.$request->input('admin_group_name'));
                return response()->json(['err'=>1,'str'=>'添加成功']);
            }else{
                return response()->json(['err'=>0,'str'=>'添加失败']);
            }
        }
    }
}
