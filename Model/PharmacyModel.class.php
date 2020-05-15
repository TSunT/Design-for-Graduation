<?php

class PharmacyModel extends BaseModel{

    public function insertMedicine($arr){
        //构建"字段列表"和"值列表"字符串
        $fields='';
        $values='';
        foreach ($arr as $key=>$value)
        {
            $fields .="$key,";
            if ($key!='medicine_name'&&$key!='medicine_type')
            {
                $values .="$value,";
            }else{
                $values .="'$value',";
            }
        }
        //去除末尾'，'号
        $fields =rtrim($fields,',');
        $values = rtrim($values,',');
        //构建sql语句insert into table_patients (id,name) values ('01','孙韬')
        $sql= "insert into table_register ($fields) values ($values)";
        //执行sql语句并返回布尔值
        return $this->db->exec($sql);
    }

    public function queryMedicine($post){
        $sour = $post['query'];
        if ($post['query_source']!='medicine'){
            $sour = "'".$sour."'";
        }
        $sql = "select medicine_id , medicine_name , medicine_type , cost , rest from table_medicine where {$post['query_source']} = {$sour}";
        return $this->db->fetchAll($sql);
    }

    public function queryOneMedicine($id){
        $sql = "select medicine_id , medicine_name , medicine_type , cost , rest from table_medicine where medicine_id = {$id}";
        return $this->db->fetchOne($sql);
    }

    public function updateMedicine($arr){
        $sql = "update table_medicine set medicine_name = '{$arr['medicine_name']}' , medicine_type = '{$arr['medicine_type']}' , cost = {$arr['cost']} , rest = {$arr['rest']} 
where medicine_id = {$arr['medicine_id']}";
        return $this->db->exec($sql);
    }

    public function queryNottake($patient_id){
        $sql = "select table_prescription.patient_id , table_patients.patient_name ,table_prescription.medicine_id, table_prescription.creat_time,table_medicine.medicine_name ,number, table_medicine.rest
from table_prescription inner join table_patients on table_prescription.patient_id = table_patients.patient_id inner join table_medicine on table_prescription.medicine_id = table_medicine.medicine_id
where table_prescription.patient_id={$patient_id} and paid = true and take = false ";
        return $this->db->fetchAll($sql);
    }

    //更新药物表的库存(事务处理)
    public function updateAllMedicineRest($bill,$id,$time){
        $this->db->trans_begin();
        $this->updatePrescription($id,$time);
        foreach ($bill as $med_id => $num){
            $rest = $this->getOneMedicineRest($med_id);
            if ($rest-$num<0){
                $this->db->trans_rollback();
                return false;
            }else{
                if (!$this->updateOneMedicineRest($med_id,$rest-$num)){
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }
        $this->db->trans_commit();
        return true;
    }

    private function getOneMedicineRest($m_id){
        $sql = "select rest from table_medicine where medicine_id={$m_id} for update ";
        return $this->db->fetchOne($sql)['rest'];
    }

    private function updatePrescription($id,$time){
        $sql = "update table_prescription set take = true where patient_id = {$id} and creat_time = {$time}";
        $this->db->exec($sql);
    }

    private function updateOneMedicineRest($m_id,$num){
        $sql = "update table_medicine set rest = {$num} where medicine_id = {$m_id}";
        return $this->db->exec($sql);
    }
}
