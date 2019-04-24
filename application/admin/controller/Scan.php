<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 17:09
 */

namespace app\admin\controller;

use app\admin\model\Scan as ScanModel;
use think\Controller;
use think\facade\Request;

class Scan extends Controller
{
    public function lst()
    {
        $openid = Request::param('openid');
        $scan = ScanModel::getScanLst($openid);

        $this->assign('scan',$scan);
        return view();
    }

}