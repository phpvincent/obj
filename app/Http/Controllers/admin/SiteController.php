<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods_type;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * 站点列表首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $counts=DB::table('sites')->whereIn('sites_admin_id',admin::get_admins_id())->where('status','0')->count();
        $admins = admin::whereIn('admin_id',admin::get_admins_id())->get();
        return view('admin.sites.index')->with(compact('counts','admins'));
    }

    /**
     * 表格数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_table(Request $request)
    {
        $info=$request->all();
        if(isset($info['order'])){
            $cm=$info['order'][0]['column'];
            $dsc=$info['order'][0]['dir'];
            $order=$info['columns']["$cm"]['data'];
        }else{
            $dsc='desc';
            $order='sites_id';
        }

        $draw=isset($info['draw']) ? $info['draw'] : 1;
        $start=$info['start'];
        $len=$info['length'];
        $search=trim($info['search']['value']);
        $counts=DB::table('sites')
            ->where(function($query){
                if(Auth::user()->is_root!='1'){
                    $query->whereIn('sites_admin_id',admin::get_admins_id());
                }
                $query->where('status','0');
            })
            ->where(function($query)use($request) {
                $admin_id = $request->input('admin_id');
                if($admin_id!=0){
                    $query->where('sites.sites_admin_id',$admin_id);
                }
            })
            ->count();

        $newcount=DB::table('sites')
            ->select('sites.*','url.url_url','url.url_type')
            ->leftjoin('url','sites.sites_id','=','url.url_site_id')
            ->where('sites.status',0)
            ->where(function($query)use($search){
                $query->where('sites.sites_name','like',"%$search%");
            })
            ->where(function($query)use($request) {
                $admin_id = $request->input('admin_id');
                if($admin_id!=0){
                    $query->where('sites.sites_admin_id',$admin_id);
                }
            })
            ->count();
        $data=DB::table('sites')
            ->select('sites.*','url.url_url','url.url_type','admin.admin_show_name')
            ->leftjoin('url','sites.sites_id','=','url.url_site_id')
            ->join('admin','sites.sites_admin_id','=','admin.admin_id')
            ->where('sites.status',0)
            ->where(function($query)use($search){
                $query->where('sites.sites_name','like',"%$search%");
            })
            ->where(function($query)use($request) {
                $admin_id = $request->input('admin_id');
                if($admin_id!=0){
                    $query->where('sites.sites_admin_id',$admin_id);
                }
            })
            ->orderBy($order,$dsc)
            ->offset($start)
            ->limit($len)
            ->get();

        foreach ($data as &$item)
        {
            $item->sites_blade_type = admin::getBladeName($item->sites_blade_type);
        }

        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
        return response()->json($arr);
    }

    public function add(Request $request)
    {
        if($request->isMethod('get')) {
            $goods_type = goods_type::all();
            return view('admin.sites.add')->with(compact('goods_type'));
        }elseif($request->isMethod('post')){

        }
    }
}
