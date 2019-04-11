<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/11
 * Time: 10:51
 */

namespace app\api\controller;


use think\Controller;
use app\util\WeixinUtil;

class Weixin extends Controller
{
    public function index()
    {
        $weixin = new WeixinUtil();
        return $weixin->check();
    }

}