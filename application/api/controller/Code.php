<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/11
 * Time: 17:37
 */

namespace app\api\controller;

use app\api\service\CodeService;
use think\Controller;

class Code extends Controller
{
    /**
     * 生成二维码
     */
    public function getCode()
    {
        CodeService::getQrCode();
        return '二维码成功生成在public/qrcode目录下';
    }

}