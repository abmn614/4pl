<?php 
header("content-type:text/html;charset=utf8");
session_start();

// 判断网站语言
if ($_GET['lang']) {
    $_SESSION['lang'] = $_GET['lang'];
} else {
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'zh-cn';
    }
}
include("../lang/lang.php");

if ($_GET['action'] == 'logout') {
    unset($_SESSION['userid']);
    unset($_SESSION['username']);
    echo "<script>alert('{$lang['退出登录成功']}！')</script>";
    echo "<script>location='../index.php'</script>";
}
 ?>
