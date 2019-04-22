<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/18
 * Time: 13:37
 */

namespace app\api\service;

use think\facade\Config;
use app\api\model\Code as CodeModel;

class UserService
{
    /**
     * 检验序列号
     */
    public static function checkStr($codeid,$openid)
    {
        $string = Config::get('extra.string');    //得到唯一字符串
        $current_mbstr = md5($codeid . $string);

        //查出加密字符串
        $mb_str = CodeModel::where('codeid', $codeid)->value('mbstr');

        //check通过
        if ($current_mbstr == $mb_str) {
            $req = ScanService::scan($openid, $codeid);
            return $req;
        }
        //check不通过
        else {
            $req = [
                'code' => 404,
                'time' => '',
                'scandate' => '',
                'msgcode' => 40000,
            ];
            return $req;
        }
    }



    /**
     * 与微信服务器交互
     * 拿到openid
     */
    public static function getOpenID($code)
    {
        $AppID = Config::get('extra.app_id');  //AppId
        $AppSecret = Config::get('extra.app_secret');  //AppSecret
        $url = sprintf(Config::get('extra.wx_openurl'),$AppID,$AppSecret,$code);
        //发起请求
        $result = curlGet($url);
        return $result;
    }

}