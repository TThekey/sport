<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/25
 * Time: 14:10
 */

namespace app\admin\controller;


use think\Controller;
use think\facade\Request;
use app\admin\model\Admin as AdminModel;

class Login extends Controller
{
    /**
     * 登录逻辑
     */
    public function login()
    {
        if(Request::isPost())
        {
            $username = Request::param('username');
            $password = Request::param('password');
            $res = AdminModel::checkLogin($username,$password);

            if($res == 1){
                return $this->success('登录成功');
            }
            elseif($res == 2){
                $this->error('密码错误');
            }
            elseif($res == 3){
                $this->error('用户不存在');
            }

        }
        return view();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        $status = Request::param('status');
        if($status == 'OK'){
            session(null);  //清除session
            return $this->success("退出成功");
        }
    }


}