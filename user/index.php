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



if ($_SESSION['role'] != 1) { // 不是管理员
    echo "<script>alert('{$lang['当前用户非管理员']}！');location='login.php';</script>";
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>用户管理</title>
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
                <li><a href="../index.php"><i class="icon-home"> </i> 首页</a><span class="divider"> / </span></li>
                <li>用户管理</li>
            </ul>
            <!-- 面包屑｝ -->

            <!-- 用户信息｛ -->

            <?php 
            $user = M('user');
            $tot = $user->count();
            $personal = $user->where("type=1")->count();
            $company = $user->where("type=2")->count();
            $personal_v = $user->where("type=1 and v=1")->count();
            $company_v = $user->where("type=2 and v=2")->count();
            
             ?>

            <p>注册用户：<?=$tot?> 个人用户：<?=$personal?>（<?=$personal_v?>已认证） 企业用户：<?=$company?>（<?=$company_v?>已认证）</p>
            <!-- 用户信息｝ -->

            <!-- 用户列表｛ -->
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>类型</th>
                        <th>座机</th>
                        <th>手机</th>
                        <th>QQ</th>
                        <th>邮箱</th>
                        <th>地址</th>
                        <th>发货人</th>
                        <th>发货人职位</th>
                        <th>身份证</th>
                        <th>复印件</th>
                        <th>营业执照</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                // 此处用先用到了page类的参数，所以要先实例化
                $page = new Page($tot,5,5);

                $user_info = $user->field('*')->where("id>0")->limit("{$page->offset},{$page->length}")->select(); // 指定id>0是为了覆盖上面的where type = 2 and v = 2
                foreach ($user_info as $rows) {
                    echo "
                        <tr>
                            <td>{$rows['id']}</td>
                            <td>{$rows['username']}</td>
                        ";
                    switch ($rows['type']) {
                        case '1':
                            if ($rows['v'] == 1) {
                                echo "<td><i class='icon-ok-sign'></i>个人</td>";
                            } else {
                                echo "<td>个人</td>";
                            }
                            break;

                        case '2':
                            if ($rows['v'] == 2) {
                                echo "<td><i class='icon-ok-circle'></i>企业</td>";
                            } else {
                                echo "<td>个人</td>";
                            }
                        break;
                        
                        default:
                            echo "<td>不详</td>";
                            break;
                    }
                    
                    echo "
                            <td>{$rows['tel']}</td>
                            <td>{$rows['cellphone']}</td>
                            <td>{$rows['qq']}</td>
                            <td>{$rows['email']}</td>
                            <td>{$rows['adress']}</td>
                            <td>{$rows['shipper']}</td>
                            <td>{$rows['shipper_title']}</td>
                            <td>{$rows['idcard']}</td>
                            <td>{$rows['idcard_copy']}</td>
                            <td>{$rows['business_license']}</td>
                            <td><a href='#' class='btn btn-primary'>查看</a> <a href='alter.php?action=user&userid={$rows['id']}' class='btn btn-primary'>修改</a> <a href='del.php?userid={$rows['id']}' class='btn btn-primary'>删除</a></td>
                        </tr>
                    ";
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