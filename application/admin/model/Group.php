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
    public static function getAllGroups($start,$limit)
    {
        $groups = self::limit($start,$limit)->select();
        return $groups;
    }

    //删除二维码组
    public static function delGroup($id)
    {
        $group = self::where('id',$id)->value('name');
        $res = CodeMOdel::where('group',$group)->find();
        if($res){
            return [
                'code' => '0',
                'msg' => '组内还有二维码，删除失败'
            ];
        }
        else{
            $dir = Env::get('root_path') . 'public/qrcode/'.$group;
            //删除二维码目录
            rmdir($dir);
            $del = self::where('id',$id)->delete();
            if($del){
                return [
                    'code' => '1',
                    'msg' => '删除成功'
                ];
            }

        }
    }

}