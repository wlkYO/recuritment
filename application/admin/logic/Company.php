<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 9:53
 */

namespace app\admin\logic;


class Company
{
    public function getCompanyList($companName, $registerAddr)
    {
        $where = '';
        if (!empty($companName)) {
            $where['company_name'] = ['like', "%$registerAddr%"];
        }
        if (!empty($registerAddr)) {
            $where['register_addr'] = ['like', "%$registerAddr%"];
        }
        $companyM = new \app\admin\model\Company();
        $res = $companyM->selectCompany($where);
        if (empty($res)) {
            return retmsg(-1, '', '查询数据为空');
        } else {
            return retmsg(0, $res, '查询成功');
        }
    }

    public function addCompany($data)
    {
        $companyM = new \app\admin\model\Company();
        $res = $companyM->addCompany($data);
        if (empty($res)) {
            return retmsg(-1);
        } else {
            return retmsg(0);
        }
    }

    public function updateCompany($data){
        $companyM = new \app\admin\model\Company();
        $res = $companyM->updateCompany($data);
        if (empty($res)) {
            return retmsg(-1);
        } else {
            return retmsg(0);
        }
    }

    public function deleteCompany($id){
        $companyM = new \app\admin\model\Company();
        $res = $companyM->deleteCompany($id);
        if (empty($res)) {
            return retmsg(-1);
        } else {
            return retmsg(0);
        }
    }
}