<?php

namespace App\Http\Controllers\admin\storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage;
use Validator;
use Illuminate\Support\Facades\Auth;

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

    /**
     * 新增仓库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_storage(Request $request)
    {
        //新增仓库
        if ($request->isMethod('get')) {
            return view('storage.storage.add_storage');
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "storage_name" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storages = storage::where('storage_name',$request->input('storage_name'))->first();
            if($storages){
                return response()->json(['err' => '0', 'msg' => '仓库已存在，请更换仓库名称']);
            }
            $storage = new storage();
            $storage->admin_id = Auth::user()->admin_id; //仓库创建人
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            if ($data) {
                return response()->json(['err' => '1', 'msg' => '新增仓库成功']);
            }
            return response()->json(['err' => '0', 'msg' => '新增仓库失败']);
        }
    }

    /**
     * 修改仓库信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function up_storage(Request $request){
        //修改仓库信息
        if ($request->isMethod('get')) {
            $id = $request->input('id');
            $storage = storage::where('storage_id',$id)->first();
            if($storage){
                return view('storage.storage.up_storage')->with(compact('storage'));
            }
        } else if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                "storage_name" => "required",
            ]);
            if ($validator->fails()) {
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storage = storage::where('storage_id',$request->input('id'))->first();
            if(!$storage){
                return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
            }
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            if ($data) {
                return response()->json(['err' => '1', 'msg' => '修改仓库信息成功']);
            }
            return response()->json(['err' => '0', 'msg' => '修改仓库信息失败']);
        }
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
