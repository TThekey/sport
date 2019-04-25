<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;

class Base  extends Controller
{
    public function initialize()
    {
        if (!session("username")) {
            $this->error("请先登录", "admin/login/login");
        }

    }
}