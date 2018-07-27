<?php
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//echo dirname(__DIR__);exit;
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require(dirname(__DIR__) . '/config/bootstrap.php');
$config = require __DIR__ . '/../config/web.php';

$Application = new yii\web\Application($config);
$Application->run();
