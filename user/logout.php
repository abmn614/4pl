<?php 
header("content-type:text/html;charset=utf8");
session_start();

if ($_GET['action'] == 'logout') {
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo "<script>alert('退出登录成功！')</script>";
    echo "<script>location='../index.php'</script>";
}
 ?>
