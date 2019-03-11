<?php

namespace App\Http\Controllers\admin\storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage;
class StorageListController extends Controller
{
    public function list(Request $request)
    {
    	return view('storage.storage.list');
    }
    public function list_data(Request $request)
    {
    	$page = $request->input('page',1);
        $limit = $request->input('limit',10);
        $start = ($page-1)*$limit;
    	$data=storage::select('storage.*','admin.admin_name')
    	->leftjoin('admin','storage.admin_id','admin.admin_id')
    	->where('storage.storage_status',1)
    	->offset($start)
        ->limit($limit)
    	->get();
    	return json_encode(['code'=>0,'msg'=>'','count'=>$data->count(),'data'=>$data]);
    }
    public function del_storage(Request $request)
    {
    	$msg=storage::where('storage_id',$request->input('id',0))->update(['storage_status'=>0]);
    	if($msg){
    		\Log::notice($request->getClientIp().'禁用了仓库:'.$request->input('id'));
    		return response()->json(['err'=>1,'str'=>'仓库禁用成功！']);
    	}
    	return response()->json(['err'=>0,'str'=>'仓库禁用失败！']);
    }
}
