<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 9:46
 */

namespace app\admin\controller;


use app\admin\logic\Company;

class Companyc
{
    public function getCompanyList($companName = '', $registerAddr = '')
    {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Company();
        $result = $companyLogic->getCompanyList($companName, $registerAddr);

        return $result;
    }

    public function addCompany(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Company();
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $companyLogic->addCompaby($data);
        return $result;
    }
    public function updateCompany(){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Company();
        $data = json_decode(file_get_contents("php://input"),true);
        $result = $companyLogic->updateCompany($data);
        return $result;
    }
    public function deleteCompany($id){
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
        header('Access-Control-Allow-Credentials: true');
        $companyLogic = new Company();
        $result = $companyLogic->updateCompany($id);
        return $result;
    }
}