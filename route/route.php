<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

//关注后回调地址
Route::post('connection','api/User/guanzhu');

//========api模块========
Route::rules([
    //建立连接
    'connection' => 'api/User/guanzhu',
    //校验是否关注
    'checkguanzhu' => 'api/User/checkGuanzhu'
],'GET');


//========admin模块======
Route::rules([
    //后台首页
    'index' => 'admin/Index/index',
    //用户列表
    'userlst' => 'admin/User/lst',
    //扫描列表
    'scanlst' => 'admin/Scan/lst',
    //创建二维码
    'createcode' => 'admin/Code/create',
    //二维码列表
    'codelst' => 'admin/Code/lst',
    //删除二维码
    'delcode' => 'admin/Code/del',
    //批量下载
    'downloadcode' => 'admin/Code/downloadCode'

],'GET');

//提交数据
Route::post('createcode','admin/Code/create');

////后台首页
//Route::get('index','admin/Index/index');
////用户列表
//Route::get('userlst','admin/User/lst');
//
////创建二维码
////界面
//Route::get('createcode','admin/Code/create');

//
////二维码列表
//Route::get('codelst','admin/Code/lst');
//
////删除二维码
//Route::get('delcode','admin/Code/del');
//
////批量下载
//Route::get('downloadcode','admin/Code/downloadCode');


//扫描列表
//Route::get('scanlst','admin/Scan/lst');



