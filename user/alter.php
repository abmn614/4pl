<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
// 实例化user表
$user = M('user');
// 返回user详细信息
if ($_GET['action'] == 'user' && !empty($_GET['userid'])) { // 管理员修改用户信息
    $userinfo = $user->where("id='{$_GET['userid']}'")->field('*')->select();
} elseif($_GET['action'] == 'myself') { // 用户修改自己的资料
    $userinfo = $user->where("id='{$_SESSION['userid']}'")->field('*')->select();
}else{ // 修改资料后提交，以表单的的用户名为准
    $userinfo = $user->where("id='{$_POST['uid']}'")->field('*')->select();
}

// 处理提交表单
$old_password = md5($_POST['old_psw']);
$new_password = $_POST['new_psw'];
$new_repassword = $_POST['new_repsw'];
$update['tel'] = $_SESSION['tel'] = $_POST['tel'];
$update['cellphone'] = $_SESSION['cellphone'] = $_POST['cellphone'];
$update['qq'] = $_SESSION['qq'] = $_POST['qq'];
$update['email'] = $_SESSION['email'] = $_POST['email'];
$update['adress'] = $_SESSION['adress'] = $_POST['adress'];
$update['shipper'] = $_SESSION['shipper'] = $_POST['shipper'];
$update['shipper_title'] = $_SESSION['shipper_title'] = $_POST['shipper_title'];

 ?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>资料修改</title>
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
// 引入头部导航
include('../header.php');

// 更新到数据库

// 如果密码不为空则修改密码
if (!empty($_POST['old_psw'])) {
    if (!empty($_POST['new_psw']) && !empty($_POST['new_repsw'])) {
            echo "<br><br><br>";
            var_dump($userinfo[0]['password']) ;
        if ($old_password === $userinfo[0]['password']) { // 旧密码正确
            if ($new_password === $new_repassword) { // 新密码匹配
                $update['password'] = md5($new_password);
                // 更新到数据库
                if (isset($_POST['submit'])) { // 判断是否提交了表单
                    $flag = $user->where("id='{$_POST['uid']}'")->update($update);
                    if ($flag) {
                    // 写入日志
                    $log = M('log');
                    $insert_log['uid'] = $userinfo[0]['id'];
                    $insert_log['event'] = "{$_SESSION['username']}修改了{$_POST['uname']}的密码";
                    $insert_log['content'] = "{$_SESSION['username']}修改了{$_POST['uname']}的密码";
                    $log->insert($insert_log);

                        echo "<script>alert('密码修改成功！');history.go(-1);</script>";
                    }else{
                        echo "<script>alert('密码未作出任何修改！');history.go(-1);</script>";
                    }
                }
            }else{
                echo "<script>alert('两次输入的新密码不一致！');history.go(-1);</script>";
            }
        }else{
            echo "<br><br><br>";
            var_dump($old_password) ;
            echo "<br><br><br>";
            var_dump($userinfo[0]['password']) ;
            echo "<script>alert('旧密码不正确！');history.go(-1);</script>";
        }
    }else{
        echo "<script>alert('请设置新密码！');history.go(-1);</script>";
    }
}else{
    // 更新到数据库
    if (isset($_POST['submit'])) {
        $flag = $user->where("id='{$_POST['uid']}'")->update($update);
        if ($flag) {
            // 写入日志
            $log = M('log');
            $insert_log['uid'] = $_SESSION['userid'];
            $insert_log['event'] = "{$_SESSION['username']}修改了{$_POST['uname']}的资料";
            foreach ($update as $key => $value) {
                $content_log .= $key." => ".$value."<br>";
            }
            $insert_log['content'] = "修改的资料为：<br><pre>".$content_log."</pre>";
            $log->insert($insert_log);

            echo "<script>alert('资料修改成功！');history.go(-1);</script>";
        }else{
            echo "<script>alert('资料未作出任何修改！');history.go(-1);</script>";
        }
    }
}

 ?>

<!-- 资料修改｛ -->
<div class="container reg">
    <form action="alter.php" method="post" class="form-horizontal">
        <h2>资料修改</h2>
        <div class="control-group">
            <label for="username" class="control-label">用户名</label>
            <div class="controls">
                <input type="text" value="<?=$userinfo[0]['username']?>" disabled>
                <input type="hidden" name="uid" value="<?=$userinfo[0]['id']?>">
                <input type="hidden" name="uname" value="<?=$userinfo[0]['username']?>">
            </div>    
        </div>
        <div class="control-group">
            <label for="old-password" class="control-label">旧密码</label>
            <div class="controls">
                <input type="password" id="old-passowrd" name="old_psw" placeholder="请输入旧密码">
                <p class="text-warning">如果需要修改密码则填此项和下面两项，否则跳过。</p>
            </div>
        </div>
        <div class="control-group">
            <label for="new-password" class="control-label">新密码</label>
            <div class="controls">
                <input type="password" id="new-passowrd" name="new_psw" placeholder="请输入新密码">
            </div>
        </div>
        <div class="control-group">
            <label for="re-new-password" class="control-label">重复新密码</label>
            <div class="controls">
                <input type="password" id="re-new-passowrd" name="new_repsw" placeholder="请再次输入新密码">
            </div>
        </div>
        <div class="control-group">
            <label for="tel" class="control-label">座机电话</label>
            <div class="controls">
                <input type="text" id="tel" placeholder="请输入座机电话" name="tel" value="<?=$userinfo[0]['tel']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="mobile" class="control-label">手机</label>
            <div class="controls">
                <input type="text" id="mobile" placeholder="请输入手机" name="cellphone" value="<?=$userinfo[0]['cellphone']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="qq" class="control-label">QQ</label>
            <div class="controls">
                <input type="text" id="qq" placeholder="请输入QQ" name="qq" value="<?=$userinfo[0]['qq']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label">邮箱</label>
            <div class="controls">
                <input type="email" id="email" placeholder="请输入电子邮箱" name="email" value="<?=$userinfo[0]['email']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="adress" class="control-label">地址</label>
            <div class="controls">
                <input type="text" id="adress" placeholder="请输入地址" name="adress" value="<?=$userinfo[0]['adress']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="fahuoren" class="control-label">发货人</label>
            <div class="controls">
                <input type="text" id="fahuoren" placeholder="请输入发货人" name="shipper" value="<?=$userinfo[0]['shipper']?>" required>
            </div>
        </div>
        <div class="control-group">
            <label for="zhiwei" class="control-label">发货人职位</label>
            <div class="controls">
                <input type="text" id="zhiwei" placeholder="请输入发货人职位" name="shipper_title" value="<?=$userinfo[0]['shipper_title']?>" required>
            </div>
        </div>
        <div class="control-group">
            <input type="submit" value="确认修改" name="submit" class="btn btn-primary btn-large btn-block">
        </div>
    </form>
</div>
<!-- 资料修改｝ -->

<?php 
include('../footer.php');
 ?>