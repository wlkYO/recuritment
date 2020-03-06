<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/11
 * Time: 17:16
 */

namespace app\admin\logic;


class Liuyan
{
    public function getLiuyan($page,$pagesize){
        $position = new \app\admin\model\Liuyan();
        $ret = $position->getLiuyan($page,$pagesize);
        if ($ret){
            return retmsg(0,$ret);
        }else{
            return retmsg(0);
        }
    }

    public function delLiuyan($data){
        $where['id'] = $data['id'];
        $position = new \app\admin\model\Liuyan();
        $ret = $position->delLiuyan($where);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}