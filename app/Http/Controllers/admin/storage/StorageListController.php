<?php

namespace App\Http\Controllers\admin\storage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\storage;
use Validator;

class StorageListController extends Controller
{
    public function list(Request $request)
    {
    	return view('storage.storage.list');
    }
    public function list_data(Request $request)
    {
    	$data=storage::select('storage.*','admin.admin_name')
    	->leftjoin('admin','storage.admin_id','admin.admin_id')
    	->where('storage.storage_status',1)
    	->get();
    	return json_encode(['code'=>0,'msg'=>'','count'=>$data->count(),'data'=>$data]);
    }

    /**
     * 新增仓库
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_storage(Request $request)
    {
        //新增产品
        if ($request->isMethod('get')) {
            return view('storage.storage.add_storage');
        }else if($request->isMethod('post')){
            $validator=Validator::make($request->all(),[
                "storage_name"=>"required",
            ]);
            if($validator->fails()){
                return response()->json(['err' => '0', 'msg' => $validator->errors()->first()]);
            }
            $storage = new storage();
            $storage->admin_id = Auth::user()->admin_id; //仓库创建人
            $storage->is_local = $request->input('is_local');
            $storage->is_split = $request->input('is_split');
            $storage->template_type_primary_id = $request->input('template_id');
            $storage->storage_name = $request->input('storage_name');
            $data = $storage->save();
            if($data){
                return response()->json(['err' => '0', 'msg' => '新增仓库失败']);

            }
            return response()->json(['err' => '0', 'msg' => '新增仓库成功']);
        }
    }
}
