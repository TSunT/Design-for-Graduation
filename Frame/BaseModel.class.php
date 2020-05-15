<?php
//定义抽象(只能继承不能实例话)的基础模型类
abstract class BaseModel
{
    //受保护的保存数据库对象的属性
    protected $db=null;
    //创建db类的对象
    public function __construct()
    {
        $this->db=Db::getInstance();
    }
}
