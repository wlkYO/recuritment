<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 14:56
 */

namespace app\admin\model;


use think\Db;

class User
{
    public function adduser($data){
        $ret = Db::table('recruit_user')->insert($data);
        return $ret;
    }

    public function updateuser($where,$postdata){
        $ret = Db::table('recruit_user')->where($where)->update($postdata);
        return $ret;
    }

    public function getuser($where,$page,$pagesize){
        $ret = Db::table('recruit_user')->alias('a')->join('recruit_role b','a.role=b.id','LEFT')
            ->where($where)->field('a.id,email,nickname,sex,a.role roleid,header_img,position,a.create_time,b.role_name rolename')
            ->page($page,$pagesize)
            ->order('a.create_time Desc')
            ->select();
        $count = Db::table('recruit_user')->alias('a')->join('recruit_role b','a.role=b.id','LEFT')
            ->where($where)->field('a.id,email,nickname,sex,a.role roleid,header_img,position,a.create_time,b.role_name rolename')
            ->count();
        $role = Db::table('recruit_role')->where('state',1)->field('id,role_name')->select();
        return array("list"=>$ret,"count"=>$count,"role"=>$role);
    }
}