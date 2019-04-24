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
    public static function getScanLst($openid)
    {
        $scan = self::where('openid',$openid)->paginate(5,false,['query' => request()->param()]);
        return $scan;
    }

}