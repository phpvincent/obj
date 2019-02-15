<?php

namespace App\Http\Controllers\admin;

use App\admin;
use App\goods;
use App\goods_type;
use App\site;
use App\site_active;
use App\site_active_good;
use App\site_class;
use App\site_img;
use App\url;
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
    public function index()
    {
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
            ->select('sites.*','url.url_url','url.url_type','admin.admin_show_name','url.url_id')
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

    /**
     * 新增站点
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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
            //2.站点轮播图数据
            $size_file = $request->file('size_file');
            $goods = $request->input('goods');
            if(count($size_file) != count($goods) ){
                return response()->json(['err'=>0,'str'=>'请上传全部轮播图片']);
            }
            foreach ($goods as $k => $v)
            {
                //轮播图片限制width:730 height:400
                if(isset($size_file[$k])){
                    if(filesize($size_file[$k]) > 8192*1024){
                        return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                    }
                    $photo_size = getimagesize($size_file[$k]);
                    if($photo_size[0] != 730 && $photo_size[1] != 400){
                        return response()->json(['err'=>0,'str'=>'轮播图片不符合尺寸']);
                    }
                }else{
                    return response()->json(['err'=>0,'str'=>'请上传全部轮播图片']);
                }
                if(!trim($v)){
                    return response()->json(['err'=>0,'str'=>'请选择轮播图片关联商品']);
                }
            }
            //3.站点分类信息
            $goods_type_id = $request->input('goods_type_id');
            $goods_type_show_name = $request->input('goods_type_show_name');
            $goods_type_isshow = $request->input('goods_type_isshow');
            $goods_type_sort = $request->input('goods_type_sort');
            if(count($goods_type_id) != count($goods_type_show_name) || count($goods_type_id) != count($goods_type_sort)){
                return response()->json(['err'=>0,'str'=>'请补全站点分类信息']);
            }
            foreach ($goods_type_show_name as $k=>$v) {
                if(!trim($v)){
                    return response()->json(['err'=>0,'str'=>'请补全站点分类信息']);
                }
            }
            //4.特殊分类
            $site_active = $request->input('site_active');
            foreach ($site_active as $key => $value) {
                if(isset($value['goods_id'])){
                    $goods_id = $value['goods_id'];
                    foreach ($goods_id as $keys=>$item){
                        if(!$item){
                            return response()->json(['err'=>0,'str'=>'请选择特殊分类下产品']);
                        }
                    }
                }
            }

            //新品推荐
            if(isset($request->file('site_active')[1]['img'])){
                $img = $request->file('site_active')[1]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 380){
                    return response()->json(['err'=>0,'str'=>'新品推荐图片不符合尺寸']);
                }
            }else{
                return response()->json(['err'=>0,'str'=>'请上传新品推荐图片']);
            }

            //秒杀抢购
            if(isset($request->file('site_active')[2]['img'])){
                $img = $request->file('site_active')[2]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 190){
                    return response()->json(['err'=>0,'str'=>'秒杀抢购图片不符合尺寸']);
                }
            }else{
                return response()->json(['err'=>0,'str'=>'请上传秒杀抢购图片']);
            }

            //热卖推荐
            if(isset($request->file('site_active')[3]['img'])){
                $img = $request->file('site_active')[3]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 190){
                    return response()->json(['err'=>0,'str'=>'热卖推荐图片不符合尺寸']);
                }
            }else{
                return response()->json(['err'=>0,'str'=>'请上传热卖推荐图片']);
            }

            $site_fire_word = trim($request->input('site_fire_word')) ? $request->input('site_fire_word') : '';
            if($site_fire_word){
                $site_word = explode(',',$site_fire_word);
                if(count($site_word) == 1){
                    $site_word = explode('，',$site_fire_word);
                }
                $site_fire_word = implode(',',$site_word);
            }
            //保存站点数据
            $site = new site();
            $site->sites_name = $site_name;
            $site->sites_blade_type = $request->input('goods_blade_type');
            $site->site_fire_word = $site_fire_word;
            $site->sites_admin_id = Auth::user()->admin_id;
            $site->status = 0;
            $site_data = $site->save();
            if(!$site_data){
                return response()->json(['err'=>0,'str'=>'站点信息保存失败']);
            }
            //保存站点轮播图
            $plant = [];
            foreach ($size_file as $k=>$item){
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
            //保存站点分类
            $site_class = [];
            foreach ($goods_type_id as $key=>$item) {
                $arra['site_class_sort'] = $goods_type_sort[$key] ? $goods_type_sort[$key] : 0;
                $arra['site_class_show_name'] = $goods_type_show_name[$key];
                $arra['site_goods_type_id'] = $item;
                $arra['site_is_show'] = isset($goods_type_isshow[$key]) ? 0 : 1;
                $arra['site_site_id'] = $site->sites_id;
                array_push($site_class,$arra);
            }

            $data_class = site_class::insert($site_class);
            if(!$data_class){
                return response()->json(['err'=>0,'str'=>'新增站点失败']);
            }

            //特殊分类 //1.新品推荐;2.秒杀抢购;3.热卖推荐
//            $site_active = $request->input('site_active');
            foreach ($site_active as $key => $value){
                $img = $request->file('site_active')[$key]['img'];
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
                if(isset($value['goods_id'])){
                    $goods_id = $value['goods_id'];
                    $sort = $value['sort'];
                    $site_active_good = [];
                    foreach ($goods_id as $keys=>$item){
                        if($item){
                            $array['site_good_id'] = $item;
                            $array['site_active_id'] = $ss->site_active_id;
                            $array['sort'] = $sort[$keys];
                            array_push($site_active_good,$array);
                        }
                    }
                    $data_site_active_good = site_active_good::insert($site_active_good);
                    if(!$data_site_active_good){
                        return response()->json(['err'=>0,'str'=>'新增站点失败']);
                    }
                }
            }
            return response()->json(['err'=>1,'str'=>'新增站点成功']);
        }
    }

    /**
     * 站点信息修改
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function post_update(Request $request)
    {
        if($request->isMethod('get')) {
            $goods_type = goods_type::all();
            $id = $request->input('id');
            $site = site::where('sites_id',$id)->first();
            if(!$site){
                return view('admin.view.fb');
            }
            $site_class = site_class::join('goods_type','goods_type.goods_type_id','=','site_class.site_goods_type_id')
                ->where('site_class.site_site_id',$id)
                ->get();
            $site_imgs = site_img::select('goods.goods_real_name','site_imgs.*')
                ->join('goods','goods.goods_id','=','site_imgs.site_goods_id')
                ->where('site_imgs.site_site_id',$id)
                ->get();
            $site_active = [];
            $site_actives = site_active::where('site_id',$id)->get();
            if(!$site_actives->isEmpty()){
                foreach ($site_actives as $val){
                    $arr['site_active_type'] = $val->site_active_type;
                    $arr['site_active_id'] = $val->site_active_id;
                    $site_active_good = site_active_good::where('site_active_id',$val->site_active_id)->get()->toArray();
                    if(!empty($site_active_good)){
                        foreach ($site_active_good as &$item){
                            $item['goods_name'] = goods::where('goods_id',$item['site_good_id'])->first()['goods_real_name'];
                        }
                    }
                    $arr['goods'] = $site_active_good;
                    $site_active[$val->site_active_type] = $arr;
//                    $arr['goods'] = site_active_good::select('site_active_goods.site_active_id','site_active_goods.site_active_good_id','site_active_goods.sort','site_active_goods.site_good_id','goods.goods_name')
//                        ->join('goods','goods.goods_id','=','site_active_goods.site_active_id')
//                        ->where('site_active_id',$val->site_active_id)
//                        ->get()->toArray();
//                    $site_active[$val->site_active_type] = $arr;
                }
            }
            return view('admin.sites.edit')->with(compact('goods_type','site','site_class','site_imgs','site_active'));
        }elseif($request->isMethod('post')){
            $site_id = $request->input('site_id');
            $site = site::where('sites_id',$site_id)->first();
            if(!$site){
                return response()->json(['err'=>0,'str'=>'站点修改失败']);
            }

            //1.站点名称不可以修改
            //2.站点轮播图数据
            $size_file = $request->file('size_file');
            $site_img_id = $request->input('site_img_id');
            $goods = $request->input('goods');
            foreach ($goods as $k => $v)
            {
                //轮播图片限制width:730 height:400
                if(isset($size_file[$k])){
                    $photo_size = getimagesize($size_file[$k]);
                    if($photo_size[0] != 730 && $photo_size[1] != 400){
                        return response()->json(['err'=>0,'str'=>'轮播图片不符合尺寸']);
                    }
                }
                if(!isset($site_img_id[$k]) && !isset($size_file[$k])){
                    return response()->json(['err'=>0,'str'=>'请上传全部轮播图片']);
                }
                if(!trim($v)){
                    return response()->json(['err'=>0,'str'=>'请选择轮播图片关联商品']);
                }
            }
            //3.站点分类信息
            $goods_type_id = $request->input('goods_type_id');
            $site_class_id = $request->input('site_class_id');
            $goods_type_show_name = $request->input('goods_type_show_name');
            $goods_type_isshow = $request->input('goods_type_isshow');
            $goods_type_sort = $request->input('goods_type_sort');
            if(count($goods_type_id) != count($goods_type_show_name) || count($goods_type_id) != count($goods_type_sort)){
                return response()->json(['err'=>0,'str'=>'请补全站点分类信息']);
            }
            foreach ($goods_type_show_name as $k=>$v) {
                if(!trim($v)){
                    return response()->json(['err'=>0,'str'=>'请补全站点分类信息']);
                }
            }

            //4.特殊分类
            $site_active = $request->input('site_active');
            foreach ($site_active as $key => $value) {
                if(isset($value['goods_id'])){
                    $goods_id = $value['goods_id'];
                    foreach ($goods_id as $keys=>$item){
                        if(!$item){
                            return response()->json(['err'=>0,'str'=>'请选择特殊分类下产品']);
                        }
                    }
                }
            }

            //秒杀抢购
            if(isset($request->file('site_active')[1]['img'])){
                $img = $request->file('site_active')[1]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 380){
                    return response()->json(['err'=>0,'str'=>'新品推荐图片不符合尺寸']);
                }
            }

            //新品推荐
            if(isset($request->file('site_active')[2]['img'])){
                $img = $request->file('site_active')[2]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 190){
                    return response()->json(['err'=>0,'str'=>'秒杀抢购图片不符合尺寸']);
                }
            }

            //热卖推荐
            if(isset($request->file('site_active')[3]['img'])){
                $img = $request->file('site_active')[3]['img'];
                if(filesize($img) > 8192*1024){
                    return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                }
                $img_size = getimagesize($img);
                if($img_size[0] != 308 && $img_size[1] != 190){
                    return response()->json(['err'=>0,'str'=>'热卖推荐图片不符合尺寸']);
                }
            }

            $site_fire_word = trim($request->input('site_fire_word')) ? $request->input('site_fire_word') : '';
            if($site_fire_word){
                $site_word = explode(',',$site_fire_word);
                if(count($site_word) == 1){
                    $site_word = explode('，',$site_fire_word);
                }
                $site_fire_word = implode(',',$site_word);
            }

            //保存站点数据
            $site->sites_blade_type = $request->input('goods_blade_type');
            $site->site_fire_word = $site_fire_word;
            $site_data = $site->save();
            if(!$site_data){
                return response()->json(['err'=>0,'str'=>'站点信息保存失败']);
            }
            //保存站点轮播图
            $site_imgs = site_img::where('site_site_id',$site_id)->pluck('site_img_id')->toArray();
            if(isset($site_img_id)){
                $site_img_ids = array_diff($site_imgs,$site_img_id);
                site_img::whereIn('site_img_id',$site_img_ids)->delete();
            }
            foreach ($goods as $k=>$item){
                if(isset($site_img_id[$k])){
                    $site_img = site_img::where('site_img_id',$site_img_id[$k])->first();
                }else{
                    $site_img = new site_img();
                }
                if(isset($size_file[$k])){
                    if(filesize($size_file[$k]) > 8192*1024){
                        return response()->json(['err'=>0,'str'=>'上传图片不能超过8M']);
                    }
                    $name=$size_file[$k]->getClientOriginalName();//得到视频名；
                    $ext=$size_file[$k]->getClientOriginalExtension();//得到视频后缀；
                    $fileName=md5(uniqid($name));
                    $newfilename='site'."_".$fileName.'.'.$ext;//生成新的的文件名
                    $filedir="upload/site_imgs/";
                    $msg=$size_file[$k]->move($filedir,$newfilename);
                    if(!$msg){
                        return response()->json(['err'=>0,'str'=>'文件上传失败']);
                    }
                    $site_img->site_img = $filedir.$newfilename;
                }

                $site_img->site_goods_id = $item;
                $site_img->site_site_id = $site_id;
                $data_site_img = $site_img->save();
                if(!$data_site_img){
                    return response()->json(['err'=>0,'str'=>'修改站点失败']);
                }
            }
            //保存站点分类
            foreach ($goods_type_id as $key=>$item) {
                $site_class = site_class::where('site_class_id',$site_class_id[$key])->first();
                $site_class->site_class_sort = $goods_type_sort[$key] ? $goods_type_sort[$key] : 0;
                $site_class->site_class_show_name = $goods_type_show_name[$key];
                $site_class->site_goods_type_id = $item;
                $site_class->site_is_show = isset($goods_type_isshow[$key]) ? 0 : 1;
                $site_class->site_site_id = $site->sites_id;
                $data_class = $site_class->save();
                if(!$data_class){
                    return response()->json(['err'=>0,'str'=>'修改站点失败']);
                }
            }
            //特殊分类 //1.秒杀抢购;2.新品推荐;3.热卖推荐
            foreach ($site_active as $key => $value){
                if($value['site_active_id']){
                    $site_act = site_active::where('site_active_id',$value['site_active_id'])->first();
                }else{
                    $site_act = new site_active();
                }

                $img = isset($request->file('site_active')[$key]['img']) ? $request->file('site_active')[$key]['img'] : false;
                if($img){
                    $name=$img->getClientOriginalName();//得到视频名；
                    $ext=$img->getClientOriginalExtension();//得到视频后缀；
                    $fileName=md5(uniqid($name));
                    $newfilename='site_active'."_".$fileName.'.'.$ext;//生成新的的文件名
                    $filedir="upload/site_imgs/";
                    $msg=$img->move($filedir,$newfilename);
                    if(!$msg){
                        return response()->json(['err'=>0,'str'=>'文件上传失败']);
                    }
                    $site_act->site_active_img = $filedir.$newfilename;
                }

                $site_act->site_active_type = $key;
                $site_act->site_id = $site_id;
                $data_site_active = $site_act->save();
                if(!$data_site_active){
                    return response()->json(['err'=>0,'str'=>'修改站点失败']);
                }
                if(isset($value['goods_id'])){
                    $goods_id = $value['goods_id'];
                    $sort = $value['sort'];
                    $site_active_good_ids = site_active_good::where('site_active_id',$site_act->site_active_id)->pluck('site_active_good_id')->toArray();
                    if(isset($value['site_active_good_id'])){
                        $intersection = array_diff($site_active_good_ids, $value['site_active_good_id']);
                        site_active_good::whereIn('site_active_good_id',$intersection)->delete();
                    }
                    foreach ($goods_id as $keys=>$item){
                        if(isset($value['site_active_good_id'][$keys])){
                            $site_active_good = site_active_good::where('site_active_good_id',$value['site_active_good_id'][$keys])->first();
                        }else{
                            $site_active_good = new site_active_good();
                        }
                        if($item){
                            $site_active_good->site_good_id = $item;
                            $site_active_good->site_active_id = $site_act->site_active_id;
                            $site_active_good->sort = $sort[$keys];
                            $data_site_active_good = $site_active_good->save();
                            if(!$data_site_active_good){
                                return response()->json(['err'=>0,'str'=>'修改站点失败']);
                            }
                        }
                    }
                }
            }
            return response()->json(['err'=>1,'str'=>'修改站点成功']);
        }
    }

    /**
     * 删除站点
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_site(Request $request)
    {
        $id=$request->input('id');
        $site = site::where('sites_id',$id)->update(['status'=>1]);
        $url = url::where('url_site_id',$id)->update(['url_site_id'=>'']);
        if($site){
            return response()->json(['err'=>1,'str'=>'站点删除成功']);
        }
        return response()->json(['err'=>0,'str'=>'站点删除失败']);
    }
}
