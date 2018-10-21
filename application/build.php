<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 读取自动生成定义文件
return [
    // 生成应用公共文件
    '__file__' => ['common.php', 'config.php', 'database.php'],

    // 定义common模块的自动生成 （按照实际定义的文件名生成）
    'common' => [
        '__dir__'    => [ 'model'],
        'controller' => ['Category','Admin'],
    ],
    // 其他更多的模块定义
    'admin' => [
        '__dir__' => ['controller','view'],
        'controller' => ['Index'],
        'view' => ['index/index']
    ],
    'api' => [
        '__dir__' => ['controller','view'],
        'controller' => ['Index','Image'],
        'view' => ['index/index']
    ],
    'bis' => [
        '__dir__' => ['controller','view'],
        'controller' => ['Register','Login'],
    ]
];