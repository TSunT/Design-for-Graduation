<?php
//定义最终的框架初始类
final class Frame
{
    //公共的静态框架初始化方法
    public static function run()
    {
        self::initConfig(); //初始化配置信息
        //self::initRoute();//初始化路由参数
        //self::initConst();//初始化目录常量
        self::initAutoLoad();//初始化类的自动加载
        self::initDistribute_Path();//初始化请求分发

    }

    //私有的静态初始化配置信息方法
    private static function initConfig()
    {
        //开启sesson会话
        session_start();
        $GLOBALS['config'] = require_once ("./Config/Config.php");//$GOLBALS是超全局数组，一个脚本的全部作用域中都可用
    }

    //私有的静态初始化路由参数方法
    private static function initRoute()
    {
        //获取路由参数
        //$plf = isset($_GET['con']) ? $_GET['con'] : $GLOBALS['config'] ['default_pal'];//平台名
        //$con = isset($_GET['con']) ? $_GET['con'] : $GLOBALS['config'] ['default_controller'];//控制器前缀名($GOLBALS是超全局数组，一个脚本的全部作用域中都可用)
        //$ac = isset($_GET['ac']) ? $_GET['ac'] :$GLOBALS['config'] ['default_action'];//动作($GOLBALS是超全局数组，一个脚本的全部作用域中都可用)
        //定义常量，来让后续方法使用
        //define('PLAT',$plf);
        //define("CONTROLLER",$con);
        //define('_ACTION',$ac);
    }

    //私有的静态初始化目录常量方法
    private static function initConst()
    {
        define("DS",DIRECTORY_SEPARATOR);//动态目录分隔符
        define("ROOT_PATH",getcwd().DS);//当前目录
        define("MODEL_PATH",ROOT_PATH.DS."Model".DS);//MODEL目录
        define("CONTROLLER_PATH",ROOT_PATH.DS."Controller".DS);//Controller目录

    }

    //私有的静态初始化类的自动加载方法
    private static function initAutoLoad()
    {
        //类的自动加载
        spl_autoload_register(function ($className){
            //类文件路径数组
            $arr=array(
                "./Frame/$className.class.php",
                "./Model/$className.class.php",//平台入口要改"./".PLAT."/Model/$className.class.php"
                "./Controller/$className.class.php"//平台入口要改"./".PLAT."/Controllerl/$className.class.php"
            );
            //循环数组
            foreach ($arr as $filename)
            {
                //如果类文件存在，则包含
                if (file_exists($filename)) require_once ($filename);
            }
        });

    }

    //私有的静态初始化请求分发方法
    private static function initDistribute_Path()
    {
        //获取路由参数
        $ac = isset($_GET['ac']) ? $_GET['ac'] :$GLOBALS['config'] ['default_action'];
        $con = isset($_GET['con']) ? $_GET['con'] : $GLOBALS['config'] ['default_controller'];//
        //创建对象
        $controllerClassName= $con .'Controller';
        $controllerObj=new $controllerClassName();
        //执行相应的动作
        $controllerObj-> $ac();
    }
}