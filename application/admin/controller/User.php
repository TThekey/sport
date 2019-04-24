<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 16:06
 */

namespace app\admin\controller;

use app\admin\model\User as UserModel;
use think\Controller;

class User extends Controller
{
    public function lst()
    {
        $user = UserModel::urlLst();
        $this->assign('user',$user);
        return view();
    }

}