<?php

class NoticeModel extends BaseModel{

    public function showQueue($dep_id){
        $sql = "select table_register.patient_id , table_patients.patient_name , table_register.register_time 
from table_register inner join table_patients on table_register.patient_id = table_patients.patient_id 
where table_register.dep_id = {$dep_id} and table_register.status = '未过号'
order by register_time asc
limit 0,10";//最多返回10条记录
        return $this->db->fetchAll($sql);
    }

    public function getDepName($dep_id){
        $sql = "select dep_name from table_dep where dep_id = {$dep_id}";
        return $this->db->fetchOne($sql)['dep_name'];
    }

    public function showNotice($dep_id){
        $sql = "select table_notice.patient_id , table_patients.patient_name , table_staffs.staff_office
from table_notice inner join table_patients on table_notice.patient_id = table_patients.patient_id inner join table_staffs on table_notice.doctor_id = table_staffs.staff_id
where table_notice.dep_id={$dep_id}";
        return $this->db->fetchAll($sql);
    }
}
