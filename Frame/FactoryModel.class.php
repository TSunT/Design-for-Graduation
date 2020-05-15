<?php
//最终工厂类 用来创建对象
final class FactoryModel
{
    //公共的静态创建不同模型类的对象方法
    public static function getInstance($modelClassName)
    {
        //创建指定模型类对象并返回
        return new $modelClassName();
    }
}