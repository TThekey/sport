<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/11
 * Time: 10:37
 */

namespace app\util;

use think\Request;


class WeixinUtil
{
    private $token = 'aabb';

    public function check()
    {
        $signature = Request::param('signature');
        $timestamp = Request::param('timestamp');
        $nonce = Request::param('nonce');
        $echostr = Request::param('echostr');

        $arr = array($timestamp,$nonce,$this->token);
        sort($arr, SORT_STRING);
        $tmp = implode($arr);
        $tmp = sha1($tmp);
        if($tmp == $signature){
            echo $echostr;
        }
    }

}