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
<title>修改一级分类</title>
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
// 引入头部
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
                <li><a href="#">一级分类</a><span class="divider"> / </span></li>
                <li>修改一级分类</li>
            </ul>
            <!-- 面包屑｝ -->

            <?php 
                $update['name'] = $_POST['cname'];
                $pclass = M('pclass');
                if ($_POST['submit']) {
                    if ($pclass->where("id={$_POST['id']}")->update($update)) {

                        // 写入日志
                        $log = M('log');
                        $insert_log['uid'] = $_SESSION['userid'];
                        $insert_log['event'] = "修改一级产品分类";
                        $insert_log['content'] = "{$_SESSION['username']}修改了一级产品分类：<br>id => {$_POST['id']}<br>name => {$_POST['cname']}";
                        $log->insert($insert_log);

                        echo "<script>alert('更新成功！');location='class.php';</script>";
                    } else {
                        echo "<script>alert('更新失败！');location='class.php';</script>";
                    }
                    
                }

             ?>

            <!-- 修改产品一级分类｛ -->
            <div class="container reg">
                <form action="alterclass.php" method="post" class="form-horizontal">
                    <h2>修改一级分类</h2>
                    <div class="control-group">
                        <label for="cname" class="control-label">类名</label>
                        <div class="controls">
                            <input type="text" id="cname" name="cname" value="<?=$_GET['name']?>" placeholder="请输入一级分类名称" required autofocus>
                            <input type="hidden" name="id" value="<?=$_GET['id']?>">
                        </div>    
                    </div>
                    <div class="control-group">
                        <input type="submit" name='submit' value="确认修改" class="btn btn-primary btn-large btn-block">
                    </div>
                </form>
            </div>
            <!-- 修改产品一级分类｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
// 引入尾部
include('../footer.php');
 ?>