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

header("content-type:text/html;charset=utf8");
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');

$update['uid'] = $_SESSION['userid'];
$storage_id = $_POST['stid'];
$update['state'] = 2;
$update['checked'] = 3;
$shelf_arr = array();
$shelf_arr = $_POST['shelf'];

$shelf = M('shelf');

if ($shelf_arr) {
    $shelf_selected = implode(",", $shelf_arr);
    if (isset($_POST['submit'])) {
        if ($shelf->where("stid={$storage_id} and shid in ({$shelf_selected})")->update($update)) {

            // 写入日志
            $log = M('log');
            $insert_log['uid'] = $_SESSION['userid'];
            $insert_log['event'] = "购买货架-进入审核";
            $storage = M('storage');
            $storage_name = $storage->where("id={$_POST['stid']}")->field('name')->select();
            $shelf_num = count($shelf_arr);
            $content_log = "购买了 {$shelf_num} 个货架：<br>{$storage_name[0]['name']}：{$shelf_selected}";
            $insert_log['content'] = "{$_SESSION['username']}{$content_log}<br>已进入审核";
            $log->insert($insert_log);

            echo "<script>alert('{$lang['']}操作成功！请通知管理员审核！');</script>";
        } else {
            echo "<script>alert('{$lang['']}操作失败！');</script>";
        }
    }
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$lang['购买货架']?></title>
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
                <li><a href="index.php"><?=$lang['我的货架']?></a><span class="divider"> / </span></li>
                <li><?=$lang['购买货架']?></li>
            </ul>
            <!-- 面包屑｝ -->

<?php 
$storage = M('storage');
$storage_info = $storage->field('*')->select();

 ?>

            <!-- 购买货架｛ -->
            <form id="buy" action="buy.php" method="post">
            <div class="btn-group">
                <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><?=$lang['选择仓库']?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    
                <?php 
                    foreach ($storage_info as $key => $value) {
                        echo "
                            <li><a href='buy.php?stid={$storage_info[$key]['id']}'>{$storage_info[$key]['name']} ({$storage_info[$key]['shelf']})</a></li>
                        ";
                    }

                 ?>

                </ul>
            </div>
                <!-- <select name="storage" onChange="document.getElementById('buy').submit()">
                
                </select> -->
                <br><br>
                
                <?php 
                    if (empty($_GET['stid'])) { // 默认是广州仓库
                        $storage_first = $storage->find();
                        $stid = $storage_first['id'];
                        $shid_arr = $shelf->where("stid={$stid} and (state=1 or state is NULL)")->field('shid')->select();
                    } else {
                        $stid = $_GET['stid'];
                        $shid_arr = $shelf->where("stid={$stid} and (state=1 or state is NULL)")->field('shid')->select();
                    }
                    $storage_select = $storage->where("id={$stid}")->field('name')->select();
                    echo "
                        <p><span class='label label-warning'>{$storage_select[0]['name']}</span> {$lang['可选货架']}：<span class='label label-info'>{$lang['为了方便您管理，建议从前往后选择连续的货架。']}</span></p>
                    ";
                    if (!empty($shid_arr)) {
                        foreach ($shid_arr as $key => $value) {
                            echo "
                                <label class='checkbox inline'><input type='checkbox' name='shelf[]' value='{$shid_arr[$key]['shid']}'>{$shid_arr[$key]['shid']}</label>
                            ";
                        }
                    }else{
                        echo "{$lang['没有记录']}！";
                    }
                    

                 ?>

                <input type="hidden" name="stid" value="<?=$stid?>">
                <br><br>
                <input type="submit" name="submit" value="<?=$lang['确认购买']?>" class="btn btn-primary">
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