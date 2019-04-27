<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class url extends Model
{
    protected $table = 'url';
    protected $primaryKey ='url_id';
    public static function is_use($url){
    	$all_use=self::where('url_url',$url)->first();
        if($all_use==null){
            return false;
        }elseif($all_use['url_type']==0){
            //域名没有开启
            return false;
        }
        if($all_use['url_goods_id']==null&&$all_use['url_zz_goods_id']==null){
            //域名没有绑定单品
            return false;
        }
    	
        return true;
    }
    public static function get_goods(Request $request){
    	$url=$_SERVER['SERVER_NAME'];
                //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        }
        if(url::where('url_url',$url)->first()['url_site_id']>0){
            if($request->has('goods_id')){
                return $request->input('goods_id');
            }elseif(isset($request->goods_id)&&$request->goods_id>0){
                return $request->goods_id;
            }else{
                return 4;
            }
        }
        $level=self::where('url_url',$url)->first(['url_zz_level']);
        if($level==null){
            $level='4';
        }else{
            @$level=$level->url_zz_level;
        }
        $url=self::where('url_url',$url)->first();
        $arr=getclientcity($request);
        switch ($level) {
            case '0':
              $goods_id=$url->url_goods_id;
                break;
            case '1':
                if('美国'==$arr['region']||'美国'==$arr['country']||'美国'==$arr['city']){
                    if($arr['isp']=='脸书'||$arr['isp']=='facebook'){
                      $goods_id=$url->url_zz_goods_id;
                    }
                  }else{
                     $goods_id=$url->url_goods_id;
                  }
                break;
            case '2':
                if($arr['isp']=='脸书'){
                      $goods_id=$url->url_zz_goods_id;
                    }else{
                      $goods_id=$url->url_goods_id;
                    }
                break;
            case '3':
                if($arr['country']!='台湾省'&&$arr['region']!='台湾省'&&$arr['country']!='台湾'&&$arr['region']!='台湾'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '5':
                if($arr['country']!='泰国'&&$arr['region']!='泰国'&&$arr['country']!='泰国'&&$arr['region']!='泰国'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '6':
                if($arr['country']!='菲律宾'&&$arr['region']!='菲律宾'&&$arr['country']!='菲律宾'&&$arr['region']!='菲律宾'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '7':
                if($arr['country']!='日本'&&$arr['region']!='日本'&&$arr['country']!='日本'&&$arr['region']!='日本'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '8':
                if($arr['country']!='马来西亚'&&$arr['region']!='马来西亚'&&$arr['country']!='马来西亚'&&$arr['region']!='马来西亚'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '9':
                if($arr['country']!='英国'&&$arr['region']!='英国'&&$arr['country']!='英国'&&$arr['region']!='英国'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '10':
                if($arr['country']!='印度尼西亚'&&$arr['region']!='印度尼西亚'&&$arr['country']!='印度尼西亚'&&$arr['region']!='印度尼西亚'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '11':
                if($arr['country']!='阿联酋'&&$arr['region']!='阿联酋'&&$arr['country']!='阿联酋'&&$arr['region']!='阿联酋'){
                    $goods_id=$url->url_zz_goods_id;
                }else{
                    $goods_id=$url->url_goods_id;
                }
                break;
            case '4':
                try{
                     $goods_id=$url->url_zz_goods_id;
                }catch(\Exception $e){

                }
                if(!isset($goods_id)||$goods_id==null){
                    @$goods_id=$url['url_zz_goods_id'];
                }
            break;
            default:
                break;
        };
        if($url==null||$url==false){
            return 4;
        }
        if($url->url_zz_goods_id==null){
            $goods_id=$url->url_goods_id;
        }
        if($url->url_goods_id==null){
            $goods_id=$url->url_zz_goods_id;
        }
    	return $goods_id;
    }
    public static function getlevel(){
        $url=$_SERVER['SERVER_NAME'];
          //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        }
        $level=self::where('url_url',$url)->first(['url_zz_level']);
        if($level==null){
            \Log::notice('getlevel出错,url:'.$url);
             return 4;
        }
        return $level->url_zz_level;
    }
    public static function getzzfor(){
        $url=$_SERVER['SERVER_NAME'];
          //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        }
        $for=self::where('url_url',$url)->first(['url_zz_for']);
        return $for->url_zz_for;
    }
    public static function get_zz_id(){
        $url=$_SERVER['SERVER_NAME'];
          //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        }
        $goods_zz_id=self::where('url_url',$url)->first();
        if($goods_zz_id==null||$goods_zz_id==''){
            //如果没有绑定遮罩单品，则自动返回正常单品的id
            return $goods_zz_id->url_goods_id;
        }
        return $goods_zz_id->url_zz_goods_id;
    }
    public static function get_id(){
        $url=$_SERVER['SERVER_NAME'];
          //将www二级域名去除
        if(substr($url,0,4)=='www.'){
            $url=substr($url, 4);
        }
        $goods_id=self::where('url_url',$url)->first();
        /*if(($goods_id==null||$goods_id=='')&&($goods_zz_id==null||$goods_zz_id=='')){
            return redirect('index/fb');
        }
        if($goods_id==null||$goods_id==''){
            return $goods_id->url_zz_goods_id;
        }
        return $goods_id->url_goods_id;*/
        if($goods_id==null){
            return false;
        }
        if($goods_id['url_goods_id']==null&&$goods_id['url_zz_goods_id']==null){
            return false;
        }
        if($goods_id['url_goods_id']!=null&&$goods_id['url_goods_id']>0){
            return $goods_id['url_goods_id'];
        }else{
            return $goods_id['url_zz_goods_id'];
        }
    }

    /**
     * 根据域名返回域名
     * @param $url
     * @return bool|string
     */
    public static function get_site_url($url,$goods_id)
    {
        if(substr($url,0,4) == 'www.'){
            $url = substr($url,4);
        }elseif(substr($url,0,11)=='http://www.'){
            $url = substr($url, 11);
        }elseif(substr($url, 0,7)=='http://'){
            $url=substr($url, 7);
        }
        
        $urls = url::where('url_url',$url)->first();
        if(!$urls){
            \Log::notice('error:url.php :function get_site_url failed.url:'.json_encode($url));
            return false;
        }
        if($urls->url_site_id){
            if($goods_id){
                return $url.'/index/site_goods/'.$goods_id;
            }else{
                return $url;
            }
        }
        if($urls->url_goods_id){
            return $url;
        }
        if($urls->url_zz_goods_id){
            return $url;
        }
        return false;
    }
}
