<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/5
 * Time: 14:50
 */

namespace app\admin\controller;

if (is_file('E:\wamp64\www\recuritment\application\extra\oss\autoload.php')) {
    require_once 'E:\wamp64\www\recuritment\application\extra\oss\autoload.php';
}
use OSS\OssClient;
use OSS\Core\OssException;

class Uploadc
{
    public function upload(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 获取原文件名
                $name = $info->getInfo()['name'];
                $savename = $info->getSaveName();
                // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
                $accessKeyId = "LTAI5LgIolzxrXmv";
                $accessKeySecret = "QzlLJ4ANhCDfUcvVvUJr76iP2eWHSd";
// Endpoint。
                $endpoint = "http://oss-cn-beijing.aliyuncs.com";
// 存储空间名称
                $bucket= "ywr";
// 文件名称
                $object = $name;
// 本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt
                $filePath = ROOT_PATH . 'public' . DS . 'uploads'.'/'.$savename;
                try{
                    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                    $res = $ossClient->uploadFile($bucket, $object, $filePath);
                } catch(OssException $e) {
                    printf(__FUNCTION__ . ": FAILED\n");
                    printf($e->getMessage() . "\n");
                    return;
                }
//                print(__FUNCTION__ . ": OK" . "\n");
//                return array("url"=>$res["info"]["url"]);
                return array("resultcode"=>1,"resultmsg"=>"上传成功","data"=>array("url"=>$res["info"]["url"]));
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}