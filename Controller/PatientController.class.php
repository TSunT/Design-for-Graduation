<?php
class PatientController extends BaseController
{
    public function index()
    {
        $this->authentication();
        //创建学对象生模型类
        //$modelObj= FactoryModel::getInstance('PatientModel') ;
        //获取多行数据,并求出记录数
        //$arrs = $modelObj->fetchAll();
        //包含学生首页视图文件
        include "./View/Patient/PatientindexView.html";
    }

    public function delete()
    {
        $this->authentication();
        $modelObj = $this->getInstance('PatientModel');
        $id= $_GET['id'];
        if($modelObj->delete($id))
        {
            $msg="<h2>id={$id}的记录删除成功</h2>";
            $this->jump('','?con=Patient&ac=index');
            include "./View/tips/success.html";
            die();
        }else {
            ob_start();
            $this->jump("<h2>id={$id}的记录删除失败</h2>","?con=Patient&ac=index");
            ob_end_flush();
            die();
        }
    }

    public function add()
    {
        $this->authentication();
        //包含添加病人视图
        include "./View/Patient/addPatientView.html";
    }

    public function insert()
    {
        $this->authentication();
        $post = isset($_POST) ? $_POST:'';
        //创建学对象生模型类
        $modelObj = $this->getInstance('PatientModel');
        $res = $modelObj->addPateint($post);
        switch ($res)
        {
            case "sameidentity" :
                {
                    ob_start();
                    $this->jump("<h2>记录添加失败，该身份证已被登记</h2>","?con=Patient&ac=index");
                    ob_end_flush();//输出所有内容到浏览器
                    die();
                }
            case "failed":
                {
                    ob_start();
                    $this->jump("<h2>记录添加失败</h2>","?con=Patient&ac=index");
                    ob_end_flush();
                    die();
                }
            default:
                {
                    $msg="<h2>记录添加成功</h2>";
                    $this->jump('','?con=Patient&ac=index');
                    include "./View/tips/success.html";
                    die();

                }
        }
    }

    public function edit()
    {
        $this->authentication();
        //创建学对象生模型类
        $modelObj = $this->getInstance('PatientModel');
        //包含添加病人视图
        $arr=$modelObj->fetchOne($_GET['id']);
        include "./View/Patient/editPatientView.html";
    }

    public function update()
    {
        $this->authentication();
        $post = isset($_POST) ? $_POST:'';
        $modelObj = $this->getInstance('PatientModel');
        if ($modelObj->editOne($post))
        {
            $msg="<h2>记录修改成功</h2>";
            $this->jump('','?con=Patient&ac=index');
            include "./View/tips/success.html";
            die();
        }else{
            ob_start();
            $this->jump("<h2>记录添加失败</h2>","?con=Patient&ac=index");
            ob_end_flush();die();
        }
    }

    public function seek()
    {
        $this->authentication();
        include "./View/Patient/PatientqueryView.html";
    }

    public function query()
    {
        $this->authentication();
        $post = isset($_POST) ? $_POST:'';
        //创建学对象生模型类
        $modelObj = $this->getInstance('PatientModel');
        if($arrs=$modelObj->queryPatient($post))
        {
            include "./View/Patient/getPatientresultView.html";
        }else{
            ob_start();
            $this->jump("<h2>该病人未登记</h2>","?con=Patient&ac=index");
            ob_end_flush();die();
        }
    }

    public function dailyadd()
    {
        $this->authentication();
        $modelObj = $this->getInstance('PatientModel');
        $arrs =$modelObj->dailyadd();
        include "./View/Patient/PatientdailyaddView.html";
    }

    //挂号界面
    public function register()
    {
        $this->authentication();
        include "./View/Patient/showRegisterView.html";
    }
    //更新挂号表
    public function insertregister()
    {
        $this->authentication();
        $post['patient_id']=$_POST['patient_id'];
        $post['dep_id']=$_POST['dep_id'];
        $post['register_time']=time();
        $post['status']='未过号';
        $modelObj = $this->getInstance('PatientModel');
        if($modelObj->insertregister($post))
        {
            $msg="<h2>挂号成功</h2>";
            $this->jump('','?con=Patient&ac=index');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump('挂号失败','?con=Patient');die();
        }

    }

    //查询支付信息
    public function SearchPay(){
        $this->authentication();
        if(!isset($_GET['id'])){
            $this->jump("信息不完整",'?con=Patient');die();
        }
        $modelObj = $this->getInstance('PatientModel');
        if($arrs = $modelObj->queryunpaid($_GET['id'])){
            include "./View/Patient/getPatientpayresultView.html";
        }else{
            $this->jump("该账户没有未支付项目",'?con=Patient');die();
        }
    }

    //显示详细支付信息
    public function payinfo(){
        $this->authentication();
        if(!isset($_GET['id'])){
            $this->jump("信息不完整",'?con=Patient');die();
        }
        if(!isset($_GET['time'])){
            $this->jump("信息不完整",'?con=Patient');die();
        }
        $modelObj = $this->getInstance('PatientModel');
        $arrs1=$modelObj->showspecificPay($_GET['id'],$_GET['time']);
        $arrs2=$modelObj->getTotalCost($_GET['id'],$_GET['time']);
        $arrs2['patient_id']=$_GET['id'];
        $arrs2['time']=$_GET['time'];
        include './View/Patient/showSpecificPayment.html';
    }

    //完成支付的处理
    public function completePayment(){
        $this->authentication();
        if(!isset($_POST['patient_id'])){
            $this->jump("信息不完整",'?con=Patient');die();
        }
        if(!isset($_POST['creat_time'])){
            $this->jump("信息不完整",'?con=Patient');die();
        }
        $modelObj = $this->getInstance('PatientModel');
        if($modelObj->updateCompletedPayment($_POST['patient_id'],$_POST['creat_time'])){
            $msg="<h2>支付成功</h2>";
            $this->jump('','?con=Patient&ac=index');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump('支付失败','?con=Patient&ac=index');die();
        }
    }
    //查看挂号信息
    public function showregistion(){

    }
}


