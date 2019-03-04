<?php

namespace App;

use App\channel\skuSDK;
use Illuminate\Database\Eloquent\Model;

class goods_kind extends Model
{
    protected $table = 'goods_kind';
    protected $primaryKey = 'goods_kind_id';
    public $timestamps = false;

    public function configs()
    {
        return $this->hasMany(kind_config::class, 'kind_primary_id', 'kind_type_id')->with('vals');
    }

    public static function attr_cartesian_product($goods_kind_id)
    {
        $goods_kind = goods_kind::find($goods_kind_id);

        $skuSDK = new skuSDK($goods_kind_id, $goods_kind->goods_product_id, $goods_kind->goods_kind_user_type);
        $config_sort = $skuSDK->get_attr_sku_config_sort();
        $kind_configs = kind_config::with('vals')->where('kind_primary_id', $goods_kind_id)->get()->toArray();
        $result_arr = [];
        if ($kind_configs) {
            $first_configs = array_shift($kind_configs);
            foreach ($first_configs['vals'] as $val) {
                $val['kind_config_msg'] = $first_configs['kind_config_msg'];
                $val['kind_config_english_msg'] = $first_configs['kind_config_english_msg'];
//                if($kind_configs){
////                    $result_arr[$first_configs['kind_config_id']] = $val;
//                    $result_arr[] = [$first_configs['kind_config_id']=>$val];
//                }else{
                    $result_arr[] = [$first_configs['kind_config_id']=>$val];
//                }
            }
//            dd($result_arr);
            foreach ($kind_configs as $v) {
                $result2 = [];
                foreach ($result_arr as $k1 => $item1) {
                    foreach ($v['vals'] as $item2) {
                        $item2['kind_config_msg'] = $v['kind_config_msg'];
                        $item2['kind_config_english_msg'] = $v['kind_config_english_msg'];
                        if (array_key_exists('kind_config_msg', $item1)) {
                            $temp[$item1['kind_type_id']] = $item1;
                        } else {
                            $temp = $item1;
                        }
                        $temp[$item2['kind_type_id']] = $item2;
                        $result2[] = $temp;
                    }
                }
                $result_arr = $result2;
            }


        }
        if($result_arr){
            foreach ($result_arr as &$value) {
                $value['sku'] = '';
                $value['val'] = '';
                foreach ($config_sort as $item) {
                    if(isset($value[$item])){
                        $value['sku'] .= $value[$item]['kind_val_sku'];
                        $value['val'] .= $value[$item]['kind_val_msg'] . ',';
                    }else{
                        $value['sku'] .= '00';
                    }
                }
            }
            unset($value);
        }

        return $result_arr;
    }

    public static function combineDika($data)
    {
        $result = array();
        foreach (array_shift($data) as $k => $item) {
            $result[] = array($k => $item);
        }
        foreach ($data as $k => $v) {
            $result2 = [];
            foreach ($result as $k1 => $item1) {
                foreach ($v as $k2 => $item2) {
                    $temp = $item1;
                    $temp[$k2] = $item2;
                    $result2[] = $temp;
                }
            }
            $result = $result2;
        }
        return $result;
    }
}
