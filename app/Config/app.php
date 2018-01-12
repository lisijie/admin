<?php

return [
    // 语言包
    'lang' => 'zh_CN',
    // 时区
    'timezone' => 'PRC',
    // 加密密钥
    'secret_key' => 'app secret key',
    // 视图模版配置
    // 支持以下模版引擎：
    //  - native 使用原生PHP语法作为模版引擎
    //  - smarty 使用smarty模版引擎
    'view' => [
        'engine' => 'native',
        'options' => [
            'template_dir' => VIEW_PATH,
            'ext' => '.php',
        ],
    ],

    // 路由配置
    // 支持以下几种路由方式：
    //  - simple 简单路由，使用查询参数进行路由，例如 index.php?r=main/index 表示路由到 MainController::indexAction()
    //  - pathinfo PATH_INFO方式，URL形式如： www.domain.com/index.php/main/index?foo=bar
    //  - rewrite URL重写方式，需要在服务器配置重写规则，然后可在路由配置文件 route.php 进行个性化配置
    'router' => [
        'type' => 'simple',
        'options' => [
            'default_route' => 'main/index', //默认路由
        ],
    ],

    //SESSION
    'session' => [
        'type' => 'file',
    ],

    // 日志配置
    // 日志可配置多个实例，用于对不同模块有不同日志记录需求的项目，通常情况下使用一个默认就足够了。
    // 使用 App::getLogger() 不带参数获取的是默认实例。
    // 在没有日志配置的情况下，使用 App::getLogger() 依然可以获取到实例，但是写入的日志不会保存。
    'logger' => [
        // 默认日志
        'default' => [
            // 日志处理器1
            [
                'level' => 1, //日志级别: 1-5
                'handler' => \Core\Logger\Handler\FileHandler::class, //日志处理器
                'config' => [
                    'savepath' => DATA_PATH . '/logs/', //日志保存目录
                    'filesize' => 0, //文件分割大小
                    'filename' => '{Y}{m}{d}.log',
                ],
            ]
        ],
        'command' => [
            [
                'level' => 1, //日志级别: 1-5
                'handler' => \Core\Logger\Handler\FileHandler::class, //日志处理器
                'config' => [
                    'savepath' => DATA_PATH . '/logs/', //日志保存目录
                    'filesize' => 0, //文件分割大小
                    'filename' => 'cmd-{Y}{m}{d}.log',
                ],
            ]
        ],
        // DB的日志处理，当DB开启debug时使用
        'database' => [
            [
                'level' => 1, //日志级别: 1-5
                'handler' => \Core\Logger\Handler\FileHandler::class, //日志处理器
                'config' => [
                    'savepath' => DATA_PATH . '/logs/', //日志保存目录
                    'filesize' => 0, //文件分割大小
                    'filename' => 'db-{Y}{m}{d}.log',
                ],
            ]
        ],
    ],

    // 文件上传设置
    'upload' => [
        'allow_types' => 'jpg|png|gif',
        'save_path' => PUBLIC_PATH . 'upload/{Y}{m}/',
        'maxsize' => 10240, // 10M
    ],

    // 缓存配置
    'cache' => [
        'default' => 'file',
        'file' => array(
            //key前缀
            'prefix' => '',
            //缓存文件保存目录
            'save_path' => DATA_PATH . 'cache/',
        ),
    ],

    // 数据库配置
    // 大型项目中通常会进行分库和读写分离，可在这里配置多个数据库节点
    // 在代码中使用 App::getDb('default') 获取指定节点的DB实例。
    'database' => [
        // 默认数据库节点
        'default' => [
            // 是否开启慢查询日志，0为关闭
            'slow_log' => 0,
            // 表前缀
            'prefix' => 't_',
            // 字符集
            'charset' => 'utf8',
            // 写库
            'write' => [
                'dsn' => "mysql:host=localhost;port=3306;dbname=test;charset=utf8",
                'username' => 'root',
                'password' => '',
                'pconnect' => false,
            ],
            // 读库，只允许配一个地址，如果是一主多从的话，建议使用haproxy或其他中间件做转发
            'read' => [
                'dsn' => "mysql:host=localhost;port=3306;dbname=test;charset=utf8",
                'username' => 'root',
                'password' => '',
                'pconnect' => false,
            ]
        ],
    ],
];
