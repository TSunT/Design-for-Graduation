<?php
require_once './Dbtables.class.php';
$config=require_once '../Config/Config.php';
//连接数据库
$db = Dbtables::getInstance($config);

//获取Datatables发送的参数 必要
$draw = $_GET['draw'];//这个值作者会直接返回给前台

//排序
$order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
$order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序

//拼接排序sql
$orderSql = "";
if (isset($order_column)) {
    $i = intval($order_column);
    switch ($i) {
        case 0;
            $orderSql = " order by medicine_id " . $order_dir;
            break;
        case 1;
            $orderSql = " order by medicine_name " . $order_dir;
            break;
        case 2;
            $orderSql = " order by cost " . $order_dir;
            break;
        case 3;
            $orderSql = " order by rest " . $order_dir;
            break;
        default;
            $orderSql = '';
    }
}
//搜索
$search = $_GET['search']['value'];//获取前台传过来的过滤条件

//分页
$start = $_GET['start'];//从多少开始
$length = $_GET['length'];//数据长度
$limitSql = '';
$limitFlag = isset($_GET['start']) && $length != -1;
if ($limitFlag) {
    $limitSql = " LIMIT " . intval($start) . ", " . intval($length);
}

//定义查询数据总记录数sql
$sumSql = "SELECT medicine_id FROM table_medicine";
//条件过滤后记录数 必要
$recordsFiltered = 0;
//表的总记录数 必要
$recordsTotal = $db->rowCount($sumSql);
//$recordsTotalResult = ;
//while ($row = $db->fetch_One($recordsTotalResult)) {
//    $recordsTotal = $row['sum'];
//}
$sumSql = "SELECT count(medicine_id) as sum FROM table_medicine";
////定义过滤条件查询过滤后的记录数sql
$sumSqlWhere = " where medicine_name LIKE '%" . $search . "%'";
if (strlen($search) > 0) {
    $recordsFilteredResult = $db->query($sumSql . $sumSqlWhere);
    while ($row = $db->fetch_One($recordsFilteredResult)) {
        $recordsFiltered = $row['sum'];
    }
} else {
    $recordsFiltered = $recordsTotal;
}

//query data
$totalResultSql = "SELECT medicine_id , medicine_name,cost,rest FROM table_medicine";
$infos = array();
if(strlen($search)>0){
    //如果有搜索条件，按条件过滤找出记录
    $dataResult = $db->query($totalResultSql.$sumSqlWhere.$orderSql.$limitSql);
    while ($row = $db->fetch_One($dataResult)) {
        $obj = array($row['medicine_id'], $row['medicine_name'], $row['cost'], $row['rest']);
        array_push($infos,$obj);
    }
}else{
    //直接查询所有记录
    $dataResult = $db->query($totalResultSql.$orderSql.$limitSql);
    while ($row = $db->fetch_One($dataResult)) {
        $obj = array($row['medicine_id'], $row['medicine_name'], $row['cost'], $row['rest']);
        array_push($infos,$obj);
    }
}

/*
 * Output 包含的是必要的
 */
echo json_encode(array(
    "draw" => intval($draw),
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $infos
), JSON_UNESCAPED_UNICODE);

function fatal($msg)
{
    echo json_encode(array(
        "error" => $msg
    ));
    exit(0);
}