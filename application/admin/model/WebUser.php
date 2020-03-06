<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/23
 * Time: 15:55
 */

namespace app\admin\model;


use think\Db;

class WebUser
{
    public function addcompany($data){
        $ret = Db::table('recruit_company')->insertGetId($data);
        return $ret;
    }

    public function adduser($data,$where){
        $ret = Db::table('recruit_user')->where($where)->update($data);
        return $ret;
    }

    public function isexit($where){
        $ret = Db::table('recruit_company')->where($where)->find();
        return $ret;
    }

    public function releasePosition($data,$userinfo){
        $company_id = Db::table('recruit_user')->where('email',$userinfo['email'])->where('state',1)->find();
        $data['company_id'] =$company_id['company_id'];
        $data['create_user'] = $company_id['nickname'];
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $ret = Db::table('recruit_position')->insert($data);
        return $ret;
    }
    public function updatePosition($where,$data){
        $ret = Db::table('recruit_position')->where($where)->update($data);
        return $ret;
    }

    public function getPosition($where,$page,$pagesize,$timetype){
        $ret =array();$count = 0;
        if($timetype=='timeUp'){
            $ret = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)
                ->order('a.create_time ASC')
                ->field('a.*,b.company_name,c.header_img,c.position,c.nickname,c.sex')
                ->page($page,$pagesize)
                ->select();
            $count = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)
                ->order('a.create_time ASC')
                ->count();
        }
        elseif($timetype=='timeDown'){
            $ret = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)
                ->order('a.create_time DESC')
                ->field('a.*,b.company_name,c.header_img,c.position,c.nickname,c.sex')
                ->page($page,$pagesize)
                ->select();
            $count = Db::table('recruit_position')->alias('a')
                ->join('recruit_company b','a.company_id=b.id','left')
                ->join('recruit_user c','c.company_id=a.company_id','left')
                ->where($where)
                ->order('a.create_time DESC')
                ->count();
        }
        return array("list"=>$ret,"count"=>$count);
    }

    public function collection($data){
        $ret = Db::table('recruit_collection')->insert($data);
        return $ret;
    }

    public function yishoucang($where){
        $ret = Db::table('recruit_collection')->where($where)->find();
        return $ret;
    }

    public function delcollection($id,$type){
        if($type=='sc'){
            $where['id'] = $id;
            $ret = Db::table('recruit_collection')->where($where)->delete();
        }elseif ($type=='td'){
            $where['id'] = $id;
            $ret = Db::table('recruit_delivery')->where($where)->delete();
        }elseif ($type=='ly'){
            $where['position_id'] = $id;
            $ret = Db::table('recruit_liuyan')->where($where)->delete();
        }
        return $ret;
    }

    public function personalCenter($email){
        $ret = Db::table('recruit_user')->alias('a')->join('recruit_company b','a.company_id=b.id','left')
            ->where('a.email',$email)
            ->field('a.username,a.email,a.nickname,a.mark,a.header_img,a.position,a.sex,b.company_name,b.register_addr,b.company_phone,b.company_introduce')->select();
        return $ret;
    }
    public function personalPosition($email,$page,$pagesize){
        $ret = Db::table('recruit_position')->alias('a')->join('recruit_user b','a.company_id=b.company_id','left')
            ->join('recruit_company c','a.company_id=c.id','left')
            ->where('b.email',$email)
            ->field('b.header_img,b.position,b.nickname,b.sex,c.company_name,a.*')->select();
        $count = count($ret);
        $ret = array_slice($ret,($page-1)*$pagesize,$pagesize);
        return array("count"=>$count,"list"=>$ret);
    }

    public function positionBigtype($id){
        if(!empty($id)){
            $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,a.* from recruit_position a LEFT JOIN recruit_user b on a.company_id=b.company_id 
                              LEFT JOIN recruit_company c on a.company_id=c.id where a.industry in (select typename from recruit_position_type where pid=$id)");
        }
        else{
            $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,a.* from recruit_position a LEFT JOIN recruit_user b on a.company_id=b.company_id LEFT JOIN recruit_company c on a.company_id=c.id");
        }
        return $ret;
    }

    public function editdetail($where,$company,$user){
        $ret = Db::table('recruit_user')->where($where)->update($user);
        if(!empty($company)){
            $ret = Db::table('recruit_company')->where($where)->update($company);
        }
        return  $ret;
    }

    public function positionDetail($id){
        $ret = Db::query("select b.header_img,b.position,b.nickname,b.sex,c.company_name,c.company_introduce,c.company_phone,a.* from recruit_position a 
                          LEFT JOIN recruit_user b on a.company_id=b.company_id LEFT JOIN recruit_company c on a.company_id=c.id where a.id=$id");
        return $ret;
    }

    public function releaseLiuyan($data){
        $ret = Db::table('recruit_liuyan')->insert($data);
        return $ret;
    }

    public function getLiuyan($email,$page,$pagesize){
        $ret = Db::query("SELECT
    b.id,
	c.nickname,
	c.header_img,
	c.sex,
	c.mark,
	b.create_time,
	b.liuyancontent
FROM
	recruit_user a,
	recruit_liuyan b,
	recruit_user c
WHERE
	a.company_id = b.company_id
AND a.email = '$email'
AND b.email = c.email
and b.reply_email is null
ORDER BY  b.create_time desc");
        $count = count($ret);
        $ret = array_slice($ret,($page-1)*$pagesize,$pagesize);
        return array("count"=>$count,"list"=>$ret);
    }

    public function replyLiuyan($data,$where){
        $ret = Db::table('recruit_liuyan')->where($where)->update($data);
        return $ret;
    }

    public function addLog($data){
        $ret = Db::table('recruit_log')->insert($data);
        return $ret;
    }

    public function uploadResume($data){
        $ret = Db::table('recruit_resume')->insert($data);
        return $ret;
    }

    public function downloadResume($where){
        $ret = Db::table('recruit_resume')->field('file_url')->where($where)->find();
        return $ret;
    }

    public function upload($where){
        $ret = Db::table('recruit_resume')->where($where)->find();
        return $ret;
    }

    public function updateurl($where,$update){
        $ret = Db::table('recruit_resume')->where($where)->update($update);
        return $ret;
    }

    public function getCollection($email,$page,$pagesize){
        $ret = Db::query("SELECT a.id,a.position_id,c.nickname,c.header_img,c.position,c.sex,b.name,b.wages,b.address,b.xueli,b.industry,b.experience FROM recruit_collection a,recruit_position b,recruit_user c where a.position_id=b.id and b.company_id=c.company_id and a.email='$email'");
        $count = count($ret);
        $ret = array_slice($ret,($page-1)*$pagesize,$pagesize);
        return array("count"=>$count,"list"=>$ret);
    }

    public function delivery($data){
        $ret =Db::table('recruit_delivery')->insert($data);
        return $ret;
    }

    public function getDelivery($email,$page,$pagesize){
        $ret = Db::query("select a.id,a.position_id,d.nickname,d.position,d.sex,d.header_img,b.name,b.wages,b.address,b.xueli,b.industry,b.experience,c.file_url from recruit_delivery a,recruit_position b,recruit_resume c,recruit_user d where a.position_id=b.id and a.resume_id=c.id and d.company_id=b.company_id and c.email='$email'");
        $count = count($ret);
        $ret = array_slice($ret,($page-1)*$pagesize,$pagesize);
        return array("count"=>$count,"list"=>$ret);
    }

    public function getResume($email,$page,$pagesize){
        $ret = Db::query("select d.id,b.name,b.wages,b.address,b.xueli,b.industry,b.experience,b.id position_id,c.file_url,e.nickname,e.header_img,e.sex from recruit_user a,recruit_position b,recruit_resume c,recruit_delivery d,recruit_user e where a.company_id=b.company_id and d.position_id=b.id and d.resume_id=c.id and c.email= e.email and a.email='$email'");
        $count = count($ret);
        $ret = array_slice($ret,($page-1)*$pagesize,$pagesize);
        return array("count"=>$count,"list"=>$ret);
    }

    public function deli($where){
        $ret = Db::table('recruit_delivery')->where($where)->find();
        return $ret;
    }

    public function getQLiuyan($email){
        $ret = Db::query("select a.*,b.email company_email from recruit_liuyan a LEFT JOIN recruit_user b on a.company_id=b.company_id where a.email='$email' ORDER BY a.create_time asc");
       return $ret;
    }

    public function getHotsearch(){
        $ret = Db::query("SELECT email name,count(*) cnt  FROM `recruit_log` where behavior='热门搜索' GROUP BY email ORDER BY cnt desc limit 8");
        return $ret;
    }

    public function delPosition($id,$type){
        if($type=='sc'){
            $where['id'] = $id;
            $where1['position_id'] = $id;
            $ret = Db::table('recruit_position')->where($where)->delete();
            Db::table('recruit_delivery')->where($where1)->delete();
            Db::table('recruit_liuyan')->where($where1)->delete();
        }elseif ($type=='ly'){
            $where['id'] = $id;
            $ret = Db::table('recruit_liuyan')->where($where)->delete();
        }elseif ($type=='td'){
            $where['id'] = $id;
            $ret = Db::table('recruit_delivery')->where($where)->delete();
        }
        return $ret;
    }
}