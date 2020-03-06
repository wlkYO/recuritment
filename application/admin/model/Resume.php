<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:24
 */

namespace app\admin\model;


use think\Db;

class Resume
{
    private static $table = 'recurit_resume';

    public function selectResume($where)
    {
        $res = Db::query($where);
        return $res;
    }

    public function deleteResume($id)
    {
        $res = Db::table(self::$table)
            ->delete($id);
        return $res;
    }

    public function uploadResume($data)
    {
        $ret = Db::table('recruit_resume')->insert($data);
        return $ret;
    }

    public function selectResumeUrl($id)
    {
        $res = Db::table(self::$table)
            ->field('file_url')
            ->where('id', $id)
            ->select();
        return $res;
    }

    public function getResume($page,$pagesize){
        $ret = Db::table('recruit_resume')->alias('a')
            ->join('recruit_user c','a.email=c.email','left')
            ->field('c.nickname,a.*')->page($page,$pagesize)->select();
        $header = array(
            array("headerName"=>"简历链接","field"=>"file_url"),
            array("headerName"=>"上传者昵称","field"=>"nickname"),
            array("headerName"=>"上传者邮箱","field"=>"email"),
            array("headerName"=>"上传时间","field"=>"create_time"),
        );
        $count = Db::table('recruit_resume')->alias('a')
            ->join('recruit_user c','a.email=c.email','left')
            ->field('c.nickname,a.*')->count();
        return array("header"=>$header,"count"=>$count,"list"=>$ret);
    }

    public function delResume($where){
        $ret = Db::table('recruit_resume')->where($where)->delete();
        return $ret;
    }
}