<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/6
 * Time: 14:44
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\ScanService;
use think\facade\Config;
use app\api\model\Code as CodeModel;
use think\Request;

class Scan extends Controller
{

    /**
     * 校验序列号
     * 渲染页面
     * @return \think\response\View
     */
    public function checkStr(Request $request)
    {
        $code = $request->code;
        $codeid = $request->codeid;         //得到codeid
        $arr = ScanService::getID($code);   //向微信拿到openid
        $openid = $arr['openid'];
        $string = Config::get('string');    //得到唯一字符串
        $current_mbstr = md5($codeid.$string);

        //查出加密字符串
        $mb_str = CodeModel::where('codeid',$codeid)->value('mbstr');

        //check通过
        if($current_mbstr == $mb_str){
            $req = ScanService::scan($openid,$codeid);
            $req = json($req,$req['code']);
            return $req;
        }
        //check不通过
        else{
            $req = [
                'code' => 404,
                'time' => '',
                'msgcode' => 40000
            ];
            $req = json($req,$req['code']);
            return $req;
        }
    }


}