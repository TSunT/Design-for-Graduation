<?php
class DoctorController extends BaseController
{
    private $staff_id;
    private $staff_name;
    private $staff_dep;


    /**
     * 在处方表中添加开药信息
     */
//    private function insertPrescript($doctor_id,$patient_id,$prescription,$medicinenum){
//        $modelObj=FactoryModel::getInstance('DoctorModel');
//        $time=time();
//        foreach($prescription as $key => $medcine_id){
//            $modelObj->insertOnePrescription($doctor_id,$patient_id,$time,$medcine_id,$medicinenum[$key]);
//        }
//    }

    /**
     * 更新就诊表
     */
    private function updateTreatment($doctor_id,$patient_id,$add_time,$arr,$completed=true){
        $modelObj = $this->getInstance('DoctorModel');
        return $modelObj->updateTreatInfo($patient_id,$doctor_id,$add_time,$arr,$completed);
    }

    /**
     * 在支付表中添加支付信息
     */
//    private function insertPayment($patient_id,$doctor_id,$total_price){
//        $modelObj=FactoryModel::getInstance('DoctorModel');
//        $time=date("Y-m-d H:i:s",time());
//        $modelObj->insertPaymentInfo($doctor_id,$patient_id,$time,$total_price);
//    }

    public function __construct()
    {
        $this->staff_dep=$_SESSION['staff_dep'];
        $this->staff_name=$_SESSION['username'];
        $this->staff_id=$_SESSION['staff_id'];
    }

    /**
     * 医生首页
     */
    public function index()
    {
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        $processing_num = $modelObj->getProcessingNum($this->staff_id);
        $completed_num = $modelObj->getCompletedNum($this->staff_id);
        $patient_id =null;
        $patient_name = null;
        include "./View/Doctor/Doctorindex.html";
    }

    /**
     * 叫号页面
     */
    public function callOnePatient(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        if($register_num==0) {
            $this->jump('暂无患者挂号，请等待','?con=Doctor');
            die();
        }
        $res=$modelObj->getOnePatientID($this->staff_dep);
        if(!$res){
            $this->jump('叫号失败,请重新叫号','?con=Doctor');
            die();
        }
        $patient_id=$res['patient_id'];
        $register_time=$res['register_time'];
        //添加至通知表
        $modelObj->insertNotice($this->staff_id,$patient_id,$register_time,$this->staff_dep);
        $arr['patient_id']=$patient_id;
        $patient_info = $modelObj->getPatientRegInfo($patient_id);
        $arr['patient_name'] = $patient_info['patient_name'];
        $arr['patient_tel'] = $patient_info['patient_tel'];
        $arr['doctor_id'] = $this->staff_id;
        $arr['register_time']=$register_time;
        include "./View/Doctor/DoctorCheckRegister.html";
    }

    /**
     * 信息加入就诊表
     */
    public function insertTreatment(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        if(!isset($_GET['patient_id'])){
            if(isset($_POST['patient_id'])){$post['patient_id']=$_POST['patient_id'];}else {$this->jump('操作失败,提交信息不完整','?con=Doctor');}
            if(isset($_POST['doctor_id'])){$post['doctor_id']=$_POST['doctor_id'];}else{$this->jump('操作失败，提交信息不完整','?con=Doctor');}
            if(isset($_POST['register_time'])){$register_time=$_POST['register_time'];}else{$this->jump('操作失败，提交信息不完整','?con=Doctor');}
            $post['add_time']=time();
            if ($modelObj->insertTreatment($post)){
                $modelObj->deleteNotice($post['patient_id'],$register_time);
                $modelObj->updateRegister($post['patient_id']);
                $this->Treatment($post);
            }else{
                $this->jump('确认失败','?con=Doctor');die();
            }
        }else{
            $post['patient_id']=$_GET['patient_id'];
            $post['doctor_id']=$this->staff_id;
            //获取就诊时间
            $post['add_time']=$modelObj->getTreatTime($_GET['patient_id'])['add_time'];
            $this->Treatment($post);
        }

    }

    /**
     * 显示病人的治疗页
     */
    private function Treatment($arr,$model=0){//model值0：表示填写模式，1：表示编辑模式
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        $patient_info = $modelObj->getPatientInfo($arr['patient_id']);
        $register_time = $modelObj->getRegisterTime($arr['patient_id'],$this->staff_dep);//获取挂号时间
        $arrs=$modelObj->getMedicineInfo();//获得药物信息
        $arrs2=$modelObj->getDiagnoseHistory($arr['patient_id']);//获得病史信息
        $arr['patient_name']=$patient_info['patient_name'];
        $arr['patient_tel']=$patient_info['patient_tel'];
        $arr['patient_age']= date("Y") - $patient_info['patient_birthyear'];
        $arr['patient_gender']=$patient_info['patient_gender'];
        $arr['allergy']=$patient_info['allergy'];
        $arr['register_time']=date( "Y-m-d H:i:s",$register_time['register_time']);
        if ($model==0){include "./View/Doctor/DoctorTreatmentView.html";die();}
        if ($model==1){
            $treatment_info=$modelObj->getTreatInfo($arr['patient_id'],$arr['add_time']);
            $arr['temperature']=$treatment_info['temperature'];
            $arr['blood_pressure']=$treatment_info['blood_pressure'];
            $arr['heart_rate'] = $treatment_info['heart_rate'];
            $arr['symptoms'] = $treatment_info['patient_symptoms'];
            $arr['present_illness'] = $treatment_info['present_illness'];
            $arr['past_illness'] = $treatment_info['past_illness'];
            $arr['diagnose']=$treatment_info['diagnose'];
            include "./View/Doctor/editTreatment.html";
        }
    }

