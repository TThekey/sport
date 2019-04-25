<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/25
 * Time: 10:17
 */

namespace app\admin\model;

use app\admin\model\Code as CodeMOdel;
use think\facade\Env;
use think\Model;

class Group extends Model
{
    //每页显示3条
    public static function getAllGroups()
    {
        $groups = self::paginate(3);
        return $groups;
    }

    //删除二维码组
    public static function delGroup($group)
    {
        $res = CodeMOdel::where('group',$group)->find();
        if($res){
            return [
                'res' => '0',
                'msg' => $group.'组内还有二维码，删除失败'
            ];
        }
        else{
            $dir = Env::get('root_path') . 'public/qrcode/'.$group;
            //删除二维码目录
            rmdir($dir);
            $del = self::where('name',$group)->delete();
            if($del){
                return [
                    'res' => '1',
                    'msg' => '删除成功'
                ];
            }

        }
    }

}