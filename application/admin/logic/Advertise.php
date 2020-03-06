<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/16
 * Time: 16:43
 */

namespace app\admin\logic;


class Advertise
{
    public function getAdverurl()
    {
        $position = new \app\admin\model\Advertise();
        $ret = $position->getAdverurl();
        if ($ret) {
            return retmsg(0, $ret);
        } else {
            return retmsg(0);
        }
    }

    public function addAdvert($data)
    {
        if (empty($data)) {
            return retmsg(-1, '', '新增数据为空,请重新输入');
        }
        $advertM = new \app\admin\model\Advertise();
        $ret = $advertM->addAdvert($data);
        if ($ret) {
            return retmsg(0);
        } else {
            return retmsg(-1);
        }
    }

    public function deleteAdvert($id)
    {
        $advertM = new \app\admin\model\Advertise();
        $ret = $advertM->deleteAdvert($id);
        if ($ret) {
            return retmsg(0);
        } else {
            return retmsg(-1);
        }
    }

    public function updateAdvert($data)
    {
        $advertM = new \app\admin\model\Advertise();
        $ret = $advertM->updateAdvert($data);
        if ($ret) {
            return retmsg(0);
        } else {
            return retmsg(-1);
        }
    }

    public function getAdver($page,$pagesize){
        $position = new \app\admin\model\Advertise();
        $ret = $position->getAdver($page,$pagesize);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function delAdver($data){
        $where['id'] = $data['id'];
        $position = new \app\admin\model\Advertise();
        $ret = $position->delAdver($where);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }


    public function addAdver($data){
        $position = new \app\admin\model\Advertise();
        $data['create_time'] = date('Y-m-d H:i:s',time());
        $ret = $position->addAdver($data);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}