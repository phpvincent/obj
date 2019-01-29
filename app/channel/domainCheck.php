<?php
namespace App\channel;
use App\goods;
use App\url;
use App\vis;
use DB;
use Illuminate\Http\Request;
class domainCheck{
	/*
	url:访问域名
	level:域名遮罩等级
	for:域名遮罩导向
	lan:访问者客户端使用语言
	arr:访问者ip信息
	type:访问者客户端类型
	goods_id:访问域名对应单品id
	site_id:访问域名对应站点id
	 */
	private $url;
	private $level;
	private $for;
	private $lan;
	private $arr;
	private $type;
	private $goods_id;
	private $site_id;
	public $redirect_msg=0;
	public function __construct($url,array $arr,$lan,$type)
	{
		$this->url=$url;
		$this->arr=$arr;
		$this->lan=$lan;
		$this->type=$type;
	}
	public function setParam(array $params)
	//设置参数
	{
		foreach($params as $k => $v){
			if(property_exists($this,$k)){
				$this->$k=$v;
			}
		}
	}
	public function checkUrl(Request $request){
        $is_zz=false;
        $arr=$this->arr;
        $level=$this->level;
        $for=$this->for;
        $url=$this->url;
        $goods_id=$this->goods_id;
        $is_use=url::is_use($url);
		 //检查单品域名是否启用
          if(!$is_use){
           $this->redirect_msg=4;
          }
        //$lan=getclientlan(); 
        //$level=url::getlevel();
        //$for=url::getzzfor();
        switch ($level) {
            case '0':
               $is_zz=false;
                break;
            case '1':
                if(strpos($arr['region'],"美国")!==false||strpos($arr['country'],"美国")!==false||strpos($arr['city'],"美国")!==false||strpos($arr['region'],"USA")!==false||strpos($arr['country'],"USA")!==false||strpos($arr['city'],"USA")!==false){
                    if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                  }
                break;
            case '2':
                if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '3':
                if($arr['country']!='台湾省'&&$arr['region']!='台湾省'&&$arr['country']!='台湾'&&$arr['region']!='台湾'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '5':
                if($arr['country']!='泰国'&&$arr['region']!='泰国'&&$arr['country']!='泰国'&&$arr['region']!='泰国'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '6':
                if($arr['country']!='菲律宾'&&$arr['region']!='菲律宾'&&$arr['country']!='菲律宾'&&$arr['region']!='菲律宾'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '7':
                if($arr['country']!='日本'&&$arr['region']!='日本'&&$arr['country']!='日本'&&$arr['region']!='日本'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '8':
                if($arr['country']!='马来西亚'&&$arr['region']!='马来西亚'&&$arr['country']!='马来西亚'&&$arr['region']!='马来西亚'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '9':
                if($arr['country']!='英国'&&$arr['region']!='英国'&&$arr['country']!='英国'&&$arr['region']!='英国'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '10':
                if($arr['country']!='印度尼西亚'&&$arr['region']!='印度尼西亚'&&$arr['country']!='印度尼西亚'&&$arr['region']!='印度尼西亚'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '11':
                if($arr['country']!='阿联酋'&&$arr['region']!='阿联酋'&&$arr['country']!='阿联酋'&&$arr['region']!='阿联酋'){
                     $is_zz=true;
                }
                 if(strpos($arr['isp'],"脸书")!==false||strpos($arr['isp'],"facebook")!==false||strpos($arr['isp'],"Facebook")!==false){
                      $is_zz=true;
                    }
                break;
            case '4':
                $is_zz=true;
            break;
            default:
               
                break;
        }
/*        $goods_id=url::get_id();
        if(!$goods_id){
            $this->redirect_msg=4;
        } */
          //检测核审机制是否开启
        if(\App\goods_check::first()['goods_is_check']==0){
        //检测单品是否触发核审并已超过保护期
            $goods=\App\goods::where('goods_id',$goods_id)->first();
            if($goods['goods_heshen']!='1'){
                $goods_check_time=$goods['goods_check_time'];
                 $second=\App\goods_check::first()['goods_check_second'];
                    $less_time=time()-strtotime($goods->goods_check_time)-$second;
                      if($less_time>0){
                          //已经超过保护期,除河南区域内全部屏蔽
                         if(strpos($arr['region'],"河南")!==false||strpos($arr['country'],"河南")!==false||strpos($arr['city'],"河南")!==false){

                         }else{
                             $this->redirect_msg=4;
                         }
                      }
            }
        }
        if($is_zz){
            switch ($for) {
                case '0':
                //遮罩机制被触发,将goods_id更改为此域名下遮罩单品的id
                   $this->goods_id=url::get_zz_id();
                    break;
                case '1':
                    $this->redirect_msg=4;
                    break;
                case '2':
                    $this->redirect_msg=3;
                    break;
                default:
                    break;
            }
        }
	}
	public function check_pb()
	{   
		$arr=$this->arr;
        //地区核审
        $area=explode(';', DB::table('pb')->first()->pb_ziduan);
        if($area[0]!=null){
            foreach($area as $key => $v){
                if($v==''||$v==null){
                    break;
                }
                if($arr['region']!=''&&$arr['region']!=null&&strpos($arr['region'],$v)!==false){
                                        $this->redirect_msg=4;
                }
                if($arr['country']!=''&&$arr['country']!=null&&strpos($arr['country'],$v)!==false){
                                        $this->redirect_msg=4;
                }
                if($arr['area']!=''&&$arr['area']!=null&&strpos($arr['area'],$v)!==false){
                                        $this->redirect_msg=4;
                }
                /*if(strpos($arr['region'],$v)!==false||strpos($arr['country'],$v)!==false||strpos($arr['city'],$v)!==false||strpos($arr['area'],$v)!==false){
                    $this->redirect_msg=4;
                }*/
            }
        } 
        /*if($area[0]!=null&&(in_array($arr['region'], $area)||in_array($arr['country'],$area)||in_array($arr['city'],$area)||in_array($arr['region']."省", $area)||in_array($arr['country'].'国',$area)||in_array($arr['city'].'市',$area))){
            $this->redirect_msg=4;
        }*/
        //ip核审
        $notallow=vis::where([['vis_ip','=',$arr['ip']],['vis_isback','=','1']])->first();
        if($notallow!=null){
            $this->redirect_msg=4;
        } 
	}
	public function save_vis(Request $request)
	{	
		$goods_id=$this->goods_id;
		$site_id=$this->site_id;
		$arr=$this->arr;
		$type=$this->type;
		$lan=$this->lan;
		if($request->get('is_site')==true){
            $is_site=true;
        }
        if(!isset($_COOKIE['isr_vis'])){
             $vis=new vis;
            $vis->vis_ip=$arr['ip'];
            $vis->vis_country=$arr['country'];
            $vis->vis_region=$arr['region'];
            $vis->vis_city=$arr['city'];
            $vis->vis_county=$arr['county'];
            $vis->vis_isp=$arr['isp'];
            $vis->vis_type=$type;
            $vis->vis_lan=$lan;
            $vis->vis_time=date('Y-m-d H:i:s',time());
            if($goods_id==null){
              $goods_id=0;
            }
            if($site_id==null){
              $site_id=0;
            }
            $vis->vis_site_id=$site_id;
            $vis->vis_goods_id=$goods_id;
            $vis->vis_url=$_SERVER['SERVER_NAME'];
            $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
            if($goods_id==0){
            	if($request->has('goods_id')) $vis->vis_goods_id=$request->input('goods_id');
            	if(isset($request->goods_id)&&$request->goods_id>0) $vis->vis_goods_id=$request->goods_id;
            }
            $vis->save();  
            setcookie('isr_vis',$vis->vis_id,time()+600);
        }else{
            $vis=\App\vis::where('vis_id',$_COOKIE['isr_vis'])->first();
            if($vis==null){
              $vis=new vis;
              $vis->vis_ip=$arr['ip'];
              $vis->vis_country=$arr['country'];
              $vis->vis_region=$arr['region'];
              $vis->vis_city=$arr['city'];
              $vis->vis_county=$arr['county'];
              $vis->vis_isp=$arr['isp'];
              $vis->vis_type=$type;
              $vis->vis_lan=$lan;
              $vis->vis_time=date('Y-m-d H:i:s',time());
              if($goods_id==null){
                $goods_id=0;
              }
              if($site_id==null){
                $site_id=0;
              }
              $vis->vis_site_id=$site_id;
              $vis->vis_goods_id=$goods_id;
              $vis->vis_url=$_SERVER['SERVER_NAME'];
              $vis->vis_from=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
              if($goods_id==0){
              	if($request->has('goods_id')) $vis->vis_goods_id=$request->input('goods_id');
              	if(isset($request->goods_id)&&$request->goods_id>0) $vis->vis_goods_id=$request->goods_id;
              }
              $vis->save();  
              setcookie('isr_vis',$vis->vis_id,time()+600);
            }else{
            	if($vis instanceof vis){
            		$vis->vis_staytime=time()-strtotime($vis->vis_time);
            		$vis->save();
            	}
            }
        }
        return $vis->vis_id;
	}

}