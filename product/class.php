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
<title>一级分类</title>
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
                <li>一级分类</li>
            </ul>
            <!-- 面包屑｝ -->

            <!-- 产品一级分类｛ -->
            <p><a href="addclass.php" class="btn btn-primary">添加一级分类</a></p>
            <p><span class="label label-important">注意：删除一级分类时，请确保此分类下已没有相关产品。虽然提供删除操作，但一般情况下不建议删除。</span></p>
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>类名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $pclass = M('pclass');
                        $pclass_info = $pclass->field('*')->select();
                        foreach ($pclass_info as $key => $value) {
                            echo "
                                <tr>
                                    <td>{$pclass_info[$key]['id']}</td>
                                    <td>{$pclass_info[$key]['name']}</td>
                                    <td><a href='alterclass.php?id={$pclass_info[$key]['id']}&name={$pclass_info[$key]['name']}' class='btn btn-primary'>修改</a> 
                                        <a href='delclass.php?id={$pclass_info[$key]['id']}&name={$pclass_info[$key]['name']}' class='btn btn-primary'>删除</a></td>
                                </tr>
                            ";
                        }

                     ?>
                     
                </tbody>
            </table>

            <!-- 产品一级分类｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
// 引入尾部
include('../footer.php');
 ?>