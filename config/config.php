<?php
/**
 * Created by PhpStorm.
 * User: Hanson
 * Date: 2017/8/16
 * Time: 10:01
 */

namespace hans;



class config extends \swoole_websocket_server{

    const SENDTOALL='SENDALL';

    const CLOSETOALLUSER='ALL';

    public function open(\Redis $redis,$frame){
        $name=$frame->get['name'];
        $redis->hMset($frame->fd,["name" => $name, "ip" => $frame->server['remote_addr']]);


        foreach($this->connections as $fd){
            $result[]=$redis->hGetAll($fd);
        }
        foreach($result as $key =>$users){
            if(count($users)>0){
                $user_list[$key]=$users;
            }
        }
        $user_info['user_list']=$user_list;
        $user_info['type']=0;
        $user_info['msg']=$name."进入了房间";
        $msg=json_encode($user_info);
        foreach($this->connections as $fd){
            $this->push($fd,$msg);
        }
    }
    public function send_message(\Redis $redis,$frame,$messgae_type=self::SENDTOALL){
        switch($messgae_type){
            case self::CLOSETOALLUSER:

                foreach($this->connections  as  $userid){
                    $user[]=$redis->hGetAll($userid);
                }
                $reslt['type']=1;
                $reslt['msg']=$frame.'离开了';
                foreach($user as $key =>$users){
                    if(count($users)>0){
                        $user_list[$key]=$users;
                    }
                }
                $reslt['user_list']=$user_list;
                var_dump($reslt);
                $msg=json_encode($reslt);
                foreach($this->connections as $fd){
                    $this->push($fd,$msg);
                }
            break;
            case self::SENDTOALL:
                $user_info=$redis->hGetAll($frame->fd);
                $send_msg = "{$user_info['name']}:{$frame->data}\n";
                $reslt['type']=2;
                $reslt['msg']=$send_msg;
                $msg=json_encode($reslt);
                var_dump($reslt);
                foreach($this->connections as $fd){
                    $this->push($fd,$msg);
                }
        }
    }

    public function user_close(\Redis $redis,$fd){

        echo $fd.'用户断开连接';
        $userinfo=$redis->hGetAll($fd);

        $redis->hDel($fd,'name','ip');

        $this->send_message($redis,$userinfo["name"],self::CLOSETOALLUSER);

        $redis->hDel($fd,'name','ip');

        $this->close($fd);
    }

}