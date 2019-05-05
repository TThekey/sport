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
use think\facade\Cache;
use think\facade\Request;


class Scan extends Base
{
    /**
     * 扫描数据接口
     */
    public function lst()
    {
        $page = Request::param('page');
        $page = intval($page);
        $limit = Request::param('limit');
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        $openid = Cache::get('openid');


        $scan = ScanModel::getScanLst($openid,$start,$limit);

        $count = ScanModel::count();

        $list["msg"] = "";
        $list["code"] = 0;
        $list["count"] = $count;
        $list["data"] = $scan;

        return json($list);
    }


    /**
     * 扫描列表
     */
    public function lstView()
    {
        $openid = Request::param('openid');
        Cache::set('openid',$openid);
        return view('scan/lst');
    }

}