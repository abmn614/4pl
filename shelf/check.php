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
<title>审核货架</title>
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
                <li><a href="#">我的货架</a><span class="divider"> / </span></li>
                <li>审核货架</li>
            </ul>
            <!-- 面包屑｝ -->


            <!-- 审核货架｛ -->
            <form id="buy" action="buy.php" method="post">
                <table class="table table-default table-hover table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>仓库名</th>
                            <th>货架</th>
                            <th>用户行为</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                        $shelf = M('shelf');
                        $shelf_info = $shelf->where("checked in (3,4)")->field('*')->select();
                        if (!empty($shelf_info)) {
                            $storage = M('storage');
                            $user = M('user');
                            foreach ($shelf_info as $key => $value) {
                                $storage_info = $storage->where("id={$shelf_info[$key]['stid']}")->find();
                                $user_info = $user->where("id={$shelf_info[$key]['uid']}")->find();
                                echo "
                                    <tr>
                                        <td>{$shelf_info[$key]['id']}</td>
                                        <td>{$user_info['username']}</td>
                                        <td>{$storage_info['name']}</td>
                                        <td>{$shelf_info[$key]['shid']}</td>
                                    ";

                                if ($shelf_info[$key]['checked'] == 3) {
                                    echo "<td>购买</td>
                                        <td><a href='check.php?action=buy_shelf&id={$shelf_info[$key]['id']}&shid={$shelf_info[$key]['shid']}&stname={$storage_info['name']}&uname={$user_info['username']}' class='btn btn-primary'>通过</a>
                                            <a href='check.php?action=buy_shelf_no&id={$shelf_info[$key]['id']}&shid={$shelf_info[$key]['shid']}&stname={$storage_info['name']}&uname={$user_info['username']}' class='btn btn-danger'>不通过</a></td>
                                    ";
                                } elseif($shelf_info[$key]['checked'] == 4) {
                                    echo "<td>删除</td>
                                        <td><a href='check.php?action=del_shelf&id={$shelf_info[$key]['id']}&shid={$shelf_info[$key]['shid']}&stname={$storage_info['name']}&uname={$user_info['username']}'  class='btn btn-primary'>通过</a>
                                            <a href='check.php?action=del_shelf_no&id={$shelf_info[$key]['id']}&shid={$shelf_info[$key]['shid']}&stname={$storage_info['name']}&uname={$user_info['username']}'  class='btn btn-danger'>不通过</a></td>
                                    ";
                                }else{

                                }
                                
                                echo "                                        
                                    </tr>
                                ";
                            }
                        }else{
                            echo "<tr><td colspan='6'>暂无需要审核的货架</td></tr>";
                        }

                        // 处理点击通过的审核
                        if ($_GET['id']) {
                            if ($_GET['action'] == 'buy_shelf') { // 购买货架通过
                                $update['checked'] = 2;
                                if ($shelf->where("id={$_GET['id']}")->update($update)) {

                                    // 写入日志
                                    $log = M('log');
                                    $insert_log['uid'] = $_SESSION['userid'];
                                    $insert_log['event'] = "购买货架-审核通过";
                                    $insert_log['content'] = "{$_SESSION['username']}通过了{$_GET['uname']}的购买货架审核，购买的货架是：<br>{$_GET['stname']}：{$_GET['shid']}";
                                    $log->insert($insert_log);

                                    echo "<script>alert('操作成功！');location='check.php';</script>";
                                } else {
                                    echo "<script>alert('操作失败！');location='check.php';</script>";
                                }
                            } elseif($_GET['action'] == 'del_shelf') { // 删除货架通过
                                $update['uid'] = 0; 
                                $update['state'] = 1;
                                $update['checked'] = 1;
                                if ($shelf->where("id={$_GET['id']}")->update($update)) {

                                    // 写入日志
                                    $log = M('log');
                                    $insert_log['uid'] = $_SESSION['userid'];
                                    $insert_log['event'] = "删除货架-审核通过";
                                    $insert_log['content'] = "{$_SESSION['username']}通过了{$_GET['uname']}的删除货架审核，删除的货架是：<br>{$_GET['stname']}：{$_GET['shid']}";
                                    $log->insert($insert_log);

                                    echo "<script>alert('操作成功！');location='check.php';</script>";
                                } else {
                                    echo "<script>alert('操作失败！');location='check.php';</script>";
                                }
                            }elseif($_GET['action'] == 'buy_shelf_no'){ // 购买货架不通过

                                // 写入日志
                                $log = M('log');
                                $insert_log['uid'] = $_SESSION['userid'];
                                $insert_log['event'] = "购买货架-审核不通过";
                                $insert_log['content'] = "{$_SESSION['username']}没有通过{$_GET['uname']}的购买货架审核，购买的货架是：<br>{$_GET['stname']}：{$_GET['shid']}";
                                $log->insert($insert_log);

                                $update['uid'] = 0;
                                $update['state'] = 1;
                                $update['checked'] = 1;
                                if ($shelf->where("id={$_GET['id']}")->update($update)) {

                                    echo "<script>alert('操作成功！');location='check.php';</script>";
                                } else {
                                    echo "<script>alert('操作失败！');location='check.php';</script>";
                                }
                            }elseif($_GET['action'] == 'del_shelf_no'){ // 删除货架不通过

                                // 写入日志
                                $log = M('log');
                                $insert_log['uid'] = $_SESSION['userid'];
                                $insert_log['event'] = "删除货架-审核不通过";
                                $insert_log['content'] = "{$_SESSION['username']}没有通过{$_GET['uname']}的删除货架审核，删除的货架是：<br>{$_GET['stname']}：{$_GET['shid']}";
                                $log->insert($insert_log);

                                $update['checked'] = 2;
                                if ($shelf->where("id={$_GET['id']}")->update($update)) {

                                    echo "<script>alert('操作成功！');location='check.php';</script>";
                                } else {
                                    echo "<script>alert('操作失败！');location='check.php';</script>";
                                }
                            }
                        }
                     ?>
                    </tbody>
                </table>
            </form>

            <!-- 购买货架｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>