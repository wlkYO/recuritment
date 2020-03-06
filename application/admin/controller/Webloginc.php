<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/11
 * Time: 10:09
 */

namespace app\admin\controller;


use app\admin\logic\Weblogin;
use PHPMailer\PHPMailer\PHPMailer;
use think\Cache;
use think\Config;

class Webloginc
{
    /**
     * 网站登录
     */
    public function login(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"password":"123456","email":"1562656817@qq.com"}', true);
       $login = new Weblogin();
       $ret = $login->login($postData);
       return $ret;
    }


//    发送邮件进行验证
    public function sendmail(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $code = rand('100000','999999');        //六位随机数
        //收件人的邮箱
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"email":"1551848357@qq.com"}', true);
        $email = $postData['email'];
        $regex= '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
        $result = preg_match($regex,$email);
        if (!$result){
            return array("resultcode" => -1, "resultmsg" => "邮箱格式不正确！", "data" => null);
        }
        $type=$postData['type'];
//        验证邮箱是否已经被注册
        if($type==1){
            $where['email'] = $postData['email'];
            $where['state'] = 1;
            $login = new \app\admin\model\Weblogin();
            $isexit = $login->iscunzai($where);
            if ($isexit){
                return array("resultcode" => -1, "resultmsg" => "您所输入的邮箱已被注册！", "data" => null);
            }
        }else{
            $where['email'] = $postData['email'];
            $where['state'] = 1;
            $login = new \app\admin\model\Weblogin();
            $isexit = $login->iscunzai($where);
            if (!$isexit){
                return array("resultcode" => -1, "resultmsg" => "您所输入的邮箱尚未注册！", "data" => null);
            }
        }
        $toemail= $postData['email'];
        $to_name = Config::get('to_name');                  //设置收件人信息，如邮件格式说明中的收件人
        $title = Config::get('title');
        $content = "尊敬的用户，欢迎使用***招聘网站，您的验证码为：【{$code}】";

        $sendmail = Config::get('send_email');     //发件人邮箱
        $sendmailpswd = Config::get('send_mailpswd');              //客户端授权密码,而不是邮箱的登录密码，就是手机发送短信之后弹出来的一长串的密码
        $send_name = Config::get('send_name');                // 设置发件人信息，如邮件格式说明中的发件人，
        Vendor('PHPMailer.PHPMailer');       //调用类库,路径是基于vendor文件夹的
        Vendor('PHPMailer.Exception');
        Vendor('PHPMailer.SMTP');
        $mail =new PHPMailer();      //实例化mail类
        $mail->isSMTP();                        // 使用SMTP服务
        $mail->CharSet = "utf8";                // 编码格式为utf8，不设置编码的话，中文会出现乱码
        $mail->Host = "smtp.qq.com";           // 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;                 // 是否使用身份验证
        $mail->Username = $sendmail;            // 发件人地址
        $mail->Password = $sendmailpswd;        //客户端授权密码,而不是邮箱的登录密码！
        $mail->SMTPSecure = "ssl";              // 使用ssl协议方式
        $mail->Port = 465;                      //sina端口110或25） //qq  465 587
        $mail->setFrom($sendmail, $send_name);  // 设置发件人信息，如邮件格式说明中的发件人，
        $mail->addAddress($toemail, $to_name);  // 设置收件人信息，如邮件格式说明中的收件人，
        $mail->addReplyTo($sendmail, $send_name);// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
        $mail->Subject = $title;     // 邮件标题
        session("code",$code);
        $mail->Body = $content;                 // 邮件正文
        //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用
        if(!$mail->send()){
            return array("resultcode" => -1, "resultmsg" => "操作失败！", "data" => null);//返回数据格式自己定义的一个函数

        }else{
            Cache::set('key',$code,60);//存储缓存
            return array("resultcode" => 1, "resultmsg" => "发送成功！", "data" => null);
        }
    }

//    注册
    public function register(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"password":"123456","email":"1562656817@qq.com","Verification_code":"945123"}', true);
        $code = Cache::get('key');$code1 = $postData['Verification_code'];
        if (empty($code)){
            return array("resultcode" => -1, "resultmsg" => "验证码已过期，请在收到邮件一分钟之内输入", "data" => null);
        }
        if ($code!=$code1){
            return array("resultcode" => -1, "resultmsg" => "您所输入的验证码不正确！", "data" => null);
        }else{
            $login = new Weblogin();
            $ret = $login->register($postData);
            return $ret;
        }
    }

//    验证码验证
    public function yanzheng(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"Verification_code":"945123"}', true);
        $code = Cache::get('key');$code1 = $postData['Verification_code'];
        if (empty($code)){
            return array("resultcode" => -1, "resultmsg" => "验证码已过期，请在收到邮件一分钟之内输入", "data" => null);
        }
        if ($code!=$code1){
            return array("resultcode" => -1, "resultmsg" => "您所输入的验证码不正确！", "data" => null);
        }else{
            return array("resultcode" => 0, "resultmsg" => "操作成功！", "data" => null);
        }
    }

//    修改密码
    public function editpassword(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"email":"1562656817@qq.com","oldpassword":"945123","newpassword1":"123456","newpassword2"}', true);
        $login = new Weblogin();
        $ret = $login->editpassword($postData);
        return $ret;
    }

//    验证码登录
    public function yanzhengLogin(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $postData = json_decode(file_get_contents("php://input"), true);
//        $postData = json_decode('{"Verification_code":"123456","email":"1562656817@qq.com"}', true);
        $login = new Weblogin();
        $ret = $login->yanzhengLogin($postData);
        return $ret;
    }
}