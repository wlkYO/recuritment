<?php
/**
 * Created by PhpStorm.
 * User: 000
 * Date: 2019/12/16
 * Time: 14:24
 */

namespace app\admin\logic;


class Resume
{
    public function getResumeList($companyName, $position)
    {
        $where = "select b.company_name company_name,c.title position_title,a.title resume_title,a.id,a.delivery_time                     from recurit_resume a 
                  left join recurit_company b on a.company_id = b.id
                  left join recurit_position c on a.position_id = c.id ";
        if (!empty($companyName)) {
            $where .= " where b.company like '%$companyName%' ";
        }
        if (!empty($registerAddr)) {
            $where .= empty($companyName) ? " where c.title like '%$position%' " : " and c.title like '%$position%' ";
        }
        $where .= ' order by company_name,position_title,delivery_time';
        $companyM = new \app\admin\model\Resume();
        $res = $companyM->selectResume($where);
        if (empty($res)) {
            return retmsg(-1, '', '查询数据为空');
        } else {
            return retmsg(0, $res, '查询成功');
        }
    }

    public function uploadResume1($companyId, $positionId)
    {
        set_time_limit(0);
//        vendor("PHPExcel.Classes.PHPExcel");
        $file = $_FILES['file'] ['name'];
        $filetempname = $_FILES ['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        if ($file_size > 5 * 1024 * 1024) {
            return retmsg(-1, '', '上传文件过大,请上传小于5M的文件');
        }
        $filePath = str_replace('\\', '/', realpath(__DIR__ . '/../../../')) . '/upload/';
        $filePath .= '/' . $companyId;
        if (!is_dir($filePath)) {
            mkdir($filePath);
        }
        $filename = explode(".", $file);
        $time = date("YmdHis");
        $filename [0] = $time;//取文件名t替换
        $name = implode(".", $filename); //上传后的文件名
        $uploadfile = $filePath . $name;
        $result = move_uploaded_file($filetempname, $uploadfile);
        if ($result) {
            $extension = substr(strrchr($file, '.'), 1);
            if ($extension != '' && $extension != 'xls' && $extension != 'csv') {
                $this->response(retmsg(-1, null, '请上传Excel或csv文件！'), 'json');
            }
        }
    }

    public function deleteResume($id)
    {
        $companyM = new \app\admin\model\Resume();
        $res = $companyM->deleteResume($id);
        if (empty($res)) {
            return retmsg(-1);
        } else {
            for ($i = 0; $i < count($id); $i++) {
                $url = $res->selectResumeUrl($id[$i]);
                unlink($url);//删除临时文件
            }
            return retmsg(0);
        }
    }

    public function upload($userInfo)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
//        支持格式以及文件大小限制
//        $res = $file->validate(['size'=>155678,'ext'=>'jpg,png']);
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            // 成功上传后 获取上传信息
            $baseurl = "localhost:8888/recruitment/public/uploads/";
            $data['email'] = $userInfo['email'];
            $url = $baseurl . $info->getSaveName();
            $data['file_url'] = $url;
            $resume = new \app\admin\model\Resume();
            $resume->uploadResume($data);
            return retmsg(0);
        } else {
            return retmsg(-1);
        }
    }

    public function uploadResume($userInfo)
    {
        $ret = $this->upload($userInfo);
        return $ret;
    }

    public function getResume($page,$pagesize){
        $model = new \app\admin\model\Resume();
        $ret =$model->getResume($page,$pagesize);
        if ($ret) {
            return retmsg(0,$ret);
        } else {
            return retmsg(0);
        }
    }

    public function delResume($data){
        $where['id'] = $data['id'];
        $position = new \app\admin\model\Resume();
        $ret = $position->delResume($where);
        if ($ret){
            return retmsg(0);
        }else{
            return retmsg(-1);
        }
    }
}