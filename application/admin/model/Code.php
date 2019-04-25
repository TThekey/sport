<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/23
 * Time: 21:16
 */

namespace app\admin\model;

use think\facade\Env;
use think\Model;

class Code extends Model
{
    //每页显示10条
    public static function getAllCode()
    {
        $codes = self::paginate(10);
        return $codes;
    }


    public static function getCodeByGroup($group)
    {
        $codes = self::where('group',$group)->paginate(5,false,['query' => request()->param()]);
        return $codes;
    }

    //删除二维码
    public static function delCode($codeid)
    {
        $src = self::where('codeid',$codeid)->value('src');
        $file = Env::get('root_path') . 'public'.$src;

        if(file_exists($file))
        {
            //删除服务器图片
            unlink($file);
        }else{
            return [
                'res' => '0',
                'msg' => '本地图片不存在，删除失败'
            ];
        }

        //删除数据库数据
        $res = self::where('codeid',$codeid)->delete();
        if($res)
        {
            return [
                'res' => '1',
                'msg' => '删除成功'
            ];
        }else{
            return [
                'res' => '0',
                'msg' => '删除失败'
            ];
        }
    }

}