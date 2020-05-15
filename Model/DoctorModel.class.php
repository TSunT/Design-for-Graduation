<?php

class DoctorModel extends BaseModel
{
    public function getRegisterNum($dep){
        $sql="select patient_id from table_register where dep_id={$dep} and status = '未过号'";
        return $this->db->rowCount($sql);
    }

    public function getProcessingNum($staff_id){
        $sql="select patient_id from table_treatment where doctor_id = '{$staff_id}' AND completed = false ";
        return $this->db->rowCount($sql);
    }

    public function getCompletedNum($staff_id){
        $sql = "select patient_id from table_treatment where doctor_id = '{$staff_id}' AND completed = true";
        return $this->db->rowCount($sql);
    }

    public function getOnePatientID($dep){
        $this->db->trans_begin();
        $sql="select patient_id from table_register where dep_id={$dep} and status = '未过号'";
        $num=$this->db->rowCount($sql);
        $sql = "select patient_id , register_time from table_register where dep_id = {$dep} and status ='未过号' order by register_time asc for update";
        $res = $this->db->fetchOne($sql);
        $sql = "update table_register set status = '叫号中' where patient_id = {$res['patient_id']} and register_time = {$res['register_time']}";
        if ($num&&$res&&$this->db->exec($sql))
        {
            $this->db->trans_commit();
            return $res;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

    public function getPatientRegInfo($patient_id){
        $sql = "select patient_name , patient_tel from table_patients where patient_id = {$patient_id}";
        return $this->db->fetchOne($sql);
    }

    public function insertTreatment($post){
        $sql = "insert into table_treatment (patient_id , doctor_id , add_time) values ({$post['patient_id']} , '{$post['doctor_id']}' , {$post['add_time']} )";
        return $this->db->exec($sql);
    }

    //修改挂号表中的状态信息
    public function updateRegister($patient_id){
        $sql = "update table_register set status = '已就诊' where patient_id = {$patient_id}";
        return $this->db->exec($sql);
    }

    public function getPatientInfo($patient_id){
        $sql = "select patient_name , patient_birthyear , patient_gender , patient_tel, allergy from table_patients where patient_id = {$patient_id}";
        return $this->db->fetchOne($sql);
    }

    public function getRegisterTime($patient_id,$dep){
        $sql = "select register_time from table_register where patient_id = {$patient_id} and dep_id = {$dep} and status = '已就诊' order by register_time desc ";
        return $this->db->fetchOne($sql);
    }
    //获取药物信息
    public function getMedicineInfo(){
        $sql = "select * from table_medicine";
        return $this->db->fetchAll($sql);
    }

    //添加一项处方
    public function insertOnePrescription($doctor_id,$patient_id,$time,$medicine_id,$medicine_Num){
        $sql = "insert into table_prescription values ('{$doctor_id}',{$patient_id},{$time},{$medicine_id},{$medicine_Num},false ,false )";
        return $this->db->exec($sql);
    }

    //添加支付信息
    public function insertPaymentInfo($doctor_id,$patient_id,$time,$total_price){
        $sql = "insert into table_payment values ({$patient_id},'{$doctor_id}','{$time}',{$total_price},false)";
        return $this->db->exec($sql);
    }

    //获得病史信息
    public function getDiagnoseHistory($patient_id){
        $sql = "select add_time , diagnose from table_treatment where patient_id = {$patient_id} order by add_time desc ";
        return $this->db->fetchAll($sql);
    }

    //获取就诊时间
    public function getTreatTime($patient_id){
        $sql="select add_time from table_treatment where patient_id ={$patient_id} and completed = false ";
        return $this->db->fetchOne($sql);
    }

    //修改信息
    public function updateTreatInfo($patient_id,$doctor_id,$add_time,$arr,$complete){
        $sql = "update table_treatment 
        set heart_rate={$arr['heart_rate']},blood_pressure={$arr['blood_preasure']},temperature={$arr['temperature']},patient_symptoms='{$arr['symptoms']}'
        ,present_illness='{$arr['present_illness']}',past_illness='{$arr['past_illness']}',diagnose='{$arr['diagnose']}',prescription='{$arr['medicinenames']}'
        ,completed={$complete} 
        where patient_id = {$patient_id} and doctor_id = '{$doctor_id}' and add_time = {$add_time}";
        return $this->db->exec($sql);
    }

    //获取一项病人就诊信息
    public function getTreatInfo($patient_id,$add_time){
        $sql = "select doctor_id , heart_rate , blood_pressure,temperature , patient_symptoms , present_illness , past_illness , diagnose,prescription,completed
        from table_treatment 
        where patient_id = {$patient_id} and add_time = {$add_time}";
        return $this->db->fetchOne($sql);
    }

    //获取医生信息
    public function getDoctorName($doctor_id){
        $sql = "select staff_name doctor_name from table_staffs where staff_id = '{$doctor_id}'";
        return $this->db->fetchOne($sql);
    }

    //获取正在就诊病人的信息
    public function getPatients($doctor_id,$completed='false'){
        $sql = "select table_treatment.patient_id , table_patients.patient_name, table_treatment.add_time , table_treatment.diagnose 
        from table_treatment inner join table_patients on table_treatment.patient_id = table_patients.patient_id
        where doctor_id='{$doctor_id}'and completed = {$completed}
        order by add_time desc ";
        return $this->db->fetchAll($sql);
    }

    //添加叫号信息
    public function insertNotice($doctor_id,$patient_id,$register_time,$dep_id){
        $sql = "insert into table_notice (patient_id, register_time, doctor_id, dep_id) values ({$patient_id},{$register_time},'{$doctor_id}',{$dep_id})";
        return $this->db->exec($sql);
    }

    //病人到场确认后删除叫号信息
    public function deleteNotice($patient_id,$register_time){
        $sql = "delete from table_notice where patient_id={$patient_id} and register_time={$register_time}";
        $this->db->exec($sql);
    }

    //添加完整就诊信息
    public function insertAllTreatmentInfo($doctor_id,$patient_id,$prescription,$medicinenum,$total_price,$add_time,$arr,$completed=true){
        $this->db->trans_begin();//开始事务
        //在处方表中添加开药信息
        foreach($prescription as $key => $medcine_id){
            $res=$this->insertOnePrescription($doctor_id,$patient_id,$add_time,$medcine_id,$medicinenum[$key]);
            if (!$res) break;
        }
        //更新就诊表
        $res2=$this->updateTreatInfo($patient_id,$doctor_id,$add_time,$arr,$completed);
        //在支付表中添加支付信息
        $res3=$this->insertPaymentInfo($doctor_id,$patient_id,$add_time,$total_price);

        if($res&&$res2&&$res3){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

    //过号
    public function pass($patient_id,$add_time){
        $sql = "update table_register set status = '已过号' where patient_id ={$patient_id} and register_time = {$add_time}";
        $this->db->exec($sql);
        $this->deleteNotice($patient_id,$add_time);
    }
}
