<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 16:23
 */

namespace app\admin\controller;
use app\admin\logic\Position;

class Positionc
{
    /**
     * 添加/修改人员
     * @param string $token
     * @return mixed
     */
    public function addposition($token = '')
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
//        $postData = json_decode(file_get_contents("php://input"), true);
        $postData = json_decode('{"id":1,"userid":"18382274650","username":"帅哥袁1","password":"123456","email":"1562656817@qq.com"}', true);
        $position = new Position();
        if (array_key_exists("id", $postData)){
            $ret = $position->updateposition($postData);
        }else{
            $ret = $position->addposition($postData);
        }
        return $ret;
    }

    /**
     * 删除人员，假删除
     * @param string $token
     * @return mixed
     */
    public function deluser($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        //        $postData = json_decode(file_get_contents("php://input"), true);
        $postData = json_decode('{"id":1}', true);
        $user = new User();
        $ret = $user->deluser($postData);
        return $ret;
    }

    /**
     * 查询人员
     * @param string $token
     * @return mixed
     */
    public function getuser($token='',$role='',$username='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $user = new User();
        $ret = $user->getuser($role,$username,$page,$pagesize);
        return $ret;
    }

    /**
     * 查询职位类别
     * @param string $token
     * @return mixed
     */

    public function getjobType($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $user = new Position();
        $ret = $user->getjobType();
        return $ret;
    }

    /**
     * 查询职位列表
     * @param string $token
     * @return mixed
     */
    public function getposition($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new Position();
        $ret = $user->getposition($page,$pagesize);
        return $ret;
    }

    public function delposition($token=''){
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
        $position = new Position();
        $ret = $position->delposition($postData);
        return $ret;
    }

    public function getpositionType($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $user = new Position();
        $ret = $user->getpositionType($page,$pagesize);
        return $ret;
    }

    public function editpositionType($token=''){
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
        $position = new Position();
        $ret = $position->editpositionType($postData);
        return $ret;
    }

    public function delpositionType($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"id":82}', true);
        $position = new Position();
        $ret = $position->delpositionType($postData);
        return $ret;
    }

    public function addpositionType($token=''){
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
        $position = new Position();
        $ret = $position->addpositionType($postData);
        return $ret;
    }
}