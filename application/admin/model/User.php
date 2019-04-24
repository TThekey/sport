<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 16:38
 */

namespace app\admin\model;


use think\Model;

class User extends Model
{
    public static function urlLst()
    {
        $user = self::where('status','=','1')->paginate(3);
        return $user;
    }

}