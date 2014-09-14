<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
include('../class/page.class.php');

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
                <li>仓库管理</li>
            </ul>
            <!-- 面包屑｝ -->

            <!-- 添加仓库｛ -->
            <a href="add.php" class="btn btn-primary">添加仓库</a>
            <br>
            <br>
            <!-- 添加仓库｝ -->

            <!-- 用户列表｛ -->
            <table class="table table-default table-hover table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>仓库名</th>
                        <th>地址</th>
                        <th>货架数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>

<?php 
$storage = M('storage');

// 此处用先用到了page类的参数，所以要先实例化
$page = new Page($storage->count(),5,5);

$storage_info = $storage->field('*')->limit("{$page->offset},{$page->length}")->select();

if (!empty($storage_info)) {
    foreach ($storage_info as $rows) {
        echo "
        <tr>
            <td>{$rows['id']}</td>
            <td>{$rows['name']}</td>
            <td>{$rows['adress']}</td>
            <td>{$rows['shelf']}</td>
            <td><a href='alter.php?ckid={$rows['id']}' class='btn btn-primary'>修改</a> <a href='del.php?ckid={$rows['id']}' class='btn btn-primary'>删除</a></td>

        </tr>
        ";
    }
}else{
    echo "<tr><td colspan='5'>没有记录！请<a href='add.php'>添加</a>仓库！</td></tr>";
}


 ?>

                </tbody>
            </table>
            <!-- 用户列表｝ -->

            <!-- 分页｛ -->
            <div class="pagination pagination-centered">
                <ul>
                    <?php 
                        $page->outpage();
                     ?>
                </ul>
            </div>
            <!-- 分页｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
include('../footer.php');
 ?>
