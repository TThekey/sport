<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/8
 * Time: 13:36
 */

namespace app\api\service;

use app\api\model\Code;
use app\api\model\Scan as ScanModel;
use app\api\model\Code as CodeModel;
use think\Db;
use think\facade\Config;

class ScanService
{
    /**
     * 处理扫码逻辑
     * @param $openid
     * @param $codeid
     * @return array
     */
    public static function scan($openid,$codeid)
    {
        //根据codeid返回二维码信息
        $code = CodeModel::where('codeid',$codeid)->find();

        //判断是否是一个用户多次扫码
        $res = ScanModel::where([
            'openid' => $openid,
            'codeid' => $codeid
        ])->find();
        if($res){
            ScanService::InsertScan($openid,$codeid);
            $req = [
                'code' => 200,
                'time' => $code['time'],
                'msgcode' => 10000
            ];
            return $req;
        }

        //正常扫码
        else{
            //更新code表time字段
            Db::table('wx_code')->where('codeid', $codeid)->setInc('time');
            //插入scan表
            ScanService::InsertScan($openid,$codeid);

            $req = [
                'code' => 200,
                'time' => $code['time'],
                'msgcode' => 10001
            ];
            return $req;
        }

    }

    /**
     * 数据插入scan表
     * @param $userid
     * @param $codeid
     */
    public static function InsertScan($openid,$codeid)
    {
        $scandate = time(); //插入时间
        $data = [
            'openid' => $openid,
            'codeid' => $codeid,
            'scandate' => $scandate
        ];
        ScanModel::create($data);
    }

    /**
     * 与微信服务器交互
     * 拿到codeid和openid
     */
    public static function getID($code)
    {
        $AppID = Config::get('appid');  //AppId
        $AppSecret = Config::get('appsecret');  //AppSecret
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$AppID.'&secret='.$AppSecret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr=json_decode($json,1);
        return $arr;

    }




}