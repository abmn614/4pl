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

<body>

<?php 
// 引入头部导航
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
                <li>添加仓库</li>
            </ul>
            <!-- 面包屑｝ -->

<?php 
// 接收表单
$insert['name'] = $_POST['ckname'];
$insert['adress'] = $_POST['ckadress'];
$insert['shelf'] = $_POST['hjnum'];

if (isset($_POST['submit'])) {
    $storage = M('storage');
    if ($storage_id = $storage->insert($insert)) {
        // 自动生成货架表数据
        $shelf = M('shelf');
        $insert_shelf['stid'] = $storage_id;
        $insert_shelf['state'] = 0;
        for ($i=0; $i < $_POST['hjnum']; $i++) { 
            $insert_shelf['shid'] = $i+1;
            $shelf->insert($insert_shelf);
        }

        // 写入日志
        $log = M('log');
        $insert_log['uid'] = $_SESSION['userid'];
        $insert_log['event'] = "添加仓库";
        foreach ($insert as $key => $value) {
            $content_log .= $key.' => '.$value.'<br>';
        }
        $insert_log['content'] = "{$_SESSION['username']}添加了仓库：<br>id => {$storage_id}<br>{$content_log}";
        $log->insert($insert_log);

        echo "<script>alert('添加成功！');location='index.php'</script>";
    }else{
        echo "<script>alert('添加失败！')</script>";
    }
}

 ?>
            <!-- 添加仓库｛ -->
            <div class="container reg">
                <form action="add.php" method="post" class="form-horizontal">
                    <h2>添加仓库</h2>
                    <div class="control-group">
                        <label for="ckname" class="control-label">仓库名</label>
                        <div class="controls">
                            <input type="text" id="ckname" name="ckname" placeholder="请输入仓库" required autofocus>
                        </div>    
                    </div>
                    <div class="control-group">
                        <label for="ckadress" class="control-label">仓库地址</label>
                        <div class="controls">
                            <input type="text" id="ckadress" name="ckadress" placeholder="请输入仓库地址" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="hjnum" class="control-label">货架数</label>
                        <div class="controls">
                            <input type="text" id="hjnum" name="hjnum" placeholder="请输入货架数" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <input type="submit" value="确认添加" name="submit" class="btn btn-primary btn-large btn-block">
                    </div>
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