<?php
namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;

class Base  extends Controller
{
    public function initialize()
    {
        if (!session("username")) {
            $this->redirect('/index');
        }

    }
}