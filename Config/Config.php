<?php
$con =array(
    //数据库配置
    'db_host' => 'localhost',
    'db_user'=>'root',
    'db_port'=>'3306',
    'db_pwd'=>'root',
    'db_name'=>'MyClinic',
    'charset'=>'utf8',
    //默认路由参数
    'default_controller' => 'Login',
    'default_action' => 'index',
);

//配置文件
return $con;