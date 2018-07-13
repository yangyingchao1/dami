<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $ws = new \swoole_websocket_server("0.0.0.0", 9502);

        //监听WebSocket连接打开事件
        $ws->on('open', function ($ws, $request) {
            //var_dump($request->fd, $request->get, $request->server);
            $users = [];
            $users = Yii::$app->redis->get('fds');
            if($users){
                $users = json_decode($users,1);
                array_push($users,$request->fd);
            }else{
                $users = [$request->fd];
            }
            Yii::$app->redis->set('fds',json_encode($users));
            echo $request->fd.PHP_EOL;
            //$ws->push($request->fd,file_get_contents('http://imgsrc.baidu.com/imgad/pic/item/267f9e2f07082838b5168c32b299a9014c08f1f9.jpg'),WEBSOCKET_OPCODE_BINARY);
            $ws->push($request->fd,$request->fd. ": hello, welcome\n");
        });

        //监听WebSocket消息事件
        $ws->on('message', function ($ws, $frame) {
            echo "Message: {$frame->data}\n";
            $users = Yii::$app->redis->get('fds');
            $users = json_decode($users,1);
            foreach ($users as $val){
                $ws->push($val,$frame->fd.':'.$frame->data);
            }
            //$ws->push($frame->fd, "server: {$frame->data}");
        });

        //监听WebSocket连接关闭事件
        $ws->on('close', function ($ws, $fd) {
            echo "client-{$fd} is closed\n";
        });
        $ws->start();
    }

    public function actionRedis()
    {

        //echo Yii::$app->redis->get('test');exit;
        exit;
    }
}
