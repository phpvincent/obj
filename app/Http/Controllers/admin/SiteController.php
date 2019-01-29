<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods_type;
use App\site;
use App\site_active;
use App\site_active_good;
use App\site_class;
use App\site_img;
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
            //1.站点名称不可以重复
            $site_name = $request->input('site_name');
            $site = site::where('sites_name',$site_name)->first();
            if($site){
                return response()->json(['err'=>0,'str'=>'站点名称不可以重复']);
            }
            $site = new site();
            $site->sites_name = $site_name;
            $site->sites_blade_type = $request->input('goods_blade_type');
            $site->sites_admin_id = Auth::user()->admin_id;
            $site->status = 0;
            $site_data = $site->save();
            if(!$site_data){
                return response()->json(['err'=>0,'str'=>'站点信息保存失败']);
            }
            //站点轮播图
            $size_file = $request->file('size_file');
            $goods = $request->input('goods');
            $plant = [];
            foreach ($size_file as $k=>$item){
                if(filesize($item) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $name=$item->getClientOriginalName();//得到视频名；
                $ext=$item->getClientOriginalExtension();//得到视频后缀；
                $fileName=md5(uniqid($name));
                $newfilename='site'."_".$fileName.'.'.$ext;//生成新的的文件名
                $filedir="upload/site_imgs/";
                $msg=$item->move($filedir,$newfilename);
                if(!$msg){
                    return response()->json(['err'=>0,'str'=>'文件上传失败']);
                }
                $arr['site_img']=$filedir.$newfilename;
                $arr['site_goods_id']=$goods[$k];
                $arr['site_site_id'] = $site->sites_id;
                array_push($plant,$arr);
            }

            $data_site_img = site_img::insert($plant);
            if(!$data_site_img){
                return response()->json(['err'=>0,'str'=>'新增站点失败']);
            }
            //站点分类
            $goods_type_id = $request->input('goods_type_id');
            $goods_type_show_name = $request->input('goods_type_show_name');
            $goods_type_isshow = $request->input('goods_type_isshow');
            $goods_type_sort = $request->input('goods_type_sort');
            $site_class = [];
            foreach ($goods_type_id as $key=>$item) {
                $arr['site_class_sort'] = $goods_type_sort[$key];
                $arr['site_class_show_name'] = $goods_type_show_name[$key];
                $arr['site_goods_type_id'] = $item;
                $arr['site_is_show'] = isset($goods_type_isshow[$key]) ? 0 : 1;
                $arr['site_site_id'] = $site->sites_id;
                array_push($site_class,$arr);
            }

            $data_class = site_class::insert($site_class);
            if(!$data_class){
                return response()->json(['err'=>0,'str'=>'新增站点失败']);
            }

            //特殊分类 //1.新品推荐;2.秒杀抢购;3.热卖推荐
            $site_active = $request->input('site_active');
            foreach ($site_active as $key => $value){
                $img = $request->file($site_active[$key]['img']);
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $name=$img->getClientOriginalName();//得到视频名；
                $ext=$img->getClientOriginalExtension();//得到视频后缀；
                $fileName=md5(uniqid($name));
                $newfilename='site_active'."_".$fileName.'.'.$ext;//生成新的的文件名
                $filedir="upload/site_imgs/";
                $msg=$img->move($filedir,$newfilename);
                if(!$msg){
                    return response()->json(['err'=>0,'str'=>'文件上传失败']);
                }
                $ss = new site_active();
                $ss->site_active_img = $filedir.$newfilename;
                $ss->site_active_type = $key;
                $ss->site_id = $site->sites_id;
                $data_site_active = $ss->save();
                if(!$data_site_active){
                    return response()->json(['err'=>0,'str'=>'新增站点失败']);
                }
                $goods_id = $value['goods_id'];
                $sort = $value['sort'];
                $site_active_good = [];
                foreach ($goods_id as $keys=>$item){
                    $array['site_good_id'] = $item;
                    $array['site_active_id'] = $data_site_active->site_active_id;
                    $array['sort'] = $sort[$keys];
                    array_push($site_active_good,$array);
                }
                $data_site_active_good = site_active_good::insert($site_active_good);
                if(!$data_site_active_good){
                    return response()->json(['err'=>0,'str'=>'新增站点失败']);
                }
            }
            return response()->json(['err'=>0,'str'=>'新增站点成功']);
        }
    }
}
