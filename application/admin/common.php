<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 模块公共文件
//配置 memorycache 名称
//define("MEM_CACHE_NAME","afb33e1381504b4d.m.cnhzalicm10pub001.ocs.aliyuncs.com");
//配置 memorycache 名称
//define("MEM_CACHE_PWD","11211");

//配置 memorycache 名称
define("MEM_CACHE_NAME","127.0.0.1");
//配置 memorycache 名称
define("MEM_CACHE_PWD","11211");
//配置 memorycache 缓存时间 7*24*3600=604800
define("MEM_CACHE_TIME",604800);
//配置系统名
define("CHAOGE_SYS_NAME","recruit"); 
//

//生成token
function createToken($paramarr)
{
    //生成token
    $tokenPars = '';
    ksort($paramarr);
    foreach($paramarr as $k => $v)
    {
        if("" != $v)
        {
            $tokenPars .= $k . "=" . $v . "&";
        }
    }
    $nowtime = date("Y-m-d H:i:s",time());
    $tokenPars .= $nowtime;
    $tokenPars .= $paramarr["email"];
    $token = md5($tokenPars);
    $expiration = date("Y-m-d H:i:s",strtotime("+1 week",strtotime($nowtime)));
    $paramarr["token"] = $token;
    $paramarr["expiration"] = $expiration;
    return $paramarr;
}

//检查token是否存在、过期，若不存在或已过期，则重新从用户中心查询
function checktoken($token)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $userinfo = $cache->get(CHAOGE_SYS_NAME . $token);
    if(!$userinfo)//token不存在
    {
        return false;
    }
    else//token存在
    {
        $userinfo_arr = json_decode($userinfo,true);
        $nowtoken = $cache->get($userinfo_arr["email"] . CHAOGE_SYS_NAME . "uid-token");
        if($nowtoken == $token && strtotime($userinfo_arr["expiration"]) >= strtotime(date("Y-m-d H:i:s")))
        {
            return $userinfo_arr;
        }
        else
            return false;
    }
}

function updatetoken($token,$email,$userinfo)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $oldtoken = $cache->get($email . CHAOGE_SYS_NAME . "uid-token");
    if($cache->set($email . CHAOGE_SYS_NAME . "uid-token",$token,0,MEM_CACHE_TIME))
    {
        $cache->delete(CHAOGE_SYS_NAME . $oldtoken);
        if($cache->set(CHAOGE_SYS_NAME . $token,json_encode($userinfo),0,MEM_CACHE_TIME))
        {
            return true;
        }
        else
            return false;
    }
    else
    {
        return false;
    }
}

function updatetoken_test($token,$uid,$userinfo)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $oldtoken = $cache->get($uid . CHAOGE_SYS_NAME . "uid-token");
    if($cache->set($uid . CHAOGE_SYS_NAME . "uid-token",$token,0,MEM_CACHE_TIME))
    {
        $cache->delete(CHAOGE_SYS_NAME . $oldtoken);
        if($cache->set(CHAOGE_SYS_NAME . $token,json_encode($userinfo),0,MEM_CACHE_TIME))
        {
            return true;
        }
        else {
            echo '设置 '.CHAOGE_SYS_NAME . $token." token对应userinfo失败";
            return false;
        }
    }
    else
    {
        echo '设置 '.$uid . CHAOGE_SYS_NAME . "uid-token"." uid对应token失败";
        return false;
    }
}

function updatevalue($token,$key,$value)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $jsonstr = $cache->get(CHAOGE_SYS_NAME . $token);
    if($jsonstr)
    {
        $json_arr = json_decode($jsonstr,true);
        $json_arr[$key] = $value;
        if($cache->set(CHAOGE_SYS_NAME . $token,json_encode($json_arr),0,MEM_CACHE_TIME))
        {
            return true;
        }
        else
            return false;
    }
    else
    {
        return false;
    }
}

function updatevaluebyuid($uid,$key,$value)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $token = $cache->get($uid . CHAOGE_SYS_NAME . "uid-token");
    return updatevalue($token,$key,$value);
}

//清除缓存
function delkey($uid)
{
    $cache = new \Memcache;
    $cache->connect(MEM_CACHE_NAME, MEM_CACHE_PWD);
    $token = $cache->get($uid . CHAOGE_SYS_NAME . "uid-token");
    $ret = $cache->delete(CHAOGE_SYS_NAME . $token);
    return true;
}


function retmsg1($retcode,$retdata=null,$retmessage=null)
{
    switch($retcode)
    {
        case 0	: { $retmsg = "操作成功"; break; }
        case -1	: { $retmsg = "操作失败"; break; }
        case -2	: { $retmsg = "token验证失败"; break; }
        case -3	: { $retmsg = "短信验证码过期"; break; }
        case -4	: { $retmsg = "号码已被注册"; break; }
        case -5	: { $retmsg = "手机号格式不正确"; break; }
        case -6	: { $retmsg = "今日短信条数已使用完"; break; }
        case -7	: { $retmsg = "一分钟内只能获取一次短信"; break; }
        case -8	: { $retmsg = "验证码发送失败"; break; }
        case -9	: { $retmsg = "密码错误"; break; }
        case -10: { $retmsg = "手机号码不匹配"; break; }
        case -11: { $retmsg = "验证码错误"; break; }
        case -12: { $retmsg = "用户不存在或原密码错误或新旧密码一样"; break; }
        case -13: { $retmsg = "用户信息未做任何修改"; break; }
        case -14: { $retmsg = "密码不能为空"; break; }
        case -15: { $retmsg = "查询势力范围内的办事处失败(区县)"; break; }
        case -16: { $retmsg = "查询势力范围内的办事处失败(市)"; break; }
        case -17: { $retmsg = "查询势力范围内的办事处失败(省)"; break; }
        case -18: { $retmsg = "skey不能为空"; break; }
        case -19: { $retmsg = "该号码已被注册"; break; }
        case -20: { $retmsg = "图片内容不能为空"; break; }
        case -21: { $retmsg = "图片base64内容格式错误"; break; }
        case -22: { $retmsg = "建议内容不能为空"; break; }
        case -23: { $retmsg = "建议标题不能为空"; break; }
        case -24: { $retmsg = "建议类型不能为空"; break; }
        case -25: { $retmsg = "剩余开户次数不足"; break; }
        case -26: { $retmsg = "参数错误"; break; }
        case -27: { $retmsg = "未做修改"; break; }
        case -28: { $retmsg = "金额不能为空"; break; }
        default	: { $retmsg = "未知错误";}
    }
    return array("resultcode"=>$retcode,"resultmsg"=>empty($retmessage)?$retmsg:$retmessage,"data"=>$retdata);
}