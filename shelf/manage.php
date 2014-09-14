<?php 
header("content-type:text/html;charset=utf8");
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$lang['货架管理']?></title>
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
                <li><a href="#"><i class="icon-home"> </i> <?=$lang['首页']?></a><span class="divider"> / </span></li>
                <li><a href="#"><?=$lang['我的货架']?></a><span class="divider"> / </span></li>
                <li><?=$lang['货架管理']?></li>
            </ul>
            <!-- 面包屑｝ -->

            <?php 
                $shelf = M('shelf');
                $tot_shelf = $shelf->where("uid={$_SESSION['userid']}")->count();
                $tot_shelf_used = $shelf->where("state=3")->count();

             ?>

            <!-- 货架信息｛ -->
            <p class="shelf-info">
                <span><?=$lang['总货架']?>：<?=$tot_shelf?></span>
                <span>总货位：<?=$tot_shelf*12?></span>
                <span>已用货架：<?=$tot_shelf_used?></span>
                <span>已用货位：等做到产品才能计算</span>
                <span>剩余货架：<?=$tot_shelf-$tot_shelf_used?></span>
                <span>剩余货位：等做到产品才能计算（<strong class="text-success">充足</strong>）</span>
            </p>
            <!-- 货架信息｝ -->
            
            <!-- 购买货架 -->
            <a href="buy.php" class="btn btn-primary"><?=$lang['购买货架']?></a>
            <br><br>

            <!-- 货架管理｛ -->
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th><?=$lang['仓库']?></th>
                        <th><?=$lang['货架编号']?></th>
                        <th><?=$lang['状态']?></th>
                        <th><?=$lang['操作']?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $shelf_info = $shelf->where("uid={$_SESSION['userid']}")->field('*')->select();
                    if (!empty($shelf_info)) {
                        $storage = M('storage');
                        foreach ($shelf_info as $rows) {
                            $storage_info = $storage->where("id={$rows['stid']}")->find();
                            echo "
                                <tr>
                                    <td>{$storage_info['name']}</td>
                                    <td>{$rows['shid']}</td>
                            ";
                            if ($rows['checked'] == 3) {
                                echo "
                                    <td>{$lang['已购买，等待审核中']}</td>
                                    <td><span class='btn btn-primary disabled'>删除</span></td>
                                ";
                            } elseif($rows['checked'] == 4) {
                                echo "
                                    <td>{$lang['已删除，等待审核中']}</td>
                                    <td><span class='btn btn-primary disabled'>删除</span></td>
                                ";
                            }else{
                                echo "
                                    <td>{$lang['正常']}</td>
                                    <td><a href='manage.php?id={$rows['id']}&shid={$rows['shid']}&stname={$storage_info['name']}' class='btn btn-primary'>{$lang['删除']}</a></td>
                                ";
                            }
                            echo "
                                </tr>
                            ";
                            
                        }
                    } else {
                        echo "<td colspan='4'><a href='buy.php'>{$lang['请先购买货架']}</a>！</td>";
                    }
                    

                    // 处理删除操作
                    $update['checked'] = 4;
                    if ($_GET['id']) {
                        if ($shelf->where("id={$_GET['id']}")->update($update)) {

                            // 写入日志
                            $log = M('log');
                            $insert_log['uid'] = $_SESSION['userid'];
                            $insert_log['event'] = "删除货架-进入审核";
                            $storage = M('storage');
                            $storage_name = $storage->where("id={$_POST['stid']}")->field('name')->select();
                            $shelf_num = count($shelf_arr);
                            $content_log = "删除了 1 个货架：<br>{$_GET['stname']}：{$_GET['shid']}";
                            $insert_log['content'] = "{$_SESSION['username']}{$content_log}<br>已进入审核";
                            $log->insert($insert_log);

                            echo "<script>alert('{$lang['操作成功，等待管理员审核']}！');location='manage.php';</script>";
                        } else {
                            echo "<script>alert('{$lang['操作失败']}！');location='manage.php';</script>";
                        }
                        
                    }

                 ?>

                </tbody>
            </table>
            <!-- 货架管理｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>