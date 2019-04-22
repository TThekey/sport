<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/8
 * Time: 14:02
 */

namespace app\api\model;


use think\Model;

class Code extends Model
{
    //根据codeid返回扫码次数
    public static function getTime($codeid)
    {
        self::where('codeid',$codeid)->value('time');
    }

}