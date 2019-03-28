<?php

namespace App\Http\Controllers\admin\storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage_log;
class StorageLogController extends Controller
{
    public function index(Request $request)
    {
    	if($request->isMethod('get')){
    		return view('storage.log.index');
    	}elseif($request->isMethod('post')){
    		$page = $request->input('page', 1);
	        $limit = $request->input('limit', 10);
	        $search = trim($request->input('search'));
	        $storage_log_type=$request->input('storage_log_type','#');
	        //排序参数
	        $field = $request->input('field', 'created_at'); //排序字段
	        $dsc = $request->input('order', 'desc'); //排序顺序
	        $start = ($page - 1) * $limit;
	        $storage_logs = storage_log::select('storage_log.*','admin.admin_show_name')
	            ->leftjoin('admin','storage_log.storage_log_admin_id','admin.admin_id')
	            ->where(function ($query) use ($request,$search,$storage_log_type){
	                if($search){
	                    $query->where('storage_log.storage_log_id','like','%'.$search.'%');
	                    $query->orWhere('admin.admin_show_name','like','%'.$search.'%');
	                }
	                if($request->has('created_at')&&$request->input('created_at')!=null){
	                    $query->whereBetween('created_at',[explode(' - ',$request->input('created_at'))[0],explode(' - ',$request->input('created_at'))[1]]);
	                }
	                if($storage_log_type!='#'){
	                    $query->where('storage_log.storage_log_type',$storage_log_type);
	                }
	                if($request->has('is_danger')&&$request->input('is_danger')!='#'){
	                	$query->where('is_danger',$request->input('is_danger'));
	                }
	            })
	            ->orderBy($field, $dsc)
	            ->offset($start)
	            ->limit($limit)
	            ->get();
	        $count=storage_log::select('storage_log.*','admin.admin_show_name')
	            ->leftjoin('admin','storage_log.storage_log_admin_id','admin.admin_id')
	            ->where(function ($query) use ($request,$search,$storage_log_type){
	                if($search){
	                    $query->where('storage_log.storage_log_id','like','%'.$search.'%');
	                    $query->orWhere('admin.admin_show_name','like','%'.$search.'%');
	                }
	                if($request->has('created_at')&&$request->input('created_at')!=null){
	                    $query->whereBetween('created_at',[explode(' - ',$request->input('created_at'))[0],explode(' - ',$request->input('created_at'))[1]]);
	                }
	                if($storage_log_type!='#'){
	                    $query->where('storage_log.storage_log_type',$storage_log_type);
	                }
	                if($request->has('is_danger')&&$request->input('is_danger')!='#'){
	                	$query->where('is_danger',$request->input('is_danger'));
	                }
	            })
	            ->count();
	        if($count > 0){
	            foreach ($storage_logs as &$storage_log){
	                $storage_log->admin_show_name=($storage_log->admin_show_name==null?'系统':$storage_log->admin_show_name);
	                if($storage_log->storage_log_type==1){
	                	$storage_log->storage_log_type='补货单操作';
	                }elseif($storage_log->storage_log_type==2){
	                	$storage_log->storage_log_type='库存数据相关操作';
	                }elseif($storage_log->storage_log_type==3){
	                	$storage_log->storage_log_type='仓库数据相关操作';
	                }elseif($storage_log->storage_log_type==4){
	                	$storage_log->storage_log_type='数据校准相关操作';
	                }elseif($storage_log->storage_log_type==5){
	                	$storage_log->storage_log_type='订单扣货相关操作';
	                }elseif($storage_log->storage_log_type==6){
	                	$storage_log->storage_log_type='订单出仓相关操作';
	                }
	                if($storage_log->is_danger==1){
	                	$storage_log->is_danger='是';
	                }else{
	                	$storage_log->is_danger='否';
	                }
	            }
	        }

	        $arr = ['code' => 0, "msg" => "获取数据成功",'count'=>$count ,'data' => $storage_logs];
	        return response()->json($arr);
	    	} 
    }
    public function del_log(Request $request)
    {	
    	if(\Auth::user()->is_root!='1'){
           return response()->json(['err' => 0, 'str' => '删除失败！只有超级管理员有此权限！']);
    	}
    	if($request->has('id')){
    		$msg=\App\storage_log::where('storage_log_id',$request->input('id'))->delete();
    	}elseif($request->has('ids')){
    		$msg=\App\storage_log::whereIn('storage_log_id',$request->input('ids'))->delete();
    	}
    	 if(!$msg){
           return response()->json(['err' => 0, 'str' => '删除失败！']);
        }
        return response()->json(['err' => 1, 'str' => '删除成功！']);
    }
    public function log_show(Request $request)
    {
    	$id=$request->input('storage_log_id');
    	$storage_log=\App\storage_log::where('storage_log_id',$id)->first();
    	switch ($storage_log->storage_log_type) {
    		case '1':
    		//补货单操作
    		
    			break;
    		case '4':
    		//仓库校准
    		$storage_log_data=\App\storage_log_data::where('storage_log_primary_id',$id)->first();
    		return view('storage.log.log_show4')->with(compact('storage_log',$storage_log_data));
    			break;
    		case '5':
    		//仓库扣货
    		$storage_log_data=\App\storage_log_data::where('storage_log_primary_id',$id)->first();
    		return view('storage.log.log_show5')->with(compact('storage_log',$storage_log_data));
    			break;
    		default:
    			return '无具体数据';
    			break;
    	}
    }
}
