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

Route::rules([
    //生成二维码
   'getcode' => 'api/Code/getCode',
    //建立连接
    'connection' => 'api/User/guanzhu',
    //校验是否关注
    'checkguanzhu' => 'api/User/checkGuanzhu'
],'GET');



