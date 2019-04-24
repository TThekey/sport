<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/24
 * Time: 18:51
 */

namespace app\admin\service;

use app\admin\service\ZipFileService;
use think\Db;
use think\facade\Config;
use app\admin\model\Code as CodeModel;

class DownloadService
{
    public static function downloadCodeByGroup($group)
    {

        $src = Db::table('code')->where('group',$group)->field('src')->select();

        $code  = array();
        foreach ($src as $v) {
            $code[] = Config::get('extra.root_path').$v['src'];
        }


        $dfile = tempnam('/tmp', 'tmp');//产生一个临时文件，用于缓存下载文件
        $zip = new \ZipArchive();
        $zip->open($dfile, \ZipArchive::CREATE);
        foreach ($code as $file) {
            // download file
            $fileContent = file_get_contents($file);

            $zip->addFromString(basename($file), $fileContent);
        }
        $zip->close();
        $filename = $group.'.zip'; //下载的默认文件名
//        $zip = new ZipFileService();
//
//        $zip->add_path($code_path);
//        $zip->output($dfile);

        // 下载文件
        ob_clean();
        header('Pragma: public');
        header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control:no-store, no-cache, must-revalidate');
        header('Cache-Control:pre-check=0, post-check=0, max-age=0');
        header('Content-Transfer-Encoding:binary');
        header('Content-Encoding:none');
        header('Content-type:multipart/form-data');
        header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
        header('Content-length:'. filesize($dfile));
        $fp = fopen($dfile, 'r');
        while(connection_status() == 0 && $buf = @fread($fp, 8192)){
            echo $buf;
        }
        fclose($fp);
        @unlink($dfile);
        @flush();
        @ob_flush();
        exit();
    }

}