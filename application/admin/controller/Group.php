<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/25
 * Time: 10:17
 */

namespace app\admin\controller;


use think\Controller;
use think\facade\Request;
use app\admin\model\Group as GroupModel;

class Group extends Base
{
    /**
     * 二维码组列表
     */
    public function lst()
    {
        $groups = GroupModel::getAllGroups();
        $this->assign('groups',$groups);
        return view();
    }

    /**
     * 创建二维码组
     */
    public function create()
    {
        if(Request::isPost())
        {
            $name = Request::param('name');
            $res = GroupModel::where('name',$name)->find();
            if($res){
                return $this->error('组名已存在，请更换','admin/group/create');
            }
            else{
                GroupModel::create([
                    'name' => $name
                ]);
                return $this->success('组名成功生成','admin/group/lst');
            }
        }

        return view();
    }


    /**
     * 删除二维码组
     */
    public function del()
    {
        $group = Request::param('group');
        $result = GroupModel::delGroup($group);
        if($result['res'] == 1)
        {
            return $this->success($result['msg'],'admin/group/lst');
        }else{
            return $this->error($result['msg'],'admin/group/lst');
        }

    }

}