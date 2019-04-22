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
        //根据codeid返回扫码次数
        $time = CodeModel::getTime($codeid);

        //判断是否是一个用户多次扫码
        $res = ScanModel::where([
            'openid' => $openid,
            'codeid' => $codeid
        ])->find();
        if($res){
            //最近一次扫码时间
            $scandate = ScanModel::findScanDate($openid,$codeid);

            //插入scan表
            ScanModel::InsertScan($openid,$codeid);

            $req = [
                'code' => 200,
                'time' => $time,
                'scandate'=> $scandate,
                'msgcode' => 10000
            ];
            return $req;
        }

        //正常扫码
        else{
            //更新code表time字段
            Db::table('code')->where('codeid', $codeid)->setInc('time');
            //插入scan表
            ScanModel::InsertScan($openid,$codeid);

            //最近一次扫码时间
            $scandate = time();

            $req = [
                'code' => 200,
                'time' => $time,
                'scandate' => $scandate,
                'msgcode' => 10001
            ];
            return $req;
        }

    }
    
}