<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/11
 * Time: 10:12
 */

namespace app\admin\logic;
use app\admin\model\Weblogin as WebloginModel;
use PHPMailer\PHPMailer\PHPMailer;
use think\Cache;
use think\Db;

class Weblogin
{
    public function login($data){
        $where["email"] = $data["email"];
        $where["password"] = md5($data["password"]);
        $where['state'] = 1;
        $login = new WebloginModel();
        $ret = $login->login($where);
//        如果账号和密码正确则生成token
        if($ret){
            $settoken["username"] = $ret["username"];
            $settoken["roleid"] = $ret["role"];
            $settoken["email"] = $ret["email"];
            $settoken["company_id"] = $ret["company_id"];
            $where1['email'] = $ret['email'];
            $resume = Db::table('recruit_resume')->where($where1)->find();
            if($resume){
                $re = 1;
            }else{
                $re = 0;
            }
            $token = createToken($settoken);
            updatetoken($token["token"],$settoken['email'],$token);
            $res = array("token"=>$token["token"],"role"=>$ret["role"],"username"=>$ret["username"],"company_id"=>$ret["company_id"],"header_img"=>$ret['header_img'],"nickname"=>$ret['nickname'],"sex"=>$ret['sex'],"is_upload"=>$re);
            return retmsg(0,$res,"操作成功");
        }else{
            return array("resultcode" => -1, "resultmsg" => "您所输入的账号或密码错误！", "data" => null);
        }
    }

    public function yanzhengLogin($postdata){
        $where["email"] = $postdata["email"];
        $where["state"] = 1;
        $login = new WebloginModel();
        $ret = $login->iscunzai($where);
        if(!$ret){
            return array("resultcode" => -1, "resultmsg" => "您所输入的邮箱尚未注册！", "data" => null);
        }
        $code = Cache::get('key');$code1 = $postdata['Verification_code'];
        if (empty($code)){
            return array("resultcode" => -1, "resultmsg" => "验证码已过期，请在收到邮件一分钟之内输入", "data" => null);
        }
        if ($code!=$code1){
            return array("resultcode" => -1, "resultmsg" => "您所输入的验证码不正确！", "data" => null);
        }else{
                Cache::clear();
                $settoken["username"] = $ret["username"];
                $settoken["roleid"] = $ret["role"];
                $settoken["email"] = $ret["email"];
                $settoken["company_id"] = $ret["company_id"];
                $token = createToken($settoken);
                updatetoken($token["token"],$settoken['email'],$token);
                $where1['email'] = $ret['email'];
                $resume = Db::table('recruit_resume')->where($where1)->find();
                if($resume){
                    $re = 1;
                }else{
                    $re = 0;
                }
                $res = array("token"=>$token["token"],"role"=>$ret["role"],"username"=>$ret["username"],"company_id"=>$ret["company_id"],"header_img"=>$ret['header_img'],"nickname"=>$ret['nickname'],"sex"=>$ret['sex'],"is_upload"=>$re);
                return retmsg(0,$res,"操作成功");
        }
    }

    public function register($postdata){
        $data['username'] = "用户".$postdata['email'];
        $data['password'] = md5($postdata['password']);
        $data['email'] = $postdata['email'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        if($postdata['isSon']==1){
            $data['role']=3;
        }elseif($postdata['isSon']==0){
            $data['role']=2;
        }
        $login = new WebloginModel();
        $ret = $login->register($data);
        if ($ret){
            Cache::clear();
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function editpassword($postdata){
        if($postdata['newpassword1']!=$postdata['newpassword2']){
            return array("resultcode" => -1, "resultmsg" => "旧密码和新密码不一致！", "data" => null);
        }
        $data['password'] = md5($postdata['newpassword1']);
        $where['email'] = $postdata['email'];
        $login = new WebloginModel();
        $ret = $login ->editpassword($where,$data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}