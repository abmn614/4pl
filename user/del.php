<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
$userid = $_GET['userid'];
$user = M('user');
$user_info = $user->where("id={$userid}")->field('*')->select();
echo "<pre>";
print_r($user_info);
echo "</pre>";
if ($userid) {
    if ($userid == $user_info[0]['id']) {
        if ($user->where("id={$userid}")->delete()) {
            // 写入日志
            $log = M('log');
            $insert_log['uid'] = $_SESSION['userid'];
            $insert_log['event'] = "用户删除";
            $insert_log['content'] = "{$_SESSION['username']}将{$user_info[0]['username']}删除";
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

 ?>