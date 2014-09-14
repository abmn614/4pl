<?php 
header("content-type:text/html;charset=utf8");
include('../class/config.inc.php');
include('../class/model.class.php');
session_start();
$id = $_GET['id'];
$name = $_GET['name'];
$cname = $_GET['cname'];
$product = M('product');
if ($product->where("id={$id}")->delete()) {

        // 写入日志
        $log = M('log');
        $insert_log['uid'] = $_SESSION['userid'];
        $insert_log['event'] = "删除产品";
        $insert_log['content'] = "{$_SESSION['username']}删除了 {$cname} 分类下的产品：<br>id => {$id}<br>name={$name}";
        $log->insert($insert_log);

    echo "<script>alert('删除成功！');location='index.php';</script>";
} else {
    echo "<script>alert('删除失败！');location='index.php';</script>";
}


 ?>