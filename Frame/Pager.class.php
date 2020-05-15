<?php
class Pager
{
    private $page;//当前页
    private $pages;//总页数

    //公共构造方法
    public function __construct($page,$pages)
    {
        $this->page=$page;
        $this->pages=$pages;
    }

    //公共分页方法
    public function pageLize()
    {
        //循环起点和终点
        $start=$this->page-5;
        $end=$this->page+4;

        //如果当前页小于6时
        if($this->page<=6)
        {
            $start=1;
            $end=10;
        }

        //如果当前页大于总页数-4
        if($this->page>=$this->pages-4)
        {
            $start=$this->pages-9;
            $end=$this->pages;
        }

        //如果总页数<10
        if ($this->pages<10)
        {
            $start=1;
            $end=$this->pages;
        }

        //循环输出所有页码
        for ($i=$start;$i<=$end;$i++)
        {
            //当前页不加链接
            if($this->page==$i)
            {
                echo "<span>{$i}</span>";
            }else{
                echo "<a href='?page={$i}'>{$i}</a>";
            }
        }
    }
}