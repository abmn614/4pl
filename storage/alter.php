<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');

if ($_SESSION['role'] != 1) { // 不是管理员
    echo "<script>alert('当前用户非管理员！');history.back();</script>";
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>仓库</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="../css/style.css">
<!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<![endif]-->
</head>
,m 
<body>

<?php 
// 头部导航
include('../header.php');

 ?>
    
<!-- 主要内容｛ -->
<div class="container-fluid">
    <div class="row-fluid">
        <!-- 左侧导航菜单｛ -->
        <?php 
            // 引入左侧菜单
            include('../nav.php');
         ?>
        <!-- 左侧导航菜单｝ -->
        <!-- 右侧内容｛ -->
        <div class="span10 pull-right right">
            <!-- 面包屑｛ -->
            <ul class="breadcrumb clearfix">
                <li><a href="#"><i class="icon-home"> </i> 首页</a><span class="divider"> / </span></li>
                <li><a href="#">仓库管理</a><span class="divider"> / </span></li>
                <li>修改仓库</li>
            </ul>
            <!-- 面包屑｝ -->

<?php 
// 接收表单
$ckid = $_GET['ckid'];
$update['adress'] = $_POST['ckadress'];
$update['shelf'] = $_POST['hjnum'];

$storage = M('storage');
$storage_info = $storage->where("id={$ckid}")->field('*')->select();

if (isset($_POST['submit'])) {
    if ($ckid == $storage_info[0]['id']) {
        if ($storage->where("id={$_POST['ckid']}")->update($update)) {

            // 写入日志
            $log = M('log');
            $insert_log['uid'] = $_SESSION['userid'];
            $insert_log['event'] = "修改仓库";
            foreach ($update as $key => $value) {
                $content_log .= $key.' => '.$value.'<br>';
            }
            $insert_log['content'] = "{$_SESSION['username']}修改了仓库：<br>id => {$_POST['ckid']}<br>{$content_log}";
            $log->insert($insert_log);

            echo "<script>alert('修改成功！')</script>";
            echo "<script>history.go(-2);</script>";
        }else{
            echo "<script>alert('修改失败！');history.back();</script>";
        }
    }else{
        echo "<script>alert('参数不正确')</script>";
    }
}

 ?>

            <!-- 添加仓库｛ -->
            <div class="container reg">
                <form action="alter.php" method="post" class="form-horizontal">
                    <h2>修改仓库</h2>
                    <div class="control-group">
                        <label for="ckname" class="control-label">仓库名</label>
                        <div class="controls">
                            <input type="text" id="ckname" name="ckname" value="<?=$storage_info[0]['name']?>" required disabled>
                            <input type="hidden" name="ckid" value="{$ckid}">
                        </div>    
                    </div>
                    <div class="control-group">
                        <label for="ckadress" class="control-label">仓库地址</label>
                        <div class="controls">
                            <input type="text" id="ckadress" name="ckadress" value="<?=$storage_info[0]['adress']?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="hjnum" class="control-label">货架数</label>
                        <div class="controls">
                            <input type="text" id="hjnum" name="hjnum" value="<?=$storage_info[0]['shelf']?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <input type="submit" value="确认修改" name="submit" class="btn btn-primary btn-large btn-block">
                    </div>
                    <input type="hidden" name="ckid" value="<?=$ckid?>">
                </form>
            </div>
            <!-- 添加仓库｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
include('../footer.php');
 ?>