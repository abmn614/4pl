<?php 
header("content-type:text/html;charset=utf8");
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
include('../class/page.class.php');

if ($_SESSION['role'] != 1) { // 不是管理员
    echo "<script>alert('当前用户非管理员！');location='../index.php';</script>";
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>操作日志</title>
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
            include("../nav.php");
         ?>
        <!-- 左侧导航菜单｝ -->
        <!-- 右侧内容｛ -->
        <div class="span10 pull-right right">
            <!-- 面包屑｛ -->
            <ul class="breadcrumb clearfix">
                <li><a href="#"><i class="icon-home"> </i> 首页</a><span class="divider"> / </span></li>
                <li>操作日志</li>
            </ul>
            <!-- 面包屑｝ -->

        <table class="table table-default table-hover table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>操作者</th>
                    <th>事件</th>
                    <th>描述</th>
                    <th>时间</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
                $log = M('log');
                $page = new Page($log->count(),5,5);
                $log_info = $log->field('*')->limit("{$page->offset},{$page->length}")->select();
                $user = M('user');
                foreach ($log_info as $key => $value) {
                    $username = $user->where("id={$log_info[$key]['uid']}")->field('username')->select();
                    echo "
                        <tr>
                            <td>{$log_info[$key]['id']}</td>
                            <td>{$username[0]['username']}</td>
                            <td>{$log_info[$key]['event']}</td>
                            <td>{$log_info[$key]['content']}</td>
                            <td>{$log_info[$key]['time']}</td>
                        </tr>
                    ";
                }

             ?>

                
            </tbody>
        </table>

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

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>