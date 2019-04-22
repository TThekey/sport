<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/18
 * Time: 13:34
 */

namespace app\api\controller;

use app\api\service\UserService;
use app\api\model\User as UserModel;
use think\Controller;
use think\facade\Request;
use think\facade\Config;


class User extends Controller
{
    /**
     * 检测用户是否关注
     */
    public function checkGuanzhu()
    {
        //code码
        $code = Request::param('code');
        //得到codeid
        $codeid  = Request::param('state');
        //向微信拿到openid
        $arr = UserService::getOpenID($code);
        $openid = $arr['openid'];
        //查看关注状态
        $status = UserModel::where('openid',$openid)->value('status');


        //已关注
        if($status == 1){
            //检验序列号
            $req = UserService::checkStr($codeid,$openid);
            $req['status'] = $status;

//            $req['time'] = 10;
//            $req['msgcode'] =10001;

            $this->assign('req',$req);
            return view('watch');
        }
        //未关注
        else {
            $req = [
                'code' => 200,
                'time' => '',
                'scandate' => '',
                'msgcode' => '',
                'status' => 0
            ];
            $this->assign('req',$req);
            return view('watch');
        }
    }

    /**
     * 微信服务器回调地址
     */
    public function guanzhu()
    {
//        //检验签名的合法性
//        $echostr = input('echostr');
//        if ($this->_checkSignature()) {
//            //签名合法，告知微信公众平台服务器
//            echo $echostr;

        $xml_str = file_get_contents("php://input");
        $openid = Request::param('openid');
        if (!empty($xml_str)) {
            libxml_disable_entity_loader(true);
            //禁止xml实体解析，防止xml注入
            $request_xml = simplexml_load_string($xml_str, 'SimpleXMLElement', LIBXML_NOCDATA);
            //判断该消息的类型，通过元素MsgType
            if($request_xml->MsgType = 'event'){
                $event = $request_xml->Event;
                //关注事件
                if($event=='subscribe'){
                    UserModel::subscribeEvent($openid,1);
                }
                //取消关注
                elseif($event=='unsubscribe'){
                    UserModel::updateStatus($openid,0);
                }
            }

        }
    }

    private function _checkSignature()
    {
        //获得由微信公众平台请求的验证数据
        $signature = input('signature');
        $timestamp = input('timestamp');
        $nonce = input('nonce');
        $token = Config::get('extra.token');
        //将时间戳，随机字符串，token按照字母顺序排序，并连接
        $tmp_arr = array($token, $timestamp, $nonce);
        sort($tmp_arr, SORT_STRING);//字典顺序
        $tmp_str = implode($tmp_arr);//连接
        $tmp_str = sha1($tmp_str);//sha1加密
        if ($signature == $tmp_str) {
            return true;
        } else {
            return false;
        }
    }

}