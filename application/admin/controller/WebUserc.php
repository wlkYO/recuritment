<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:47
 */

namespace app\admin\controller;


use app\admin\logic\WebUser;

class WebUserc
{
//    网站用户信息补全
    public function adddetail($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"company_name":"公司名称","register_addr":"公司地址","company_phone":"18888888888","company_introduce":"公司介绍","nickname":"亚亚奶糖","sex":"1","position":"招聘主管","mark":"帅的不明显系列的个性签名"}', true);
        $user = new WebUser();
        $ret = $user->adddetail($postData,$userInfo);
        return $ret;
    }

//    职位发布
    public function releasePosition($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"industry":"职位类别","address":"公司地址","name":"职位名称","experience":"3年","wages":"5000--6000","xueli":"本科","welfare":"福利待遇","position_detail":"职位描述"}', true);
        $user = new WebUser();
        $ret = $user->releasePosition($postData,$userInfo);
        return $ret;
    }

    public function getPosition($address='',$name='',$experience='',$wages='',$xueli='',$timetype='timeDown',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
//        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"industry":"职位类别","address":"公司地址","name":"职位名称","experience":"3年","wages":"5000--6000","xueli":"本科","welfare":"福利待遇","position_detail":"职位描述","company_datail":"公司介绍"}', true);
        $user = new WebUser();
        $where = [];
        if(!empty($name)){
            $where['a.name|a.industry|c.nickname'] = array('like',"%$name%");
        }
        if(!empty($address)){
            $where['a.address'] = array('like',"%$address%");
        }
        if(!empty($experience)){
            $where['a.experience'] = $experience;
        }
        if(!empty($wages)){
            $where['a.wages'] = $wages;
        }
        if(!empty($xueli)){
            $where['a.xueli'] = $xueli;
        }
        $ret = $user->getPosition($where,$page,$pagesize,$timetype,$name);
        return $ret;
    }

//    收藏职位
    public function collection($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
        $user = new WebUser();
        $ret = $user->collection($postData,$userInfo);
        return $ret;
    }

//    个人信息
    public function personalCenter($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->personalCenter($userInfo);
        return $ret;
    }

//    已发布职位
    public function personalPosition($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->personalPosition($userInfo,$page,$pagesize);
        return $ret;
    }

//    根据职位大类获取职位列表
    public function positionBigtype($id='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $user = new WebUser();
        $ret = $user->positionBigtype($id,$page,$pagesize);
        return $ret;
    }

//    职位详情
    public function positionDetail($id){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $user = new WebUser();
        $ret = $user->positionDetail($id);
        return $ret;
    }

//    求职者发布留言
    public function releaseLiuyan($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"position_id":1,"liuyancontent":"留言内容","company_id":1}', true);
        $user = new WebUser();
        $ret = $user->releaseLiuyan($postData,$userInfo);
        return $ret;
    }


//    招聘者查看求职者给自己的留言
    public function getLiuyan($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $user = new WebUser();
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $ret = $user->getLiuyan($userInfo,$page,$pagesize);
        return $ret;
    }

//    招聘者回复留言
    public function replyLiuyan($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"id":1,"reply_content":"回复内容"}', true);
        $user = new WebUser();
        $ret = $user->replyLiuyan($postData,$userInfo);
        return $ret;
    }

//    上传简历
    public function uploadResume($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"file_url":"文件url"}', true);
        $user = new WebUser();
        $ret = $user->uploadResume($postData,$userInfo);
        return $ret;
    }

//    求职者下载自己简历
    public function downloadResume($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->downloadResume($userInfo);
        return $ret;
    }
//    求职者查看我的收藏
    public function getCollection($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->getCollection($userInfo,$page,$pagesize);
        return $ret;
    }

//    投递简历
    public function delivery($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"position_id":2}', true);
        $user = new WebUser();
        $ret = $user->delivery($postData,$userInfo);
        return $ret;
    }

//    求职者查看我的投递
    public function getDelivery($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->getDelivery($userInfo,$page,$pagesize);
        return $ret;
    }

//    招聘者查看自己收到的简历
    public function getResume($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->getResume($userInfo,$page,$pagesize);
        return $ret;
    }

//    求职者查看自己的留言
    public function getQLiuyan($token='',$page=1,$pagesize=10){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $user = new WebUser();
        $ret = $user->getQLiuyan($userInfo,$page,$pagesize);
        return $ret;
    }

//    移出收藏/留言/投递
    public function delCollection($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"id":2,"type":"sc"}', true);
        $user = new WebUser();
        $ret = $user->delCollection($postData);
        return $ret;
    }

//    热门搜索
    public function getHotsearch(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $user = new WebUser();
        $ret = $user->getHotsearch();
        return $ret;
    }

//    招聘者移除发布的职位
    public function delPosition($token=''){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $userInfo = checktoken($token);
        if (!$userInfo) {
            return array("resultcode" => -2, "resultmsg" => "用户令牌失效，请重新登录", "data" => null);
        }
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"id":2,"type":"sc"}', true);
        $user = new WebUser();
        $ret = $user->delPosition($postData);
        return $ret;
    }

}