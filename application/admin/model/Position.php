<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 16:26
 */

namespace app\admin\model;


use think\Db;

class Position
{
    public function getjobType(){
        $ret =Db::table('recruit_position_type')->where('pid',0)->field('id,typename')->select();
       foreach ($ret as $k=>&$v){
           $v['chldren'] = Db::table('recruit_position_type')->where('pid',$v['id'])->field('id,typename')->select();
       }
       return $ret;
    }

    public function getposition($page,$pagesize){
        $ret = Db::table('recruit_position')->alias('a')
            ->join('recruit_company c','a.company_id=c.id','left')
            ->field('c.company_name,a.*')
            ->page($page,$pagesize)->select();
        $count =  Db::table('recruit_position')->alias('a')
            ->join('recruit_company c','a.company_id=c.id','left')
            ->field('c.company_name,a.*')->count();
        $header = array(
            array("headerName"=>"职位名称","field"=>"name"),
            array("headerName"=>"公司名称","field"=>"company_name"),
            array("headerName"=>"公司地址","field"=>"address"),
            array("headerName"=>"详细地址","field"=>"address_detail"),
            array("headerName"=>"职业种类","field"=>"industry"),
            array("headerName"=>"学历要求","field"=>"xueli"),
            array("headerName"=>"经验年限","field"=>"experience"),
            array("headerName"=>"职位描述","field"=>"position_detail"),
            array("headerName"=>"福利待遇","field"=>"welfare"),
            array("headerName"=>"发布时间","field"=>"create_time"),
        );
        return array("header"=>$header,"count"=>$count,"list"=>$ret);
    }

    public function delposition($where){
        $ret = Db::table('recruit_position')->where($where)->delete();
        return $ret;
    }

    public function getpositionType($page,$pagesize){
        $ret =Db::table('recruit_position_type')->where('pid',0)->page($page,$pagesize)->field('id,typename bigtype')->select();
        $count = Db::table('recruit_position_type')->where('pid',0)->count();
        $header = array(
            array("headerName"=>"大类名称","field"=>"bigtype"),
            array("headerName"=>"小类名称","field"=>"smalltype"),
        );
        foreach ($ret as $k=>&$v){
            $v['chldren'] = Db::table('recruit_position_type')->where('pid',$v['id'])->field('id,typename smalltype')->select();
        }
        return array("header"=>$header,"count"=>$count,"list"=>$ret);
    }

    public function delliuyan($where){
        $ret = Db::table('recruit_liuyan')->where($where)->delete();
        return $ret;
    }

    public function deldelivery($where){
        $ret = Db::table('recruit_delivery')->where($where)->delete();
        return $ret;
    }

    public function editbig($where,$update){
        $ret = Db::table('recruit_position_type')->where($where)->update($update);
        return $ret;
    }

    public function addsmall($data){
        $ret = Db::table('recruit_position_type')->insertGetId($data);
        return $ret;
    }

    public function delsmall($where1,$ids){
        $ret = Db::table('recruit_position_type')->where($where1)->where('id','not in',$ids)->delete();
        return $ret;
    }

    public function delpositionType($data){
        $id = $data['id'];
        $ret = Db::table('recruit_position_type')->where('id',$id)->delete();
        Db::table('recruit_position_type')->where('pid',$id)->delete();
        return $ret;
    }

    public function addbig($data){
        $ret = Db::table('recruit_position_type')->insertGetId($data);
        return $ret;
    }
}