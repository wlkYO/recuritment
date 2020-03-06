<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:43
 */

namespace app\admin\model;


use think\Db;

class Advertise
{
    private static $table = 'recruit_advertise';

    public function getAdverurl()
    {
        $ret = Db::table('recruit_advertise')->field('id,url')->select();
        return $ret;
    }

    public function addAdvert($data)
    {
        $ret = Db::table(self::$table)
            ->insert($data);
        return $ret;
    }

    public function deleteAdvert($id)
    {
        $ret = Db::table(self::$table)
            ->delete($id);
        return $ret;
    }

    public function updateAdvert($data)
    {
        $ret = Db::table(self::$table)
            ->update($data);
        return $ret;
    }

    public function getAdver($page,$pagesize){
        $ret = Db::table('recruit_advertise')
            ->field('id,url,create_time,"管理员" create_user,advert_adress address')
            ->page($page,$pagesize)->select();
        $count =  Db::table('recruit_advertise')
            ->field('url,create_tyime')->count();
        $header = array(
            array("headerName"=>"图片地址","field"=>"url"),
            array("headerName"=>"发布者","field"=>"create_user"),
            array("headerName"=>"发布时间","field"=>"create_time"),
            array("headerName"=>"广告地址","field"=>"address"),
        );
        return array("header"=>$header,"count"=>$count,"list"=>$ret);
    }

    public function delAdver($where){
        $ret = Db::table('recruit_advertise')->where($where)->delete();
        return $ret;
    }

    public function addAdver($data){
        $ret = Db::table('recruit_advertise')->insert($data);
        return $ret;
    }
}