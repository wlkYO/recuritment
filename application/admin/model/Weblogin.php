<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/11
 * Time: 10:12
 */

namespace app\admin\model;


use think\Db;

class Weblogin
{
    public function login($where){
        $ret = Db::table('recruit_user')->where($where)->find();
        return $ret;
    }

    public function register($data){
        $ret = Db::table('recruit_user')->insert($data);
        return $ret;
    }

    public function iscunzai($where){
        $ret = Db::table('recruit_user')->where($where)->find();
        return $ret;
    }

    public function editpassword($where,$data){
        $ret = Db::table('recruit_user')->where($where)->update($data);
        return $ret;
    }
}