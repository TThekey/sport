<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/8
 * Time: 13:35
 */

namespace app\api\model;

use think\Model;

class Scan extends Model
{
    //最近一次扫码时间
    public static function findScanDate($openid,$codeid)
    {
        self::where([
            'openid' => $openid,
            'codeid' => $codeid
        ])->order('scandate desc')->limit(1)->value('scandate');
    }

    //插入scan表
    public static function InsertScan($openid,$codeid)
    {
        $scandate = time(); //插入时间
        $data = [
            'openid' => $openid,
            'codeid' => $codeid,
            'scandate' => $scandate
        ];
        self::create($data);
    }


}