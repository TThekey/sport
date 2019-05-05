<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 17:16
 */

namespace app\admin\model;
use think\Model;

class Scan extends Model
{
    public static function getScanLst($openid,$start,$limit)
    {
        $scan = self::where('openid',$openid)->limit($start,$limit)->select();
        foreach ($scan as $v){
            $v['scandate'] = date("Y-m-d H:i:s",$v['scandate']);
        }
        return $scan;
    }

}