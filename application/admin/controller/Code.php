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
use think\Controller;
use think\Db;
use think\facade\Request;

class Code extends Controller
{
    public function lst()
    {
        $groups = Db::table('code')->distinct(true)->field('group')->select();

        if(Request::param('group'))
        {
            $group = Request::param('group');
            $codes = CodeModel::getCodeByGroup($group);
            $this->assign([
                'groups' => $groups,
                'group'  => $group,
                'codes'  => $codes,

            ]);
            return view();

        }else{
            $codes = CodeModel::getAllCode();
            $this->assign([
                'groups' => $groups,
                'group'  => 'all',
                'codes'  => $codes,

            ]);
            return view();
        }
    }

    public function create()
    {
        if(Request::isPost())
        {
            $qrsize = Request::param('qrsize');
            $qrlevel = Request::param('qrlevel');
            $group = Request::param('group');
            //生成二维码
            CodeService::getQrCode($qrsize,$qrlevel,$group);
            return $this->success('二维码成功生成','admin/code/lst');
        }
        return view('code/create');
    }

    public function del()
    {
        $codeid = Request::param('codeid');
        $result = CodeModel::delCode($codeid);
        if($result['res'] == 1)
        {
            return $this->success($result['msg'],'admin/code/lst');

        }else{
            return $this->error($result['msg'],'admin/code/lst');
        }
    }


    public function downloadCode()
    {
        $group = Request::param('group');
        if($group == 'all'){
            return $this->error('不支持全量下载','admin/code/lst');
        }else{
            DownloadService::downloadCodeByGroup($group);
        }

    }

}