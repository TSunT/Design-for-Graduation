<?php
class PatientModel extends BaseModel
{
    //获取多行病人数据
    public function fetchAll()
    {
        //构建查询的sql语句
        $sql="select * from table_patients";
        //执行sql语句 返回二维数组
        return $this->db->fetchAll($sql,3);
    }

    //获取病人总数
    public function rowcount()
    {
        //构建查询的sql语句
        $sql="select * from table_patients";
        //执行sql语句 返回二维数组
        return $this->db->rowCount($sql);
    }

    //删除病人记录
    public function delete($id)
    {
        //构建sql语句
        $sql="delete from table_patients where patient_id={$id}";
        //执行sql语句并返回布尔值
        return $this->db->exec($sql);
    }

    //添加病人记录
    public  function  addPateint($post)
    {
        //判断改身份证是否已登记
        $sql="select patient_id from table_patients where patient_identity = {$post['patient_identity']}";
        if($this->db->rowCount($sql)==0)
        {
            //获取出生年份
            $post['patient_birthyear'] =  substr($post['patient_identity'],6,4);
            //获取当天日期
            $post['input_time'] = date('Y-m-d');
            //构建"字段列表"和"值列表"字符串
            $fields='';
            $values='';
            foreach ($post as $key=>$value)
            {
                $fields .="$key,";
                $values .="'$value',";
            }
            //去除末尾'，'号
            $fields =rtrim($fields,',');
            $values = rtrim($values,',');
            //构建sql语句insert into table_patients (id,name) values ('01','孙韬')
            $sql= "insert into table_patients ($fields) values ($values)";
            //执行sql语句并返回布尔值
            $res=$this->db->exec($sql);
            if($res){
                return "completed";
            }else{
                return "failed";
            }
        }else{
            return "sameidentity";
        }
    }

    //按病号查询单个病人记录
    public function fetchOne($id)
    {
        $sql="select * from table_patients where patient_id={$id}";
        return $this->db->fetchOne($sql);
    }

    //修改一条病人记录
    public function editOne($post)
    {
        $sql="update table_patients set patient_name='{$post['patient_name']}',patient_tel={$post['patient_tel']},patient_gender='{$post['patient_gender']}',allergy='{$post['allergy']}' where patient_id={$post['patient_id']}";
        return $this->db->exec($sql);
    }

    //按要求查询病人记录
    public function queryPatient($post,$target='*')
    {
        $sql="select {$target} from table_patients where {$post['query_source']}='{$post['query']}'";
        return $this->db->fetchAll($sql);
    }

    //查询当天登记的病人
    public function dailyadd()
    {
        $date=date('Y-m-d');
        $sql="select patient_id,patient_name from table_patients where input_time = '{$date}'";
        return $this->db->fetchAll($sql);
    }

    //挂号表的更新
    public function insertregister($post){
        //构建"字段列表"和"值列表"字符串
        $fields='';
        $values='';
        foreach ($post as $key=>$value)
        {
            $fields .="$key,";
            if ($key!='status')
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

    //查询未支付信息
    public function queryunpaid($patient_id){
        $sql = "select table_payment.patient_id , table_patients.patient_name , table_staffs.staff_name , total_cost,creat_time
 from table_payment inner join table_patients on table_payment.patient_id=table_patients.patient_id inner join table_staffs on table_payment.doctor_id = table_staffs.staff_id
 where table_payment.patient_id ={$patient_id} and paid = false";
        return $this->db->fetchAll($sql);
    }

    public function showspecificPay($patient_id,$creat_time){
        $sql = "select table_medicine.medicine_name , table_medicine.cost , table_prescription.number
        from table_prescription inner join table_medicine on table_prescription.medicine_id = table_medicine.medicine_id 
        where patient_id = {$patient_id} and creat_time={$creat_time}";
        $res=$this->db->fetchAll($sql);
        return $res;
    }

    public function getTotalCost($patient_id,$creat_time){
        $sql = "select total_cost from table_payment where patient_id = {$patient_id} and creat_time={$creat_time}";
        return $this->db->fetchOne($sql);
    }
    //更新支付信息
    public function updateCompletedPayment($patient_id,$creat_time){
        $this->db->trans_begin();
        $sql = "update table_payment set paid = true where patient_id={$patient_id} and creat_time={$creat_time}";
        if ($this->db->exec($sql)&&$this->updatePrescription($patient_id,$creat_time)){
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }

    }

    private function updatePrescription($patient_id,$creat_time){
        $sql = "update table_prescription set paid = true where patient_id={$patient_id} and creat_time={$creat_time}";
        return $this->db->exec($sql);
    }
}