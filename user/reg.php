<?php
header("content-type:text/html;charset=utf8");
include('../class/config.inc.php');
include('../class/model.class.php');

// 开启session
session_start();

// 判断网站语言
if ($_GET['lang']) {
    $_SESSION['lang'] = $_GET['lang'];
} else {
    $_SESSION['lang'] = 'zh-cn';
}
include("../lang/lang.php");

// 接收变量，同时将注册信息写入session，避免用户重复输入，改善用户体验
$insert['username'] = $_SESSION['username'] = $_POST['uname'];
$insert['password'] = md5($_POST['psw']);
$repassword = md5($_POST['repsw']);
$insert['type'] = $_POST['type'];
$insert['tel'] = $_SESSION['tel'] = $_POST['tel'];
$insert['cellphone'] = $_SESSION['cellphone'] = $_POST['cellphone'];
$insert['qq'] = $_SESSION['qq'] = $_POST['qq'];
$insert['email'] = $_SESSION['email'] = $_POST['email'];
$insert['adress'] = $_SESSION['adress'] = $_POST['adress'];
$insert['shipper'] = $_SESSION['shipper'] = $_POST['shipper'];
$insert['shipper_title'] = $_SESSION['shipper_title'] = $_POST['shipper_title'];
$vcode = strtolower($_POST['vcode']);

// 接收验证码session
$vcode_session = strtolower($_SESSION['vcode']);

 ?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title><?=$lang['用户注册']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="../css/style.css">
<!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<![endif]-->
</head>
<body>



<?php
 // 插入到数据库
    if ($insert['password'] === $repassword) {
        // 实例化user表
        $user = M('user');
        if ($user->where("username='{$insert['username']}'")->field('*')->select()) {
                echo "<script>alert('该用户名已存在！');</script>";
                $_SESSION['username'] = ''; // 清空session里的用户名
        }else{
            if (!empty($_POST)) {
                if ($vcode === $vcode_session) {
                    if ($userid = $user->insert($insert)) {
                        // 写入日志
                        $log = M('log');
                        $insert_log['uid'] = $userid;
                        $insert_log['event'] = "用户注册";
                        $insert_log['content'] = "新用户注册，注册ID为".$userid;
                        $log->insert($insert_log);

                        echo "<script>alert('注册成功！');</script>";
                        echo "<script>location='login.php';</script>";
                    }else{
                        echo "<script>alert('注册失败！');</script>";
                    }
                }else{
                    echo "<script>alert('验证码错误！');</script>";
                }
            }
            
        }
    }else{
        echo "<script>alert('两次输入密码不一致！');</script>";
    }
 ?>

<!-- 语言切换 -->
<div class="btn-group center">
    <a href="?lang=zh-cn" class="btn">中文</a>
    <a href="?lang=en" class="btn">English</a>
</div>

<!-- 用户注册｛ -->
<div class="container reg">
    <form action="reg.php" method="post" class="form-horizontal">
        <h2><?=$lang['用户注册']?></h2>
        <div class="control-group">
            <label for="username" class="control-label"><?=$lang['用户名']?></label>
            <div class="controls">
                <input type="text" id="username" name="uname" placeholder="<?=$lang['请输入用户名']?>" value="<?=$_SESSION['username']?>" required autofocus>
            </div>    
        </div>
        <div class="control-group">
            <label for="password" class="control-label"><?=$lang['密码']?></label>
            <div class="controls">
                <input type="password" id="passowrd" name="psw" placeholder="<?=$lang['请输入密码']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="re-password" class="control-label"><?=$lang['重复密码']?></label>
            <div class="controls">
                <input type="password" id="re-passowrd" name="repsw" placeholder="<?=$lang['请再次输入密码']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="type" class="control-label"><?=$lang['类型']?></label>
            <div class="controls">
                <select name="type" id="">
                    <option value="1" selected><?=$lang['个人用户']?></option>
                    <option value="2"><?=$lang['企业用户']?></option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label for="tel" class="control-label"><?=$lang['座机']?></label>
            <div class="controls">
                <input type="text" id="tel" name="tel" placeholder="<?=$lang['请输入座机']?>" value="<?=$_SESSION['tel']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="mobile" class="control-label"><?=$lang['手机']?></label>
            <div class="controls">
                <input type="text" id="mobile" name="cellphone" placeholder="<?=$lang['请输入手机号']?>" value="<?=$_SESSION['cellphone']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="qq" class="control-label"><?=$lang['QQ']?></label>
            <div class="controls">
                <input type="text" id="qq" name="qq" placeholder="<?=$lang['QQ']?>" value="<?=$_SESSION['qq']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label"><?=$lang['邮箱']?></label>
            <div class="controls">
                <input type="email" id="email" name="email" placeholder="<?=$lang['邮箱']?>" value="<?=$_SESSION['email']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="adress" class="control-label"><?=$lang['地址']?></label>
            <div class="controls">
                <input type="text" id="adress" name="adress" placeholder="<?=$lang['地址']?>" value="<?=$_SESSION['adress']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="shipper" class="control-label"><?=$lang['发货人']?></label>
            <div class="controls">
                <input type="text" id="shipper" name="shipper" placeholder="<?=$lang['发货人']?>" value="<?=$_SESSION['shipper']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="shipper_title" class="control-label"><?=$lang['发货人职位']?></label>
            <div class="controls">
                <input type="text" id="shipper_title" name="shipper_title" placeholder="<?=$lang['发货人职位']?>" value="<?=$_SESSION['shipper_title']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="vcode" class="control-label"><?=$lang['验证码']?></label>
            <div class="controls">
                <input type="text" id="vcode" name="vcode" placeholder="<?=$lang['请输入验证码']?>" required>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <label><img src="../vcode.php" alt="点击刷新验证码" onclick="this.src='../vcode.php'" /></label>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <label for="tongyi" class="checkbox"><input type="checkbox" id="tongyi" checked="checked" required><a href="#"><?=$lang['同意本站注册条款']?></a></label>    
            </div>
            <br>
            <input type="submit" value="<?=$lang['注册']?>" class="btn btn-primary btn-large btn-block">
        </div>
    </form>
</div>
<!-- 用户注册｝ -->
<?php 
include('../footer.php');
 ?>
