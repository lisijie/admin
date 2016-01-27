<?php

//应用代码路径
define('APP_PATH',  dirname(__DIR__) .'/app/');
//运行时数据目录
define('DATA_PATH', dirname(__DIR__) .'/data/');

define('RUN_ENV', isset($_SERVER['RUN_ENV']) ? $_SERVER['RUN_ENV'] : 'production');

if (RUN_ENV != 'production') {
	define('DEBUG', true);
}

// 框架引导程序路径，根据自身环境修改
require dirname(dirname(__DIR__)) .'/php-framework/system/App.php';

App::bootstrap();
App::run();
