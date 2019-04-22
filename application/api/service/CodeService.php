<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/8
 * Time: 15:48
 */

namespace app\api\service;

use app\api\model\Code as CodeModel;
use think\facade\Config;
use think\facade\Env;

class CodeService
{
    /**
     * 生成二维码
     * 存入code表
     */
    public static function getQrCode()
    {
        //$savePath 图片存储路径
        $savePath = Env::get('root_path') . 'public/qrcode/';
        //路径
        $webPath = '/public/qrcode/';

        //生成序列号
        $cid = snMaker();

        //传给微信服务器
        $wxurl = self::createUrl($cid);

        //$qrData 手机扫描后要跳转的网址
        $qrData = $wxurl;

        // $qrLevel 默认纠错比例 分为L、M、Q、H四个等级，H代表最高纠错能力
        $qrLevel = 'H';
        //$qrSize 二维码图大小，1－10可选，数字越大图片尺寸越大
        $qrSize = '8';
        // $savePrefix 图片名称前缀
        $savePrefix = 'NickBb';
        $filename = createQRcode($savePath, $qrData, $qrLevel, $qrSize, $savePrefix);

        //二维码路径
        $pic = $webPath.$filename;
        //加密序列号
        $mb_str = self::setSeNum($cid);

        //存入code表
        CodeModel::create([
            'codeid' => $cid,
            'src'    => $pic,
            'mbstr'  => $mb_str
        ]);
    }


    /**
     * 加密序列号
     *
     */
    public static function setSeNum($cid)
    {
        //得到唯一字符串
        $string = Config::get('extra.string');

        //加密序列号和唯一字符串
        $mb_str = md5($cid.$string);
        return $mb_str;
    }

    /**
     * 生成二维码跳转网址
     */
    public static function createUrl($cid)
    {
        $codeid = $cid;
        //appId
        $AppID= Config::get('extra.app_id');
        //回调地址
        $callback  = Config::get('extra.callback');
        $callback = urlencode($callback);
        $wxurl = sprintf(Config::get('extra.wx_codeurl'),$AppID,$callback,$codeid);
        return $wxurl;
    }

}