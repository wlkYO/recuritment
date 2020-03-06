<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:00
 */

namespace app\admin\controller;


use app\admin\logic\Resume;

class Resumec
{
    public function getResumeList($companyName = '', $position= '')  //查询
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->getResumeList($companyName, $position);
        return $result;
    }

    public function deleteResume($id){   //删除
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->deleteResume($id);
        return $result;
    }

    public function uploadResume1($companyId,$positionId){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Resume();
        $result = $companyLogic->uploadResume1($companyId,$positionId);
        return $result;
    }

    //    网站上传简历
    public function uploadResume($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $userInfo = checktoken($token);
//        if (!$userInfo) {
//            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
//        }
        $userInfo['name'] = "测试";
        $user = new Resume();
        $ret = $user->uploadResume($userInfo);
        return $ret;
    }

    public function getResume($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new Resume();
        $ret = $user->getResume($page,$pagesize);
        return $ret;
    }

    public function delResume($token=''){
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
        $position = new Resume();
        $ret = $position->delResume($postData);
        return $ret;
    }
}