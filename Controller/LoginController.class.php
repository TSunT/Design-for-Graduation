<?php
class LoginController extends BaseController
{
    public function index()
    {
        if (isset($_SESSION['staff_id']))
        {
            $this->jump('您已登陆,请退出当前账号！','?con=Login&ac=showuserinfo',2);
            die();
        }
        include "./View/login/Loginindex.html";
    }
    //登陆处理方法
    public function login(){
        //获取信息
        $staff_id=$_POST['staff_id'];
        $password=md5($_POST['password']);

        //判断用户名和密码与数据库是否一致
        $modelObj = $this->getInstance('LoginModel');
        $user=$modelObj->loginCheck($staff_id,$password);
        switch ($user)
        {
            case "non-exist":
                {
                    $this->jump('该用户不存在','?con=Login');
                    die();
                }
            case "failed-password":
                {
                    $this->jump('密码错误','?con=Login');
                    die();
                }
            case "infeasible":
                {
                    $this->jump('账号不可用,请联系管理员','?con=Login');
                    die();
                }
            default:
                {
                    //更新登陆数据
                    $user['last_login_ip']=$_SERVER['REMOTE_ADDR'];
                    $user['last_login_time']=time();
                    $user['login_times']=$user['login_times']+1;
                    if($modelObj->updateLoginInfo($user,$staff_id))
                    {
                        $_SESSION['staff_id']=$staff_id;
                        $_SESSION['username']=$user['username'];
                        $_SESSION['staff_dep']=$user['role'];
                        //跳转
                        switch ($user['role'])
                        {
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                            case 6:
                            case 7:
                            case 8:
                            case 9:
                            case 10:
                            case 11:
                            {
                                header('location:?con=Doctor');
                                break;
                            }
                            case 13:
                                {
                                    header('location:?con=Pharmacy');
                                    break;
                                }
                            case 14:
                                {
                                    header('location:?con=Admin');
                                    break;
                                }
                            case 12:
                                {
                                    header('location:?con=Patient');
                                    break;
                                }
                            case 15:
                                {
                                    header('location:?con=Notice');
                                    break;
                                }
                        }
                    }else{
                        $this->jump('登陆失败,请重新登录。','?con=Login',1);
                        die();
                    }
                }
        }
    }

    //退出登陆状态
    public function logout(){
        //删除session数据
        unset($_SESSION['staff_id']);
        unset($_SESSION['username']);
        unset($_SESSION['staff_dep']);
        //删除session文件
        session_destroy();
        //设置sessionid对应的cookie数据过期
        setcookie(session_name(),false);
        //跳转直登陆界面
        header('location:?con=login');
    }

    //显示用户信息
    public function showuserinfo()
    {
        switch ($_SESSION['staff_dep'])
        {
            case 1: $dep_pos='心内科医生';break;
            case 2: $dep_pos='呼吸科医生';break;
            case 3: $dep_pos='血液科医生';break;
            case 4: $dep_pos='消化科医生';break;
            case 5: $dep_pos='内分泌科医生';break;
            case 6: $dep_pos='免疫科医生';break;
            case 7: $dep_pos='眼科医生';break;
            case 8: $dep_pos='耳鼻喉科医生';break;
            case 9: $dep_pos='口腔科医生';break;
            case 10: $dep_pos='皮肤科医生';break;
            case 11: $dep_pos='外科科医生';break;
            case 12: $dep_pos='收费人员';break;
            case 13: $dep_pos='药房人员';break;
            case 14: $dep_pos='管理员';break;
            case 15: $dep_pos='其它人员';break;
        }
        include "./View/login/ShowUserInfo.html";
    }

    //返回分发
    public function goback(){
        switch ($_SESSION['staff_dep'])
        {
            case 12: $this->jump('','?con=patient',0);break;
            case 13: $this->jump('','?con=Pharmacy',0);break;
            case 14: $this->jump('','?con=Admin',0);break;
            case 15: $this->jump('','?con=Notice',0);break;
            default: $this->jump('','?con=Doctor',0);break;

        }
        die();
    }

    //显示修改密码页面
    public function changepwd(){
        include "./View/login/ChangePwd.html";
    }

    //更改数据库中等密码
    public function updatepwd()
    {
        $old_pwd=md5($_POST['oldpwd']);
        $modelObj = $this->getInstance('LoginModel');
        if($modelObj->fetchOnePwd($_SESSION['staff_id'])['password']==$old_pwd)
        {
            if($modelObj->updateOnePwd($_SESSION['staff_id'],md5($_POST['newpwd'])))
            {
                $msg='密码修改成功';
                $this->jump('','?con=Login&ac=showuserinfo');
                include "./View/tips/success.html";
                die();
            }else{
                $this->jump('密码修改失败','?con=Login&ac=showuserinfo');die();
            }
        }else{
            $this->jump('输入旧密码错误','?con=Login&ac=showuserinfo');die();
        }
    }

}