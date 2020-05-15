<?php

class NoticeController extends BaseController{
    private $dep_id;

    public function index(){
        include "./View/Notice/Noticeindex.html";
    }

    public function showInfo(){
        if (isset($_POST['dep_id'])) {$this->dep_id=$_POST['dep_id'];}else{$this->dep_id=$_GET['dep_id'];}
        header("refresh:5;url=?con=Notice&ac=showInfo"."&dep_id=".$this->dep_id);
        $this->authentication();
        $modelObj=FactoryModel::getInstance('NoticeModel');
        $dep_name =$modelObj->getDepName($this->dep_id);
        $arrs1=$modelObj->showNotice($this->dep_id);
        $arrs2=$modelObj->showQueue($this->dep_id);
        include "./View/Notice/Noticedisplay.html";
    }
}
