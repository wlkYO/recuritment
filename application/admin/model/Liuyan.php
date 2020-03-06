<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/11
 * Time: 17:16
 */

namespace app\admin\model;


use think\Db;

class Liuyan
{
    public function getLiuyan($page,$pagesize){
        $ret = Db::table('recruit_liuyan')->alias('a')
            ->join('recruit_position b','a.position_id=b.id','left')
            ->join('recruit_user c','a.email=c.email','left')
            ->field('b.name,c.nickname,a.*')
            ->page($page,$pagesize)->select();
        $count =  Db::table('recruit_liuyan')->alias('a')
            ->join('recruit_user c','a.email=c.email','left')
            ->field('c.nickname,a.*')->count();
        $header = array(
            array("headerName"=>"留言者昵称","field"=>"nickname"),
            array("headerName"=>"留言者邮箱","field"=>"email"),
            array("headerName"=>"职位名称","field"=>"name"),
            array("headerName"=>"留言内容","field"=>"liuyancontent"),
            array("headerName"=>"留言时间","field"=>"create_time"),
        );
        return array("header"=>$header,"count"=>$count,"list"=>$ret);
    }

    public function delLiuyan($where){
        $ret = Db::table('recruit_liuyan')->where($where)->delete();
        return $ret;
    }
}