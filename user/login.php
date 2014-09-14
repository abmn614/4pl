<?php 
header("content-type:text/html;charset=utf8");
include('../class/config.inc.php');
include('../class/model.class.php');
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

// 接收用户名和密码
$username = $_POST['uname'];
$password = md5($_POST['psw']);
$vcode = strtolower($_POST['vcode']);
$remember = $_POST['remember'];

// 开启session，接收验证码
session_start();

if (!empty($_POST)) {
    if ($vcode != '' && $vcode === strtolower($_SESSION['vcode'])) {
        // 实例化user表
        $user = M('user');
        if ($userlogin = $user->where("username='{$username}'")->field('*')->select()) { // 如果用户存在，同时提取userlogin用户信息数组
            if ($remeber[0] = 'on') { // 勾选了记住我
                setcookie('username',$username,time()+604800,'/');
            }
            if ($password === $userlogin[0]['password']) { // 则验证密码
                // 写入日志
                $log = M('log');
                $insert_log['uid'] = $userlogin[0]['id'];
                $insert_log['event'] = "用户登录";
                $login_count = $log->where("uid={$userlogin[0]['id']}")->count() + 1;
                $insert_log['content'] = "用户登录，共登录".$login_count."次,<br>IP：".$_SERVER["REMOTE_ADDR"];
                $log->insert($insert_log);

                echo "<script>alert('{$lang[登录成功]}！');</script>";
                $_SESSION['userid'] = $userlogin[0]['id'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $userlogin[0]['role'];
                if ($userlogin[0]['role'] == 1) { // 如果是管理员
                    echo "<script>location='index.php?uid={$userlogin[0]['id']}';</script>"; //则跳转到用户管理首页
                }else{
                    echo "<script>location='../index.php?uid={$userlogin[0]['id']}';</script>"; //则跳转到用户个人首页页
                }
            }else{
                echo "<script>alert('{$lang[密码错误]}！');</script>";
            }
        }else{
            echo "<script>alert('{$lang[用户名错误]}！');</script>";
        }
    }else{
        echo "<script>alert('{$lang[验证码错误]}！');location='login.php';</script>";
    }
}

 ?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title><?=$lang['用户登录']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="../css/style.css">
<!--[if lt IE 9]>
<script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<![endif]-->
</head>
<body>
<!-- 语言切换 -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="brand">第四方仓储管理系统</a>
            <ul class='nav pull-right'>
                <li class='dropdown'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'><?=$lang['语言']?><span class='caret'></span></a>
                    <ul class='dropdown-menu' role='menu'>
                        <li><a href='?lang=zh-cn'>中文</a></li>
                        <li><a href='?lang=en'>English</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- 用户登录｛ -->
<div class="container" style="margin-top: 100px;">
    <form class="form-signin" action="login.php" method="post">
        <p><span class="pull-right"><a href="reg.php"><?=$lang['注册']?> <i class="icon-circle-arrow-right"></i></a></span><span><?=$lang['登录']?></span></p>
        <input type="text" name="uname" class="input-block-level" placeholder="<?=$lang['请输入用户名']?>" value="<?= $_COOKIE['username']?>" required autofocus>
        <input type="password" name="psw" class="input-block-level" placeholder="<?=$lang['请输入密码']?>" required>
        <input type="text" name="vcode" class="input-block-level span2" placeholder="<?=$lang['请输入验证码']?>" required>
        <img src="../vcode.php" class="pull-right" onclick="this.src='../vcode.php'" style="cursor: pointer;">
        <label class="checkbox">
            <input type="checkbox" name="remember[]" <?php if($_COOKIE['username']){echo "checked='checked'";}?>>
            <?=$lang['记住我']?>
            <span class="pull-right">
                <a href=""><?=$lang['忘记密码？']?></a>
            </span>
        </label>
        <button type="submit" class="btn btn-large btn-primary btn-block"><?=$lang['登录']?></button>
    </form>
</div>
<!-- 用户登录｝ -->

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>