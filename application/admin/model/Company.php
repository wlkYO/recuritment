<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 9:53
 */

namespace app\admin\model;


use think\Db;

class Company
{
    public static $table = 'recurit_company';

    public function selectCompany($where)
    {
        $res = Db::table(self::$table)
            ->where($where)
            ->select();
        return $res;
    }

    public function addCompany($data)
    {
        $res = Db::table(self::$table)
            ->insert($data);
        return $res;
    }

    public function updateCompany($data)
    {
        $res = Db::table(self::$table)
            ->update($data);
        return $res;
    }

    public function deleteCompany($id)
    {
        $res = Db::table(self::$table)
            ->delete($id);
        return $res;
    }
}