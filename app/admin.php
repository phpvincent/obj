<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
	use \Illuminate\Auth\Authenticatable;
    protected $table = 'admin';
    protected $primaryKey ='admin_id';
    public $timestamps=false;
    public static function getrole($admin_role_id){
        App\role::where()->first();
    }
    //获取所在分组的所有管理员id，true为数组形式返回，false为字符串形式返回
    public static function get_group_ids($id,$type=true){
    	$group=self::where('admin_id',$id)->first()['admin_group'];

    	if($group==null){
    		if($type){
    			return $arr=[$id];
    		}else{
    			return $str="($id)";
    		}
    	}
        if(\App\admin_group::where('admin_group_id',$group)->first()['admin_group_name']=='#全体人员#'){
            //全体人员时取得所有人员的id
           $resu=self::get(['admin_id'])->toArray();
        }else{
           $resu=self::where('admin_group',$group)->get(['admin_id'])->toArray();
        }
    	if($type){
    		$arr=[];
    		foreach($resu as $k => $v){
    			$arr[]=$v['admin_id'];
    		}
    		return $resu;
    	}else{
    		$str='';
    		foreach($resu as $k => $v){
    			$str.=$v['admin_id'].',';
    		}
    		$str=rtrim($str,',');
    		return "(".$str.")";
    	}
    }
    public static function get_group($id){
    	$group=self::where('admin_id',$id)->first()['admin_group'];
    	if($group!=null){
    		    	return self::where('admin_group',$group)->get();
    	}else{
    		return $arr=[];
    	}
    }

    /** 根据用户不同的权限返回不同的商品信息
     * @param bool $bool
     * @return string
     */
    public static function get_goods_id($bool = true)
    {
        $auth = Auth::user();
        $id = $auth->admin_data_rule;//查看数据权限 :0：仅查看自己，1：查看自己与本组，2：查看全体成员，3：root
        $admin_id = $auth->admin_id;
        $admin_group = $auth->admin_group;
        //1.判断分组是否为特殊分组
        $status = admin_group::where('admin_group_id',$admin_group)->value('admin_group_rule');//是否特殊权限 0：普通分组 1：特殊分组
        $data = [];
        if($id == 0){//仅查看自己数据
            $data = goods::where('goods_admin_id',$admin_id)->where('is_del','0')->pluck('goods_id')->toArray();
        }
        if($id == 1){// 查看本组数据
            $admins = admin::where('admin_group',$admin_group)->pluck('admin_id')->toArray();
            if(!empty($admins)){
                $data = goods::whereIn('goods_admin_id',$admins)->where('is_del','0')->pluck('goods_id')->toArray();
            }
        }
        if($status == 0){
            //查看全体成员信息（不包括status为1的信息）
            if($id == 2){
                //获取普通权限用户id
                $admin_groups = admin_group::where('admin_group_rule','0')->pluck('admin_group_id')->toArray();
                $admin_ids = admin::whereIn('admin_group',$admin_groups)->pluck('admin_id')->toArray();
                if(!empty($admin_ids)){
                    $data = goods::whereIn('goods_admin_id',$admin_ids)->where('is_del','0')->pluck('goods_id')->toArray();
                }
            }
            if($id == 3){ //root用户 查看所以信息
                $data = goods::where('is_del','0')->pluck('goods_id')->toArray();
            }
        }
        if($auth->is_root == 1){
            $data = goods::where('is_del','0')->pluck('goods_id')->toArray();
        }
        if($bool){
            return $data;
        }else{
            return implode(',',$data);
        }

    }

    /** 根据查看权限，返回可查看管理员id
     * @param bool $bool
     * @return array|string
     */
    public static function get_admins_id($bool = true)
    {
        $auth = Auth::user();
        $admin_id = $auth->admin_id;
        $id = $auth->admin_data_rule;//查看数据权限 :0：仅查看自己，1：查看自己与本组，2：查看全体成员，3：root
        $admin_group = $auth->admin_group;
        //1.判断分组是否为特殊分组
        $status = admin_group::where('admin_group_id',$admin_group)->value('admin_group_rule');//是否特殊权限 0：普通分组 1：特殊分组
        $data = [];
        if($id == 0){//仅查看自己数据
            $data = [$admin_id];
        }
        if($id == 1){// 查看本组数据
            $data = admin::where('admin_group',$admin_group)->pluck('admin_id')->toArray();
        }
        if($status == 0){
            //查看全体成员信息（不包括status为1的信息）
            if($id == 2){
                //获取普通权限用户id
                $admin_groups = admin_group::where('admin_group_rule','0')->pluck('admin_group_id')->toArray();
                $data = admin::whereIn('admin_group',$admin_groups)->pluck('admin_id')->toArray();
            }
            if($id == 3){ //root用户 查看所以信息
                $data = admin::pluck('admin_id')->toArray();
            }
        }
        if($auth->is_root == 1){
            $data = admin::pluck('admin_id')->toArray();
        }

        if($bool){
            return $data;
        }else{
            return implode(',',$data);
        }
    }
}
