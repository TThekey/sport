<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 16:06
 */

namespace app\admin\controller;

use app\admin\model\User as UserModel;
use think\Controller;
use think\facade\Request;

class User extends Base
{
    /**
     * 用户数据接口
     */
    public function lst()
    {
        $page = Request::param('page');
        $page = intval($page);
        $limit = Request::param('limit');
        $limit = intval($limit);
        $start = $limit * ($page - 1);


        $user = UserModel::urlLst($start, $limit);

        $count = UserModel::where('status',1)->count();

        $list["msg"] = "";
        $list["code"] = 0;
        $list["count"] = $count;
        $list["data"] = $user;

        return json($list);
    }


    /**
     * 用户列表页面
     */
    public function lstView()
    {
        return view('user/lst');

    }

}