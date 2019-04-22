<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/11
 * Time: 11:31
 */

namespace app\api\model;


use think\Model;

class User extends Model
{
    //关注事件
    public static function subscribeEvent($openid,$status)
    {
        $res = self::where('openid',$openid)->find();
        if($res)
        {
            self::updateStatus($openid,$status);
        }
        else{
            self::create([
                'openid' => $openid,
                'status' => $status
            ]);
        }
    }

    //更新关注状态
    public static function updateStatus($openid,$status)
    {
        self::where('openid',$openid)->update(['status' => $status]);
    }



}