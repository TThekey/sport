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

//========api模块========
Route::rules([
    //建立连接
    'connection' => 'api/User/guanzhu',
    //校验是否关注
    'checkguanzhu' => 'api/User/checkGuanzhu'
],'GET');

//关注后回调地址
Route::post('connection','api/User/guanzhu');


//========admin模块======
Route::rules([
    //后台首页
    'index' => 'admin/Index/index',
    //登录
    'login' => 'admin/Login/login',
    //退出登录
    'logout' => 'admin/Login/logout',
    //用户列表
//    'userlst' => 'admin/User/lst',
    //扫描列表
//    'scanlst' => 'admin/Scan/lst',
    //创建二维码
    'createcode' => 'admin/Code/create',
    //二维码列表
//    'codelst' => 'admin/Code/lst',
    //删除二维码
    'delcode' => 'admin/Code/del',
    //批量下载
    'downLoadCode' => 'admin/Code/downLoadCode',
    //创建二维码组
    'creategroup' => 'admin/Group/create',
    //二维码组列表
//    'grouplst' => 'admin/Group/lst',
    //删除二维码组
    'delgroup' => 'admin/group/del',
],'GET');

Route::rules([
    //创建二维码
    'createcode' => 'admin/Code/create',
    //创建二维码组
    'creategroup' => 'admin/Group/create',
    //登录
    'login' => 'admin/Login/login',
],'POST');






