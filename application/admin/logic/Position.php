<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/10
 * Time: 16:26
 */

namespace app\admin\logic;


class Position
{
    public function addposition($postdata){

    }

    public function updateposition($postdata){

    }

    public function getjobType(){
        $position = new \app\admin\model\Position();
        $ret = $position->getjobType();
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function getposition($page,$pagesize){
        $position = new \app\admin\model\Position();
        $ret = $position->getposition($page,$pagesize);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function delposition($data){
        $where['id'] = $data['id'];
        $position = new \app\admin\model\Position();
        $ret = $position->delposition($where);
        if ($ret){
//            职位删除，将其投递和留言删除
            $whereDle['position_id'] = $data['id'];
            $position->delliuyan($whereDle);
            $position->deldelivery($whereDle);
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function getpositionType($page,$pagesize){
        $position = new \app\admin\model\Position();
        $ret = $position->getpositionType($page,$pagesize);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function editpositionType($data){
        $position = new \app\admin\model\Position();
//        修改大类
        $where['id'] = $data['id'];
        $updatebig['typename'] = $data['bigtype'];
        $position->editbig($where,$updatebig);
//        修改小类
        $ids = [];
        foreach ($data['children'] as $k=>$v){
            if (!empty($v['id'])){
                $ids[] = $v['id'];
                $wheresmall['id'] = $v['id'];
                $updatesmall['typename'] = $v['smalltype'];
                $position->editbig($wheresmall,$updatesmall);
            }else{
                $smalldata['pid'] = $data['id'];
                $smalldata['typename'] = $v['smalltype'];
                $smalldata['create_time'] = date('Y-m-d H:i:s',time());
                $ret = $position->addsmall($smalldata);
                $ids[] = $ret;
            }
        }
        $where1['pid'] = $data['id'];
        $position ->delsmall($where1,$ids);
        return retmsg(0);
    }

    public function delpositionType($data){
        $position = new \app\admin\model\Position();
        $ret = $position->delpositionType($data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }

    public function addpositionType($data){
        $position = new \app\admin\model\Position();
//        添加大类
        $addbig['pid'] = 0;
        $addbig['typename'] = $data['bigtype'];
        $addbig['create_time'] = date('Y-m-d H:i:s',time());
        $ret = $position->addbig($addbig);
//        修改小类
        foreach ($data['children'] as $k=>$v){
            $smalldata['pid'] = $ret;
            $smalldata['typename'] = $v['smalltype'];
            $smalldata['create_time'] = date('Y-m-d H:i:s',time());
            $position->addsmall($smalldata);
        }
        return retmsg(0);
    }
}