<?php
//定义抽象基础控制器类

abstract class BaseController
{
    //受保护的跳转方法
    protected function jump($message,$url='?',$time=3)
    {
        header("refresh:{$time};url={$url}");
        echo "<h2>{$message}</h2>";
    }

    protected function authentication()
    {
        if(!isset($_SESSION['staff_id']))
        {
            header('refresh:3;url=?Login');
            echo '请登录';
            die();
        }
    }

    protected function getInstance($modelClassName)
    {
        //创建指定模型类对象并返回
        return new $modelClassName();
    }

}
