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
        $filename = CodeService::getQrCode();
        $this->assign('filename',$filename); //二维码路径
        return view('qrcode');
    }

}