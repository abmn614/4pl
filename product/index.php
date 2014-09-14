<?php 
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

include('../class/config.inc.php');
include('../class/model.class.php');
include('../class/page.class.php');

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$lang['我的产品']?></title>
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
                <li><a href="../index.php"><i class="icon-home"> </i> <?=$lang['首页']?></a><span class="divider"> / </span></li>
                <li><?=$lang['我的产品']?></li>
            </ul>
            <!-- 面包屑｝ -->

            <!-- 产品一级分类｛ -->
            <div class="btn-group">
                <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?=$lang['产品分类']?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='index.php'><?=$lang['全部产品']?></a></li>
                    <?php 
                        $pclass = M('pclass');
                        $pclass_info = $pclass->field('*')->select();
                        foreach ($pclass_info as $rows) {
                            echo "
                                <li><a href='index.php?cid={$rows['id']}'>{$rows['name']}</a></li>
                            ";
                        }

                     ?>

                </ul>
            </div>
            <span class="pull-right">
                <a href="add.php" class="btn btn-primary"><?=$lang['添加产品']?></a>
            </span>
            <br><br>
            <!-- 产品一级分类｝ -->

            <!-- 产品列表｛ -->
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><?=$lang['分类']?></th>
                        <th><?=$lang['产品ID']?></th>
                        <th><?=$lang['产品名称']?></th>
                        <th><?=$lang['产品图片']?></th>
                        <th><?=$lang['单重']?></th>
                        <th><?=$lang['单价']?></th>
                        <th><?=$lang['规格']?></th>
                        <th><?=$lang['颜色']?></th>
                        <th><?=$lang['上/下限']?></th>
                        <th><?=$lang['备注']?></th>
                        <th><?=$lang['操作']?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $product = M('product');
                        if ($_GET['cid']) {
                            // 分页
                            $tot = $product->where("cid={$_GET['cid']}")->count();
                            $page = new Page($tot,5,5);
                            $product_info = $product->where("cid={$_GET['cid']}")->field('*')->select();
                        } else {
                            // 分页
                            $page = new Page($product->count(),5,5);
                            $product_info = $product->field('*')->select();
                        }
                        
                        if ($product_info) {
                            foreach ($product_info as $rows) {
                                $cname = $pclass->where("id={$rows['cid']}")->find();
                                echo "
                                    <tr>
                                        <td>{$rows['id']}</td>
                                        <td>{$cname['name']}</td>
                                        <td>{$rows['pid']}</td>
                                        <td>{$rows['name']}</td>
                                        <td><img src='{$rows['pic']}' width='100'></td>
                                        <td>{$rows['weight']}kg</td>
                                        <td>{$rows['price']}￥</td>
                                        <td>{$rows['size']}</td>
                                        <td>{$rows['color']}</td>
                                        <td>{$rows['max']} / {$rows['min']}</td>
                                        <td>{$rows['note']}</td>
                                        <td><a href='alter.php?id={$rows['id']}' class='btn btn-primary'>{$lang['修改']}</a> <a href='del.php?id={$rows['id']}&name={$rows['name']}&cname={$cname['name']}' class='btn btn-primary'>{$lang['删除']}</a></td>
                                    </tr>
                                ";
                            }
                        } else {
                            echo "<td colspan='12'>{$lang['没有记录']}！</td>";
                        }
                        
                        

                     ?>
                    
                </tbody>
            </table>
            <!-- 产品列表｝ -->

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
// 引入尾部
include('../footer.php');
 ?>