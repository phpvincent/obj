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
    	$data=storage::select('storage.*','admin.admin_name')
    	->leftjoin('admin','storage.admin_id','admin.admin_id')
    	->where('storage.storage_status',1)
    	->get();
    	return json_encode(['code'=>0,'msg'=>'','count'=>$data->count(),'data'=>$data]);
    }
}
