<?php

class PharmacyController extends BaseController{

    public function index(){
        $this->authentication();
        include "./View/Pharmacy/PharmacyIndex.html";
    }

    public function add(){
        $this->authentication();
        include "./View/Pharmacy/addMedicine.html";
    }

    public function insert(){
        $this->authentication();
        if(isset($_POST)){
            $modelObj = $this->getInstance('PharmacyModel');
            if ($modelObj->insertMedicine($_POST)) {
                $msg="<h2>药品添加成功</h2>";
                $this->jump('','?con=Pharmacy&ac=index');
                include "./View/tips/success.html";
                die();
            }else{
                $this->jump('药品添加失败','?con=Pharmacy&ac=index');die();
            }
        }else{
            $this->jump('未提交数据','?con=Pharmacy');die();
        }
    }

    public function seek(){
        $this->authentication();
        include "./View/Pharmacy/PharmacyQuery.html";
    }

    public function query(){
        $this->authentication();
        if(isset($_POST))
        {
            $modelObj = $this->getInstance('PharmacyModel');
            $arrs=$modelObj->queryMedicine($_POST);
            include "./View/Pharmacy/getQueryResult.html";
        }else{
            $this->jump('未提交数据','?con=Pharmacy');die();
        }

    }

    public function edit(){
        $this->authentication();
        if (isset($_GET['id']))
        {
            $modelObj = $this->getInstance('PharmacyModel');
            $arr = $modelObj->queryOneMedicine($_GET['id']);
            include "./View/Pharmacy/editMedicine.html";
        }else{
            $this->jump('未提交数据','?con=Pharmacy');die();
        }
    }

    public function update(){
        $this->authentication();
        if (isset($_POST))
        {
            $modelObj = $this->getInstance('PharmacyModel');
            if ($modelObj->updateMedicine($_POST)) {
                $msg="<h2>药品修改成功</h2>";
                $this->jump('','?con=Pharmacy&ac=index');
                include "./View/tips/success.html";
                die();
            }else{
                $this->jump("修改失败",'?con=Pharmacy');die();
            }
        }else{
            $this->jump('未提交数据','?con=Pharmacy');die();
        }
    }

    public function searchPatient(){
        $this->authentication();
        include "./View/Pharmacy/PaymentQuery.html";
    }

    public function queryPayment(){
        $this->authentication();
        $modelObj = $this->getInstance('PharmacyModel');
        if($arrs = $modelObj->queryNottake($_POST['query']))
        {
            include "./View/Pharmacy/getQueryPrescriptionResult.html";
        }else{
            $this->jump('该病人未有取药项目，请查看是否付款！','?con=Pharmacy');die();
        }

    }

    public function updatePrescriptionInfo(){
        if(!isset($_POST)){
            $this->jump('数据出错','?con=Pharmacy');die();
        }
        $this->authentication();
        $modelObj = $this->getInstance('PharmacyModel');
        if($modelObj->updateAllMedicineRest($_POST['bill'],$_POST['patient_id'],$_POST['creat_time'])){
            $msg="<h2>药品交付成功</h2>";
            $this->jump('','?con=Pharmacy&ac=index');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump('交付失败，请检查库存，再重试！','?con=Pharmacy');die();
        }
    }
}
