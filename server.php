<?php
/**
 * Created by PhpStorm.
 * User: Hanson
 * Date: 2017/8/16
 * Time: 10:09
 */

require_once '/www/web/o11o/public_html/chat/config/config.php';
$ws =  new  hans\config('0.0.0.0',9503);

$ws->set(array(
    'daemonize' => false,      // 是否是守护进程
    'max_request' => 10000,    // 最大连接数量
    'dispatch_mode' => 2,
    'debug_mode'=> 1,
    // 心跳检测的设置，自动踢掉掉线的fd
    'heartbeat_check_interval' => 5,
    'heartbeat_idle_time' => 600,
));
$redis = null;
$ws->on('WorkerStart', function ($ws, $worker_id) {
    global $redis;
    $redis = new \Redis();
    $redis->connect("127.0.0.1", 6379) || die("redis 连接失败");
    echo "进程{$worker_id}的redis 连接成功!\n";
});

$ws->on('open', function ($ws, $request) {
    global $redis;
    $ws->open($redis,$request);
});

$ws->on('message', function ($ws, $frame) {
    global $redis;
    $ws->send_message($redis, $frame);
});
$ws->on('close',function($ws,$fd){
    global $redis;
    $ws->user_close($redis,$fd);
});

$ws->start();