<?php 
header("content-type:text/html;charset=utf8");
include('../class/config.inc.php');
include('../class/model.class.php');
session_start();
$id = $_GET['id'];
$pclass = M('pclass');
if ($pclass->where("id={$id}")->delete()) {

        // 写入日志
        $log = M('log');
        $insert_log['uid'] = $_SESSION['userid'];
        $insert_log['event'] = "删除一级产品分类";
        $insert_log['content'] = "{$_SESSION['username']}删除了一级产品分类：<br>id => {$id}<br>name={$_GET['name']}";
        $log->insert($insert_log);

    echo "<script>alert('删除成功！');location='class.php';</script>";
} else {
    echo "<script>alert('删除失败！');location='class.php';</script>";
}


 ?>