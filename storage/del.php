<?php 
include('../class/config.inc.php');
include('../class/model.class.php');
session_start();
$ckid = $_GET['ckid'];
$storage = M('storage');
$storage_info = $storage->where("id={$ckid}")->field('*')->select();
if (!empty($ckid)) {
    if ($ckid == $storage_info[0]['id']) {
        if ($storage->where("id={$ckid}")->delete()) {
            // 写入日志
            $log = M('log');
            $insert_log['uid'] = $_SESSION['userid'];
            $insert_log['event'] = "删除仓库";
            foreach ($storage_info[0] as $key => $value) {
                $content_log .= $key.' => '.$value.'<br>';
            }
            $insert_log['content'] = "{$_SESSION['username']}删除了仓库：<br>{$content_log}";
            $log->insert($insert_log);

            echo "<script>alert('删除成功！');location='index.php';</script>";
        }else{
            echo "<script>alert('删除失败！');location='index.php';</script>";
        }
    }else{
        echo "<script>alert('ID参数错误！');location='index.php';</script>";
    }
}else{
    echo "<script>alert('ID参数不能为空！');location='index.php';</script>";
}


echo $ckid;
 ?>