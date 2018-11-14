<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class config_val extends Model
{
    protected $table = 'config_val';
    protected $primaryKey ='config_val_id';
    public $timestamps=false;

    /** 保存或修改商品属性
     * @param $data
     * @param $goods_config_id
     * @param $goods_id
     * @param $arrId
     * @return bool
     */
    public static function createOrSave($data,$goods_config_id,$goods_id)
    {
        if(!empty($data)){
            foreach ($data as $val)
            {
                if(isset($val['id'])){
                    $config_val = \App\config_val::where('config_val_id',$val['id'])->first();
                }else{
                    $config_val = new \App\config_val();
                }
                $config_val->config_val_msg = $val['goods_config'];
                $config_val->config_type_id = $goods_config_id;
                $config_val->config_goods_id = $goods_id;
                $config_val->kind_val_id = $val['kind_val_id'];
                $config_val->config_isshow = isset($val['config_isshow']) ? '1' : '0';
                $config_val->config_diff_price = $val['config_diff_price'] ? $val['config_diff_price'] : 0;
                if($val['config_imgs']){
                    //之前存在数据，直接删除已存在的数据
                    if($config_val->config_val_img){
                        $image = substr($config_val->config_val_img,6);
                        if(Storage::disk('public')->exists($image)){
                            Storage::disk('public')->delete($image);
                        }
                    }
                    //上传图片处理
                    $fileName = self::uploadImg($val['config_imgs']);
                    if($fileName){
                        $config_val->config_val_img = $fileName;
                    }else{
                        return false;
                    }
                }
                $bool = $config_val->save();
                if(!$bool){
                    return false;
                };
            }
        }
        return true;
    }

    /** 上传文件
     * @param $pic
     * @return bool|string
     */
    private static function uploadImg($pic)
    {
        $folder = '/sx_imgs';
        //判断文件夹是否存在，不存在创建
        if(!Storage::disk('public')->exists($folder)){
            Storage::makeDirectory($folder);
        }

        if($pic->isValid()) {
            $newFileName = md5(microtime()) . '.' .$pic -> getClientOriginalName();
            $ext=$pic->getClientOriginalExtension();//得到图片后缀；
            $newImagesName = $folder . '/' . $newFileName;
            Storage::disk('public')->put($newImagesName, file_get_contents($pic));
        }

        if(isset($newImagesName)){
            return 'upload'.$newImagesName;
        }else{
            return false;
        }

    }


}
