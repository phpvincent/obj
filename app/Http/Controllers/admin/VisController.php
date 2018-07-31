<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\vis;
use DB;
class VisController extends Controller
{
    public function index(){
    	$counts=vis::count();
    	return view('admin.vis.index')->with('counts',$counts);
    }
    public function getindex(Request $request){
    		$info=$request->all();
        	$cm=$info['order'][0]['column'];
	        $dsc=$info['order'][0]['dir'];
	        $order=$info['columns']["$cm"]['data'];
	        $draw=$info['draw'];
	        $start=$info['start'];
	        $len=$info['length'];
	        $search=trim($info['search']['value']);
	        $counts=DB::table('vis')
	        ->count();
	        if(strtotime(explode(';',$search)[0])>100&&strtotime(explode(';',$search)[1])>100){
	        	$timesearch=$search;
	        	$search='';
	        	$newlen=$len;
	        	$len=$counts;
	        }
	        if(isset($info['ispb'])&&$info['ispb']=='1'){
	        	    $newcount=DB::table('vis')
			        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
			        ->where([['goods.goods_name','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_ip','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_city','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_country','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_county','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_lan','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_isp','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_region','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_type','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->count();
			        $data=DB::table('vis')
			        ->select('vis.*','goods.goods_name')
			        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
			        ->where([['goods.goods_name','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_ip','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_city','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_country','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_county','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_lan','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_isp','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_region','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orWhere([['vis.vis_type','like',"%$search%"],['vis.vis_isback','=','1']])
			        ->orderBy($order,$dsc)
			        ->offset($start)
			        ->limit($len)
			        ->get();
			            if(isset($timesearch)){
		        	if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
	 				$newcount=0;
	 				$dataarr=[];
	 				/*$msg=[];*/
	 				foreach($data as $k=> $v){/*dd(explode(';',$timesearch),$v->vis_time);dd(strtotime($v->vis_time),strtotime(explode(';',$timesearch)[1]),strtotime(explode(';',$timesearch)[0]));*/
	 			/*	$msg[$k]['name']=$v->vis_ip;
	 				$msg[$k]['end']=(strtotime($v->vis_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->vis_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->vis_time)==strtotime($timesearch);
	 				$msg[$k]['time']=(strtotime($v->vis_time));
	 				$msg[$k]['aes']=strtotime(explode(';',$timesearch)[0]).'-'.strtotime(explode(';',$timesearch)[1]);*/
	 					if((strtotime($v->vis_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->vis_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->vis_time)==strtotime($timesearch)){
	 						$newcount+=1;
	 						$dataarr[]=$v;
		 					}
		 				}
		 				$arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>array_slice($dataarr,$start,$newlen)];
			       		 return response()->json($arr);
		 				}
			        }
		 			
			        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
			        return response()->json($arr);
	        }
	        $newcount=DB::table('vis')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
	        ->where('goods.goods_name','like',"%$search%")
	        ->orWhere('vis.vis_ip','like',"%$search%")
	        ->orWhere('vis.vis_city','like',"%$search%")
	        ->orWhere('vis.vis_country','like',"%$search%")
	        ->orWhere('vis.vis_county','like',"%$search%")
	        ->orWhere('vis.vis_lan','like',"%$search%")
	        ->orWhere('vis.vis_isp','like',"%$search%")
	        ->orWhere('vis.vis_region','like',"%$search%")
	        ->orWhere('vis.vis_type','like',"%$search%")
	        ->count();
	        $data=DB::table('vis')
	        ->select('vis.*','goods.goods_name')
	        ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
	        ->where('goods.goods_name','like',"%$search%")
	        ->orWhere('vis.vis_ip','like',"%$search%")
	        ->orWhere('vis.vis_city','like',"%$search%")
	        ->orWhere('vis.vis_country','like',"%$search%")
	        ->orWhere('vis.vis_county','like',"%$search%")
	        ->orWhere('vis.vis_lan','like',"%$search%")
	        ->orWhere('vis.vis_isp','like',"%$search%")
	        ->orWhere('vis.vis_region','like',"%$search%")
	        ->orWhere('vis.vis_type','like',"%$search%")
	        ->orderBy($order,$dsc)
	        ->offset($start)
	        ->limit($len)
	        ->get();
	        if(isset($timesearch)){
		        	if((strtotime(explode(';',$timesearch)[0])>100&&strtotime(explode(';',$timesearch)[1])>100)||strtotime($timesearch)>100){
	 				$newcount=0;
	 				$dataarr=[];
	 				/*$msg=[];*/
	 				foreach($data as $k=> $v){/*dd(explode(';',$timesearch),$v->vis_time);dd(strtotime($v->vis_time),strtotime(explode(';',$timesearch)[1]),strtotime(explode(';',$timesearch)[0]));*/
	 			/*	$msg[$k]['name']=$v->vis_ip;
	 				$msg[$k]['end']=(strtotime($v->vis_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->vis_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->vis_time)==strtotime($timesearch);
	 				$msg[$k]['time']=(strtotime($v->vis_time));
	 				$msg[$k]['aes']=strtotime(explode(';',$timesearch)[0]).'-'.strtotime(explode(';',$timesearch)[1]);*/
	 					if((strtotime($v->vis_time)>=strtotime(explode(';',$timesearch)[0])&&strtotime($v->vis_time)<=strtotime(explode(';',$timesearch)[1]))||strtotime($v->vis_time)==strtotime($timesearch)){
	 						$newcount+=1;
	 						$dataarr[]=$v;
		 					}
	 				}
	 				$arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>array_slice($dataarr,$start,$newlen)];
		       		 return response()->json($arr);
	 				}
	        }
 			
	        $arr=['draw'=>$draw,'recordsTotal'=>$counts,'recordsFiltered'=>$newcount,'data'=>$data];
	        return response()->json($arr);
    }
    public function delvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->delete();
    	if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'删除成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'删除失败']);
	   	}
    }
    public function pbvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->first();
    	$msg->vis_isback='1';
    	if($msg->save()){
	   	    	return response()->json(['err'=>1,'str'=>'屏蔽成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'屏蔽失败']);
	   	}
    }
    public function backvis(Request $request){
    	$msg=vis::where('vis_id',$request->input('id'))->first();
    	$msg->vis_isback='1';
    	if($msg->save()){
	   	    	return response()->json(['err'=>1,'str'=>'解封成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'解封失败']);
	   	}
    }
    public function prea(){
    	$msg=\App\pb::first();
    	$msg->area=explode(';', $msg->pb_ziduan);
    	return view('admin.vis.prea')->with('msg',$msg);
    }
    public function chvis(Request $request){
       $msg=DB::table('pb')->where('pb_id',1)->update(['pb_ziduan'=>$request->input('msg')]);
        if($msg){
	   	    	return response()->json(['err'=>1,'str'=>'修改成功']);
	   	}else{
		   	    	return response()->json(['err'=>0,'str'=>'修改失败']);
	   	}
    }
   public function outvis(){
   		$data=vis::select('vis.vis_id','vis.vis_ip','vis.vis_country','vis.vis_region','vis.vis_city','vis.vis_county','vis.vis_isp','vis.vis_type','vis.vis_time','vis.vis_lan','vis.vis_isback','goods.goods_name')
			   ->leftjoin('goods','goods.goods_id','vis.vis_goods_id')
				->orderBy('vis.vis_time','desc')
				->get()->toArray();
   		$filename='访问记录'.date('Y-m-d h:i:s',time()).'.xls';
   		$zdname=['记录id','访问者ip','访问者国家','访问者省份/州','访问者城市/地区','访问者县区/镇','访问者网络源','访问者设备类型','访问时间','访问者语言','是否封禁该ip','单品名'];
   		foreach($data as $k => $v){
   			if($v['vis_isback']=='0'){
   				$data[$k]['vis_isback']='没有封禁';
   			}elseif($v['vis_isback']=='0'){
   				$data[$k]['vis_isback']='已封禁';
   			}
   			if($v['goods_name']==''||$v['goods_name']==null){
   				$data[$k]['goods_name']='通过ip访问';
   			}
   		}
        out_excil($data,$zdname,'访问记录表',$filename);
   }
}
