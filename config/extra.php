<?php
/**
 * Created by PhpStorm.
 * User: GYW
 * Date: 2019/4/22
 * Time: 10:57
 */
return [
    // 唯一字符串
    'string'                => 'VaHQ4kU32hOatRCYwXqA',
    //appid
    'app_id'                => 'wx37bd29a38c7a20ee',
    //appsecret
    'app_secret'            => '321f07405de2031dd8c28cd7c21702aa',
    //token
    'token'                 => 'VaHQ4kU32hOat',

    //二维码回调地址
    'callback'              => 'http://sport.jiyichuancheng.com/checkguanzhu',
    //请求微信服务器拿code码
    'wx_codeurl'            => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect',
    //请求微信服务器拿openid
    'wx_openurl'            => 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code'


];