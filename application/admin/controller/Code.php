<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/22
 * Time: 21:29
 */

namespace app\admin\controller;

use app\admin\service\CodeService;
use app\admin\service\DownloadService;
use app\admin\model\Code as CodeModel;
use app\admin\model\Group as GroupModel;
use think\facade\Cache;
use think\facade\Request;

class Code extends Base
{

    /**
     * 二维码数据接口
     */
    public function lst()
    {
        $page = Request::param('page') ? Request::param('page') : 1;
        $page = intval($page);
        $limit = Request::param('limit') ? Request::param('limit') : 10;
        $limit = intval($limit);
        $start = $limit * ($page - 1);

        if(Cache::get('group')){
            $group = Cache::get('group');
            if($group == 'all'){
                $codes = CodeModel::getAllCode($start,$limit);
                $count = CodeModel::count();
            }
            else{
                $codes = CodeModel::getCodeByGroup($group,$start,$limit);
                $count = CodeModel::where('group',$group)->count();
            }
        }
        else{
            $codes = CodeModel::getAllCode($start,$limit);
            $count = CodeModel::count();
        }

        //条数
//        $count = CodeModel::count();

        $list["msg"] = "";
        $list["code"] = 0;
        $list["count"] = $count;
        $list["data"] = $codes;
        return json($list);
    }


    /**
     * 二维码列表页面
     */
    public function lstView()
    {
        $groups = GroupModel::select();
        if(Request::param('group')){
            $group = Request::param('group');
            Cache::set('group',$group);
            return view('code/lst',[
                'group' => $group,
                'groups' => $groups
            ]);
        }
        else{
            return view('code/lst',[
                'group' => 'all',
                'groups' => $groups
            ]);
        }

    }

    /**
     * 创建二维码
     */
    public function create()
    {
        $groups = GroupModel::select();

        if(Request::isPost())
        {
            $qrsize = Request::param('qrsize');
            $group = Request::param('group');
            //生成二维码
            $res = CodeService::getQrCode($qrsize,$group);
            if($res){
                $this->success('生成成功');
            }
        }

        $this->assign('groups',$groups);
        return view();
    }

    /**
     * 删除二维码
     */
    public function del()
    {
        $codeid = Request::param('codeid');
        $result = CodeModel::delCode($codeid);
        return json($result);
    }


    /**
     * 下载二维码
     */
    public function downLoadCode()
    {
        $group = Request::param('group');
        DownloadService::downloadCodeByGroup($group);
    }

}