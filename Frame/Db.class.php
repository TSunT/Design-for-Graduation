<?php
//定义单例数据库连接类
class Db
{
    //私有的静态的保存对象属性
    private static  $obj= null;

    //私有的数据库配置信息
    private $db_host;//主机名
    private $db_port;//端口号
    private $db_user;//用户名
    private $db_pwd;//密码
    private $db_name;//数据库名
    private $charset;//设置字符集
    private $link;//连接对象


    //私有的构造方法,使得外边new无效
    private function __construct()
    {
        $this->db_host=$GLOBALS['config']['db_host'];
        $this->db_port=$GLOBALS['config']['db_port'];
        $this->db_user=$GLOBALS['config']['db_user'];
        $this->db_pwd=$GLOBALS['config']['db_pwd'];
        $this->db_name=$GLOBALS['config']['db_name'];
        $this->charset=$GLOBALS['config']['charset'];
        $this->connectDb(); //连接mysql服务器
        $this->selectDb(); //选择数据库
        $this->setCharset();//设定字符集
    }


    //公共静态的创建方法，外边创建对象
    public static function getInstance()
    {
        //判断当前对象是否存在
        if(!self::$obj instanceof self)
        {
            //如果对象不存在，创建并保存它
            self::$obj=new self();
        }
        //返回对象
        return self::$obj;
    }


    //私有的克隆方法，阻止对外克隆
    private function __clone()
    {
        echo "invalid";
    }

    //私有连接数据库mysql服务器方法
    private function connectDb()
    {
        if(!$this->link= mysqli_connect($this->db_host,$this->db_user,$this->db_pwd))
        {
            echo "数据库连接失败！";
            die();
        }
    }

    //私有的选择数据库方法
    private function selectDb()
    {
        if(!mysqli_select_db($this->link,$this->db_name))
        {
        echo "<h2>选择数据库{$this->db_name}失败</h2>";
        die();
        }
    }

    //私有设置字符集
    private function setCharset()
    {
        mysqli_set_charset($this->link,$this->charset);
    }

    //公共的析构方法
    public function __destruct()
    {
        mysqli_close($this->link);//断开与数据库的连接
    }


    //公共执行SQL语句的方法：insert，update，delete，set drop
    //执行成功返回true，失败返回false
    public function exec($sql)
    {
        //将sql语句转换成全小写
        $sql= strtolower($sql);

        //判读是否室select语句
        if(substr($sql,0,6)=='select')
        {
            echo '不能执行select语句';
            die();
        }
        //返回执行结果（布尔值）
        return mysqli_query($this->link,$sql);
    }


    //执行sql语句的方法：select
    //执行成功返回结果集对象，失败返回false
    private function query($sql)
    {
        //将sql语句转换成全小写
        $sql= strtolower($sql);

        //判读是否非select语句
        if(substr($sql,0,6)!='select')
        {
            echo '不能执行非select语句';
            die();
        }
        //返回执行结果（结果集对象）
        return mysqli_query($this->link,$sql);
    }


    //公共的获取单行的方法
    public function fetchOne($sql,$type=3)
    {
        //执行select语句返回结果集
        $result=$this->query($sql);

        if($result==false)
        {
            echo 'SQL查询失误';
            die();
        }

        //返回数组类型的常量
        $types=array(
            1=>MYSQLI_NUM,
            2=>MYSQLI_BOTH,
            3=>MYSQLI_ASSOC
        );
        //返回一维数组
       return mysqli_fetch_array($result,$types[$type]);
    }

    //公共的获取多行数据的方法,3维默认值
    public function fetchAll($sql,$type=3)
    {
        //执行select语句返回结果集
        $result=$this->query($sql);

        if($result==false)
        {
            echo 'SQL查询失误';
            die();
        }

        //返回数组类型的常量
        $types=array(
            1=>MYSQLI_NUM,
            2=>MYSQLI_BOTH,
            3=>MYSQLI_ASSOC
        );

        //返回二维数组
        return mysqli_fetch_all($result,$types[$type]);
    }

    //获取记录数
    public function rowCount($sql)
    {
        //执行select语句返回结果集
        $result=$this->query($sql);

        if($result){
            //返回记录数
            return mysqli_num_rows($result);
        }else {
            //返回记录数
            return 0;
        }
    }

    //事务的处理程序开始
    public function trans_begin(){
        mysqli_query($this->link,'SET AUTOCOMMIT=0');//开启事务
        mysqli_begin_transaction($this->link);
    }

    //事务的处理提交
    public function trans_commit(){
        mysqli_commit($this->link);//事务的提交
        mysqli_query($this->link,'SET AUTOCOMMIT=1');
    }

    //事务的回滚
    public function trans_rollback(){
        mysqli_rollback($this->link);//事务回滚
        mysqli_query($this->link,'SET AUTOCOMMIT=1');
    }
}
