<?php

class AdminController extends BaseController
{
    private function checkID(){
        if($_SESSION['staff_dep']!=14){
            echo"<script>alert('您的账户不是管理员账户！');history.go(-1);</script>";
        }
    }
    //显示管理员首页员工基本表
    public function index()
    {
        $this->authentication();
        $this->checkID();
        $modelObj= FactoryModel::getInstance('AdminModel');
        $arrs=$modelObj->fetchStaffAll();
        $userarrs=$modelObj->fetchUserAll('table_user');
        include "./View/Admin/Adminindex.html";
    }

    //调出修改用户页
    public function edituser(){
        $this->authentication();
        $this->checkID();
        $modelObj=FactoryModel::getInstance('AdminModel');
        $arrs=$modelObj->fetchUserOne($_GET['id']);
        $arr=$arrs[0];
        include "./View/Admin/AdminEditUser.html";
    }
    //调出修改员工页
    public function editstaff(){
        $this->authentication();$this->checkID();
        $modeObj=FactoryModel::getInstance('AdminModel');
        $arrs=$modeObj->fetchStaffOne($_GET['id']);
        $arr=$arrs[0];
        include './View/Admin/AdminEditStaff.html';
    }
    //执行修改用户
    public function updateuser(){
        $this->authentication();$this->checkID();
        $modeObj=FactoryModel::getInstance('AdminModel');
        if($modeObj->updateUser($_POST))
        {
            $msg='修改成功';
            $this->jump('','?con=Admin');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump('修改失败','?con=Admin');die();
        }
    }
    //执行修改员工
    public function updatestaff(){
        $this->authentication();$this->checkID();
        $modeObj=FactoryModel::getInstance('AdminModel');
        if($modeObj->updateStaff($_POST))
        {

            $msg='修改成功';
            $this->jump('','?con=Admin');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump('修改失败','?con=Admin');die();
        }
    }

    public function adduser(){
        $this->authentication();$this->checkID();
        include "./View/Admin/AdminAddUser.html";
    }

    public function addstaff(){
        $this->authentication();$this->checkID();
        include "./View/Admin/AdminAddStaff.html";
    }

    public function insertuser(){
        $this->authentication();$this->checkID();
        $modelOdj=FactoryModel::getInstance('AdminModel');
        $res=$modelOdj->insertUser($_POST);
        switch ($res)
        {
            case "sameidentity" :
                {
                    ob_start();
                    $this->jump("<h2>用户添加失败，该工号已注册</h2>","?con=Admin&ac=index");
                    ob_end_flush();//输出所有内容到浏览器
                    die();
                }
            case "failed":
                {
                    ob_start();
                    $this->jump("<h2>用户添加失败,该工号未在员工表上找到</h2>","?con=Admin&ac=index");
                    ob_end_flush();
                    die();
                }
            default:
                {
                    $msg='用户添加成功';
                    $this->jump('','?con=Admin');
                    include "./View/tips/success.html";
                    die();
                }
        }
    }

    public function insertstaff(){
        $this->authentication();$this->checkID();
        $modelOdj=FactoryModel::getInstance('AdminModel');
        $res=$modelOdj->insertStaff($_POST);
        switch ($res)
        {
            case "sameidentity" :
                {
                    ob_start();
                    $this->jump("<h2>员工添加失败，该工号已登记</h2>","?con=Admin&ac=index");
                    ob_end_flush();//输出所有内容到浏览器
                    die();
                }
            case "failed":
                {
                    ob_start();
                    $this->jump("<h2>员工添加失败</h2>","?con=Admin&ac=index");
                    ob_end_flush();
                    die();
                }
            default:
                {
                    $msg='员工添加成功';
                    $this->jump('','?con=Admin');
                    include "./View/tips/success.html";
                    die();
                }
        }
    }

    public function seekuser(){
        echo 'seekuser';
        die();
    }

    public function seekstaff(){
        echo 'seekuser';
        die();
    }
    //重置用户密码
    public function resetpwd(){
        echo 'resetpwd';
        die();
    }
}