    /**
     * 处理提交的治疗信息
     */
    public function postTreatmentInfo(){
        $this->authentication();
        $arr['heart_rate']=$_POST['heartrate'];
        $arr['blood_preasure']=$_POST['bloodpressure'];
        $arr['temperature']=$_POST['temperature'];
        $arr['symptoms']=$_POST['symptoms'];
        $arr['present_illness']=$_POST['present_illness'];
        $arr['past_illness']=$_POST['past_illness'];
        $arr['diagnose']=$_POST['diagnose'];
        if ($_POST['action']=='提交' && $_POST['isprescription']=='true') {      //提交了含有处方的诊断
            $medicinenames = implode(",",$_POST['medicinename']);//将药的数组转换成字符串
            $arr['medicinenames']=$medicinenames;
            //添加支付信息
            //计算总价格
            $total_price=0;
            foreach ($_POST['consume'] as $key => $single){
                $total_price+=$single*$_POST['medicinenum'][$key];
            }

            $modelObj = $this->getInstance('DoctorModel');

            //调用一个使用事务来运行的方法
            $res=$modelObj->insertAllTreatmentInfo($this->staff_id,$_POST['patient_id'],$_POST['prescription'],$_POST['medicinenum'],$total_price,$_POST['add_time'],$arr);

            if($res){
                $msg='提交成功';
                $this->jump('','?con=Doctor');
                include "./View/tips/success.html";
                die();
            }else{
                $this->jump('提交失败，请重新提交','?con=Doctor');
                die();
            }
            //添加处方表
            //$this->insertPrescript($this->staff_id,$_POST['patient_id'],$_POST['prescription'],$_POST['medicinenum']);
            //调入添加支付信息方法
            //$this->insertPayment($_POST['patient_id'],$this->staff_id,$total_price);
            //更新就诊信息
            //$this->updateTreatment($_POST['doctor_id'],$_POST['patient_id'],$_POST['add_time'],$arr);

        }elseif ($_POST['action']=='提交'&& $_POST['isprescription']=='false'){ //提交未开处方的诊断
            //更新就诊信息
            $arr['medicinenames']='未开处方';
            $this->updateTreatment($_POST['doctor_id'],$_POST['patient_id'],$_POST['add_time'],$arr);
            $msg='提交成功';
            $this->jump('','?con=Doctor');
            include "./View/tips/success.html";
            die();
        } elseif ( $_POST['action']=='保存' ) {    //保存当前诊断
            //更新就诊信息
            $arr['medicinenames']='';
            $this->updateTreatment($_POST['doctor_id'],$_POST['patient_id'],$_POST['add_time'],$arr,'false');
            $msg='保存成功';
            $this->jump('','?con=Doctor');
            include "./View/tips/success.html";
            die();
        }else{
            $this->jump("处方信息未提交","?con=Doctor&ac=insertTreatment&patient_id=".$_POST['patient_id']);
            die();
        }
    }

    /**
     * 查看病人的看病记录
     */
    public function showPatientTreament(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        if(isset($_GET['patient_id'])&&isset($_GET['add_time'])){
            $arr1 = $modelObj->getPatientInfo($_GET['patient_id']);
            $arr1['patient_age']=date("Y",$_GET['add_time'])-$arr1['patient_birthyear'];
            $arr2 = $modelObj->getTreatInfo($_GET['patient_id'],$_GET['add_time']);
            $arr2['add_time']=$_GET['add_time'];
            $arr3 = $modelObj->getDoctorName($arr2['doctor_id']);
            include "./View/Doctor/DoctorShowOnePatient.html";
        }
    }

    /**
     * 查看就诊病人列表（按医生）
     */
    public function showPatientList(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        if($modelObj->getProcessingNum($this->staff_id)==0) {
            $this->jump('暂无患者就诊，请叫号或者等待','?con=Doctor');
            die();
        }
        $arrs=$modelObj->getPatients($this->staff_id);
        include "./View/Doctor/showPatientstreatingList.html";
    }

    /**
     * 编辑未结束就诊的病人信息
     */
    public function editTreatment(){
        $this->authentication();
        $arr['patient_id']=$_GET['patient_id'];
        $arr['add_time']=$_GET['add_time'];
        $arr['doctor_id']=$this->staff_id;
        $this->Treatment($arr,1);
    }

    /**
     * 查看已完成的病人列表（按医生）
     */
    public function showCompletedList(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $register_num=$modelObj->getRegisterNum($this->staff_dep);
        $arrs=$modelObj->getPatients($this->staff_id,'true');
        include "./View/Doctor/showPatientscompletedList.html";
    }


    /**
     * 过号处理
     */
    public function passOnePatient(){
        $this->authentication();
        $modelObj = $this->getInstance('DoctorModel');
        $modelObj->pass($_GET['id'],$_GET['time']);
        $this->jump('','?con=Doctor',0);
        die();
    }

}

