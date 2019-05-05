<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/25
 * Time: 15:09
 */

namespace app\admin\model;


use think\Model;

class Admin extends Model
{
    public static function checkLogin($username,$password)
    {
        $user = self::where('username',$username)->find();
        if($user){
            if($password == $user['password']){
                session("username",$username);  //存入session
                session("uid",$user["id"]);
                return 1;   //登录成功
            }
            else{
                return 2;   //密码错误
            }
        }
        else{
            return 3;       //用户不存在
        }
    }


}