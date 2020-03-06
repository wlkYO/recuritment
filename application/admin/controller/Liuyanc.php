<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/11
 * Time: 17:15
 */

namespace app\admin\controller;


use app\admin\logic\Liuyan;

class Liuyanc
{
    public function getLiuyan($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new Liuyan();
        $ret = $user->getLiuyan($page,$pagesize);
        return $ret;
    }

    public function delLiuyan($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"id":1}', true);
        $position = new Liuyan();
        $ret = $position->delLiuyan($postData);
        return $ret;
    }
}