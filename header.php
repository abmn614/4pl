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

if (!isset($_SESSION['username']) || $_SESSION['username'] == null) {
    echo "<script>alert(\"".$lang['请先登录']."\\n".$lang['点击确认跳转至登录页面']."\");location=\"../user/login.php\"</script>";
}
 ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="brand">第四方仓储管理系统</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"><a href="../index.php"><?=$lang['首页']?></a></li>
                    <li class="dropdown">
                        <a href="../storage/index.php" class="dropdown-toggle" data-toggle="dropdown">仓库管理<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../storage/add.php">添加仓库</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../product/index.php" class="dropdown-toggle" data-toggle="dropdown"><?=$lang['我的产品']?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../product/addclass.php">添加大类</a></li>
                            <li><a href="../product/add.php"><?=$lang['添加产品']?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="shelf/index.php" class="../dropdown-toggle" data-toggle="dropdown"><?=$lang['我的货架']?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../shelf/manage.php"><?=$lang['管理货架']?></a></li>
                            <li><a href="../shelf/buy.php"><?=$lang['购买货架']?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../store/index.php" class="dropdown-toggle" data-toggle="dropdown"><?=$lang['库存管理']?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../store/in.php"><?=$lang['产品入库']?></a></li>
                            <li><a href="../store/out.php"><?=$lang['产品出库']?></a></li>
                            <li><a href="../store/outlist.php"><?=$lang['出库列表']?></a></li>
                            <li class="divider"></li>
                            <li class="nav-header">管理员操作</li>
                            <li><a href="../store/incheck.php">入库审核</a></li>
                            <li><a href="../store/outcheck.php">出库审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../finance/index.php" class="dropdown-toggle" data-toggle="dropdown"><?=$lang['财务管理']?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="finance/in.php"><?=$lang['账户充值']?></a></li>
                            <li><a href="finance/out.php"><?=$lang['账户提现']?></a></li>
                            <li class="divider"></li>
                            <li class="nav-header"><?=$lang['']?>管理员操作</li>
                            <li><a href="../finance/incheck.php">充值审核</a></li>
                            <li><a href="../finance/outcheck.php">提现审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../user/index.php" class="dropdown-toggle" data-toggle="dropdown">用户管理<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../user/v.php">实名认证</a></li>
                        </ul>
                    </li>
                </ul>
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo "
                            <ul class='nav pull-right'>
                                <li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$lang['语言']}<span class='caret'></span></a>
                                    <ul class='dropdown-menu' role='menu'>
                                        <li><a href='?lang=zh-cn'>中文</a></li>
                                        <li><a href='?lang=en'>English</a></li>
                                    </ul>
                                </li>
                                <li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$_SESSION['username']}<span class='caret'></span></a>
                                    <ul class='dropdown-menu' role='menu'>
                                        <li><a href='../user/alter.php?action=myself'>{$lang['个人资料']}</a></li>
                                    </ul>
                                </li>
                                <li><a href='../user/logout.php?action=logout'>{$lang['退出登录']}</a></li>
                            </ul>
                        ";
                    }else{
                        echo "
                            <ul class='nav pull-right'>
                                <li><a href='../user/login.php'>{$lang['登录']}</a></li>
                            </ul>
                        ";
                    }
                 ?>
            </div>
        </div>
    </div>
</div>
