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
                'msgcode' => 40000
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
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$AppID.'&secret='.$AppSecret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        //拿到openid
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr=json_decode($json,1);
        return $arr;
    }

}