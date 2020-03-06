<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 10:38
 */

class Auth
{
    public function run()
    {
        //自动延期，订单变更同步，订单变更出入库同步省略token
        $ignore = array('amdin/table/autoSaturation',
           );
        //缓存任务 token
        if (request()->path() == 'api/schedule/dailyDayCache') {
            return;
        } elseif (!in_array(request()->path(), $ignore)) {
//            $this->verifyToken();
        }
    }
}