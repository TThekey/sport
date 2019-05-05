<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/25
 * Time: 10:17
 */

namespace app\admin\controller;


use think\Controller;
use think\facade\Env;
use think\facade\Request;
use app\admin\model\Group as GroupModel;

class Group extends Base
{
    /**
     * 二维码组数据接口
     */
    public function lst()
    {
        $page = Request::param('page');
        $page = intval($page);
        $limit = Request::param('limit');
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        $groups = GroupModel::getAllGroups($start, $limit);

        $count = GroupModel::count();

        $list["msg"] = "";
        $list["code"] = 0;
        $list["count"] = $count;
        $list["data"] = $groups;


        return json($list);
    }

    /**
     * 二维码组列表页面
     */
    public function lstView(){
        return view('group/lst');
    }

    /**
     * 创建二维码组
     */
    public function create()
    {
        if (Request::isPost()) {
            $name = Request::param('name');
            $res = GroupModel::where('name', $name)->find();
            if ($res) {
                return $this->error('组名已存在，请更换');
            } else {
                GroupModel::create([
                    'name' => $name
                ]);

                $savePath = Env::get('root_path') . 'public/qrcode/'.$name.'/';
                mkdir($savePath,0777,true);

                return $this->success('新组成功创建');
            }
        }

        return view();
    }


    /**
     * 删除二维码组
     */
    public function del()
    {
        $id = Request::param('id');
        $result = GroupModel::delGroup($id);
        return json($result);
    }

}