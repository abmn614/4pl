<?php 
session_start();
echo "<pre>";
var_dump($_SESSION);
echo "<pre>";
print_r($lang);
echo "</pre>";
echo "</pre>";
if (!isset($_SESSION['username']) || $_SESSION['username'] == null) {
    echo "<script>alert('{$lang['请先登录']}！\\n点击确认跳转至登录页面！');location='../user/login.php'</script>";
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
                        <a href="../storage/index.php" class="dropdown-toggle" data-toggle="dropdown">仓库<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../storage/add.php">添加仓库</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../product/index.php" class="dropdown-toggle" data-toggle="dropdown">产品<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../product/addclass.php">添加大类</a></li>
                            <li><a href="../product/add.php">添加产品</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="shelf/index.php" class="../dropdown-toggle" data-toggle="dropdown">货架<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../shelf/manage.php">管理货架</a></li>
                            <li><a href="../shelf/buy.php">购买货架</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../store/index.php" class="dropdown-toggle" data-toggle="dropdown">库存<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../store/in.php">产品入库</a></li>
                            <li><a href="../store/out.php">产品出库</a></li>
                            <li><a href="../store/outlist.php">出库列表</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">管理员操作</li>
                            <li><a href="../store/incheck.php">入库审核</a></li>
                            <li><a href="../store/outcheck.php">出库审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../finance/index.php" class="dropdown-toggle" data-toggle="dropdown">财务<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="finance/in.php">账户充值</a></li>
                            <li><a href="finance/out.php">账户提现</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">管理员操作</li>
                            <li><a href="../finance/incheck.php">充值审核</a></li>
                            <li><a href="../finance/outcheck.php">提现审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="../user/index.php" class="dropdown-toggle" data-toggle="dropdown">用户<span class="caret"></span></a>
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
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$_SESSION['username']}<span class='caret'></span></a>
                                    <ul class='dropdown-menu' role='menu'>
                                        <li><a href='../user/alter.php?action=myself'>个人资料</a></li>
                                    </ul>
                                </li>
                                <li><a href='../user/logout.php?action=logout'>退出登录</a></li>
                            </ul>
                        ";
                    }else{
                        echo "
                            <ul class='nav pull-right'>
                                <li><a href='../user/login.php'>登录</a></li>
                            </ul>
                        ";
                    }
                 ?>
            </div>
        </div>
    </div>
</div>
