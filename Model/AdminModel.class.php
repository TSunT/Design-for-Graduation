<?php

class AdminModel extends BaseModel
{
    public function fetchStaffAll()
    {
        //构建查询的sql语句
        $sql="select staff_id , staff_name , staff_title , staff_gender , staff_tel from table_staffs";
        //执行sql语句 返回二维数组
        return $this->db->fetchAll($sql,3);
    }

    public function fetchUserAll($table="table_user")
    {
        //构建查询的sql语句
        $sql="select staff_id , username , last_login_ip , feasible ,login_times from table_user";
        //执行sql语句 返回二维数组
        return $this->db->fetchAll($sql,3);
    }

    public function fetchStaffOne($id)
    {
        //构建查询的sql语句
        $sql="select * from table_staffs where staff_id='{$id}'";
        //执行sql语句 返回二维数组
        return $this->db->fetchAll($sql,3);
    }
    public function fetchUserOne($id)
    {
        //构建查询的sql语句
        $sql="select staff_id , username , role , login_times , feasible from table_user where staff_id='{$id}'";
        //执行sql语句 返回二维数组
        return $this->db->fetchAll($sql,3);
    }

    public function updateStaff($post){
        $sql="update table_staffs set staff_name='{$post['staff_name']}' ,staff_title='{$post['staff_title']}', staff_salary={$post['staff_salary']} , staff_dep={$post['staff_dep']}, staff_office='{$post['staff_office']}',staff_gender='{$post['staff_gender']}', staff_tel='{$post['staff_tel']}' where staff_id='{$post['staff_id']}' ";
        $sql2="update table_user set role={$post['staff_dep']} where staff_id='{$post['staff_id']}'";
        if($this->db->exec($sql)&&$this->db->exec($sql2))
        {
            return true;
        }else{
            return false;
        }
    }

    public function updateUser($post){
        $sql="update table_user set username='{$post['username']}' , role={$post['role']}, feasible={$post['feasible']} where staff_id='{$post['staff_id']}';";
        $sql2="update table_staffs set staff_dep={$post['role']} where staff_id='{$post['staff_id']}';";
        if($this->db->exec($sql)&&$this->db->exec($sql2))
        {
            return true;
        }else{
            return false;
        }

    }

    public function insertStaff($post){
        //判断改身份证是否已登记
        $sql="select sraff_id from table_staffs where staff_id = {$post['staff_id']}";
        if($this->db->rowCount($sql)==0)
        {
            $fields='';
            $values='';
            foreach ($post as $key=>$value)
            {
                $fields .="$key,";
                if($key!='staff_salary'&&$key!='staff_dep')
                {
                    $values .="'$value',";
                }else{
                    $values .="$value,";
                }
            }
            //去除末尾'，'号
            $fields =rtrim($fields,',');
            $values = rtrim($values,',');
            //构建sql语句insert into table_patients (id,name) values ('01','孙韬')
            $sql= "insert into table_staffs ($fields) values ($values)";
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

    public function insertUser($post){
        //判断改身份证是否已登记
        $sql="select sraff_id from table_user where staff_id = {$post['staff_id']}";
        if($this->db->rowCount($sql)==0)
        {
            //获取当天日期
            $post['register_date'] = date('Y-m-d');
            //设置初试密码并md5加密
            $post['user_pwd']=md5($post['staff_id']);
            //构建"字段列表"和"值列表"字符串
            $fields='';
            $values='';
            foreach ($post as $key=>$value)
            {
                $fields .="$key,";
                if($key!='role'&&$key!='feasible')
                {
                    $values .="'$value',";
                }else{
                    $values .="$value,";
                }
            }
            //去除末尾'，'号
            $fields =rtrim($fields,',');
            $values = rtrim($values,',');
            //构建sql语句insert into table_patients (id,name) values ('01','孙韬')
            $sql= "insert into table_user ($fields) values ($values)";
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
}
