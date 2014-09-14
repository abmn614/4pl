<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
include('../class/page.class.php');

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>库存管理</title>
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
                <li>入库清单</li>
            </ul>
            <!-- 面包屑｝ -->

            <?php 
                $in = M('stockin');
             ?>

            <!-- 产品一级分类｛ -->
            <p>
                <span class="pull-left">
                    共计：<?=$in->count();?>次入库
                </span>
                <span class="pull-right">
                    <a href="in.php" class="btn btn-primary">入库</a>
                    <a href="out.php" class="btn btn-primary">出库</a>
                </span>
            </p>
            <br><br>
            <!-- 产品一级分类｝ -->

            <!-- 产品列表｛ -->
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>快递 / 单号</th>
                        <th>产品 / 数量 / 仓库</th>
                        <th>说明</th>
                        <th>审核状态</th>
                        <th>时间</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        // 分页
                        $page = new Page($in->count(),5,5);
                        
                        $user = M('user');
                        $product = M('product');
                        $pclass = M('pclass');
                        $storage = M('storage');

                        $in_info=$in->limit("{$page->offset},{$page->length}")->field('*')->select();
                        foreach ($in_info as $rows) {
                            echo "
                                <tr>
                                    <td>{$rows['id']}</td>
                            ";
                            $user_name = $user->where("id={$rows['uid']}")->find();
                            echo "
                                    <td>{$user_name['username']}</td>
                                    <td>{$rows['express']}({$rows['expressid']})</td>
                                    <td>
                            ";
                            $pid_arr = explode(',', $rows['pid']);
                            $num_arr = explode(',', $rows['num']);
                            $stid_arr = explode(',', $rows['stid']);
                            for ($i=0; $i < count($pid_arr); $i++) { 
                                $product_info = $product->where("id={$pid_arr[$i]}")->find();
                                $pclass_info = $pclass->where("id={$product_info['cid']}")->find();
                                $storage_info = $storage->where("id={$stid_arr[$i]}")->find();
                                echo "
                                        [{$pclass_info['name']}] {$product_info['name']} ({$num_arr[$i]}) ({$storage_info['name']})<br>
                                ";
                            }
                            echo "
                                    </td>
                                    <td>{$rows['extra']}</td>
                            ";

                            switch ($rows['checked']) {
                                case 1:
                                    echo "<td><span class='text-error'>未审核</span></td>";
                                    break;

                                case 2:
                                    echo "<td>已审核</td>";
                                    break;

                                case 3:
                                    echo "<td>审核未通过</td>";
                                    break;

                                default:
                                    echo "<td>未知</td>";
                                    break;
                            }
                            
                            echo "
                                    <td>{$rows['time']}</td>
                                </tr>
                        ";
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