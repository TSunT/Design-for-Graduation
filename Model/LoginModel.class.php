<?php
class LoginModel extends BaseModel
{
    //检测输入信息与数据库的对比情况，若成功返回用户名，密码错误返回'failed-password'，用户为登陆返回'non-exist'
    public function loginCheck($staff_id,$password)
    {
        $sql="select staff_id, user_pwd as password , feasible , username ,login_times ,role from table_user where staff_id='{$staff_id}'";
        $res=$this->db->fetchOne($sql);
        if ($res)
        {
            if ($res['password']==$password)
            {
                if ($res['feasible']==1) {
                    $arr=array(
                        'username' => $res['username'],
                        'login_times'=>$res['login_times'],
                        'role'=>$res['role']
                    );
                    return $arr;
                }
                else return 'infeasible';
            }else{
                return 'failed-password';
            }
        }else{
            return 'non-exist';
        }
    }

    //更新登陆信息
    public function updateLoginInfo($arr,$staff_id){
        $sql="update table_user set last_login_ip='{$arr['last_login_ip']}' , last_login_time={$arr['last_login_time']} , login_times={$arr['login_times']} where staff_id = '{$staff_id}'; ";
        return $this->db->exec($sql);
    }

    //查询一个用户的密码
    public function fetchOnePwd($staff_id){
        $sql="select user_pwd as password from table_user where staff_id = '{$staff_id}'";
        return $this->db->fetchOne($sql);
    }

    //更新一个用户密码
    public function updateOnePwd($staff_id,$pwd){
        $sql="update table_user set user_pwd='{$pwd}' where staff_id = '{$staff_id}'";
        return $this->db->exec($sql);
    }
}