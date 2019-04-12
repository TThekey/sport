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

class CodeService
{
    //序列号
    private static $se_num;
    //存储路径
    private static $pic;

    /**
     * 生成二维码
     * @return bool|string
     */
    public static function getQrCode()
    {
        //$savePath 图片存储路径
        $savePath = APP_PATH . '/../Public/qrcode/';
        //路径
        $webPath = 'http://zerg.com/qrcode/';

        //生成序列号
        self::$se_num = snMaker();

        //传给微信服务器
        $wxurl = CodeService::createUrl();

        $qrData = $wxurl;
//        //$qrData 手机扫描后要跳转的网址
//        $qrData = 'http://zerg.com/api/Scan/checkStr?codeid='.self::$se_num;
        // $qrLevel 默认纠错比例 分为L、M、Q、H四个等级，H代表最高纠错能力
        $qrLevel = 'H';
        //$qrSize 二维码图大小，1－10可选，数字越大图片尺寸越大
        $qrSize = '8';
        // $savePrefix 图片名称前缀
        $savePrefix = 'NickBb';
        $filename = createQRcode($savePath, $qrData, $qrLevel, $qrSize, $savePrefix);

        self::$pic = $webPath.$filename;


        $mb_str = self::setSeNum();



        //存入code数据表
        CodeModel::create([
            'codeid' => self::$se_num,
            'src'    => self::$pic,
            'mbstr'  => $mb_str
        ]);

        return $filename;
    }


    /**
     * 加密序列号
     *
     */
    public static function setSeNum()
    {
        //得到唯一字符串
        $string = Config::get('string');

        //加密序列号和唯一字符串
        $mb_str = md5(self::$se_num.$string);
        return $mb_str;
    }

    /**
     * 生成二维码跳转网址
     */
    public static function createUrl()
    {
        $codeid = self::$se_num;
        $AppID= Config::get('appid');  //appId
        $callback  =  'http://http://www.tthekey.xyz/zerg/public/checkstr'; //回调地址
        $callback = urlencode($callback);

        $wxurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$AppID&redirect_uri=$callback&response_type=code&scope=snsapi_base&state=$codeid#wechat_redirect";
        return $wxurl;
    }

}