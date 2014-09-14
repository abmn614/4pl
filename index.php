<?php 
session_start();
// 判断网站语言
if (!isset($_SESSION['lang'])) {
    if ($_GET['lang']) {
        $_SESSION['lang'] = $_GET['lang'];
    } else {
        $_SESSION['lang'] = 'zh-cn';
    }
} 
include("lang/lang.php");

 ?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<title>首页</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="css/style.css">
<!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
<![endif]-->
</head>
<body>

<!-- 头部导航条｛ -->
<?php 
if (!isset($_SESSION['username'])) {
    echo "<br>";
    echo "<br>";
    // echo '<script>alert("'.$lang['请先登录'].$lang['点击确认跳转至登录页面'].'");location="user/login.php"</script>';
    echo "<script>alert(\"".$lang['请先登录']."\\n".$lang['点击确认跳转至登录页面']."\");location=\"user/login.php\"</script>";
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
                    <li class="active"><a href="index.php">首页</a></li>
                    <li class="dropdown">
                        <a href="storage/index.php" class="dropdown-toggle" data-toggle="dropdown">仓库<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="storage/add.php">添加仓库</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="product/index.php" class="dropdown-toggle" data-toggle="dropdown">产品<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="product/addclass.php">添加大类</a></li>
                            <li><a href="product/add.php">添加产品</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="shelf/index.php" class="dropdown-toggle" data-toggle="dropdown">货架<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="shelf/manage.php">管理货架</a></li>
                            <li><a href="shelf/buy.php">购买货架</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="store/index.php" class="dropdown-toggle" data-toggle="dropdown">库存<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="store/in.php">产品入库</a></li>
                            <li><a href="store/out.php">产品出库</a></li>
                            <li><a href="store/outlist.php">出库列表</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">管理员操作</li>
                            <li><a href="store/incheck.php">入库审核</a></li>
                            <li><a href="store/outcheck.php">出库审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="finance/index.php" class="dropdown-toggle" data-toggle="dropdown">财务<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="finance/in.php">账户充值</a></li>
                            <li><a href="finance/out.php">账户提现</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">管理员操作</li>
                            <li><a href="finance/incheck.php">充值审核</a></li>
                            <li><a href="finance/outcheck.php">提现审核</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="user/index.php" class="dropdown-toggle" data-toggle="dropdown">用户<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="user/v.php">实名认证</a></li>
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
                                        <li><a href='user/alter.php?action=myself'>个人资料</a></li>
                                    </ul>
                                </li>
                                <li><a href='user/logout.php?action=logout'>退出登录</a></li>
                            </ul>
                        ";
                    }else{
                        echo "
                            <ul class='nav pull-right'>
                                <li><a href='user/login.php'>登录</a></li>
                            </ul>
                        ";
                    }
                 ?>
            </div>
        </div>
    </div>
</div>

<!-- 头部导航条｝ -->
    
<!-- 主要内容｛ -->
<div class="container-fluid">
    <div class="row-fluid">
        <!-- 左侧导航菜单｛ -->
        <div class="span2">
            <div class="sidebar-menu">
                <a href="#" class="nav-header menu-first collapsed first-child" data-toggle="collapse" data-target="#user"><i class="icon-user"></i> 用户管理</a>
                <ul id="user" class="nav nav-list collapse menu-second">
                    <li class="selected"><a href="user/index.php"><i class="icon-edit"></i> 用户列表</a></li>
                    <li><a href="user/v.php"><i class="icon-ok"></i> 用户认证</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#cangku"><i class="icon-th-large"></i> 仓库管理</a>
                <ul id="cangku" class="nav nav-list collapse menu-second">
                    <li><a href="storage/index.php"><i class="icon-plus"></i> 仓库列表</a></li>
                    <li><a href="storage/add.php"><i class="icon-plus"></i> 添加仓库</a></li>
                    <li><a href="storage/alter.php"><i class="icon-edit"></i> 修改仓库</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#huojia"><i class="icon-th"></i> 我的货架</a>
                <ul id="huojia" class="nav nav-list collapse menu-second">
                    <li><a href="shelf/index.php"><i class="icon-th-list"></i> 货架列表</a></li>
                    <li><a href="shelf/manage.php"><i class="icon-th-list"></i> 管理货架</a></li>
                    <li><a href="shelf/buy.php"><i class="icon-download-alt"></i> 购买货架</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#product"><i class="icon-shopping-cart"></i> 我的产品</a>
                <ul id="product" class="nav nav-list collapse menu-second">
                    <li><a href="product/index.php"><i class="icon-plus"></i> 产品列表</a></li>
                    <li><a href="product/add.php"><i class="icon-plus"></i> 添加产品</a></li>
                    <li><a href="product/alter.php"><i class="icon-edit"></i> 修改产品</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#kucun"><i class="icon-inbox"></i> 库存管理</a>
                <ul id="kucun" class="nav nav-list collapse menu-second">
                    <li><a href="store/index.php"><i class="icon-circle-arrow-up"></i> 库存列表</a></li>
                    <li><a href="store/in.php"><i class="icon-circle-arrow-up"></i> 产品入库</a></li>
                    <li><a href="store/incheck.php"><i class="icon-ok-circle"></i> 入库审核</a></li>
                    <li><a href="store/outlist.php"><i class="icon-circle-arrow-up"></i> 出库列表</a></li>
                    <li><a href="store/out.php"><i class="icon-circle-arrow-down"></i> 产品出库</a></li>
                    <li><a href="store/outcheck.php"><i class="icon-ok-circle"></i> 出库审核</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed last-child" data-toggle="collapse" data-target="#caiwu"><i class="icon-star"></i> 财务管理</a>
                <ul id="caiwu" class="nav nav-list collapse menu-second">
                    <li><a href="finance/index.php"><i class="icon-plus"></i> 财务清单</a></li>
                    <li><a href="finance/in.php"><i class="icon-plus"></i> 账户充值</a></li>
                    <li><a href="finance/incheck.php"><i class="icon-ok-circle"></i> 充值审核</a></li>
                    <li><a href="finance/out.php"><i class="icon-minus"></i> 账户提现</a></li>
                    <li><a href="finance/outcheck.php"><i class="icon-ok-circle"></i> 提现审核</a></li>
                </ul>
            </div>
        </div>

        <!-- 左侧导航菜单｝ -->
        <!-- 右侧内容｛ -->
        <div class="span10 pull-right right">
            <!-- 面包屑｛ -->
            <ul class="breadcrumb clearfix">
                <li><a href="#"><i class="icon-home"> </i> 首页</a><span class="divider">/</span></li>
                <li><a href="#">一级菜单</a><span class="divider">/</span></li>
                <li>二级菜单</li>
            </ul>
            <!-- 面包屑｝ -->
            <!-- 面板1｛ -->
            <div class="span6 panel panel-default" style="margin: 0;">
                <div class="panel-heading">财务中心</div>
                <div class="panel-body">
                    <p class="clearfix">账户余额：<span class="text-info">1000</span>元
                        <span class="pull-right">
                            <a href="#" class="btn btn-primary">充值</a>
                            <a href="#" class="btn btn-primary">提现</a>
                        </span>
                    </p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>时间</th>
                                <th>内容</th>
                                <th>操作人</th>
                                <th>费用</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2014.6.30</td>
                                <td>打包费</td>
                                <td>管理员</td>
                                <td class="text-error">-50</td>
                            </tr>
                            <tr>
                                <td>2014.6.30</td>
                                <td>充值</td>
                                <td>管理员</td>
                                <td class="text-success">1000</td>
                            </tr>
                            <tr>
                                <td>2014.6.30</td>
                                <td>运费退款</td>
                                <td>管理员</td>
                                <td class="text-success">20</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 面板1｝ -->
            <!-- 面板2｛ -->
            <div class="span6 panel panel-default">
                <div class="panel-heading">我的产品</div>
                <div class="panel-body">
                    <p class="clearfix">库存总数：<span class="text-info">100</span> （<span class="text-error">1000</span>）元
                        <span class="pull-right">
                            <a href="#" class="btn btn-primary">添加产品</a>
                        </span>
                    </p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>时间</th>
                                <th>操作</th>
                                <th>入库</th>
                                <th>出库</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2014.6.30</td>
                                <td>入库</td>
                                <td class="text-success">10</td>
                                <td class="text-success">100</td>
                            </tr>
                            <tr>
                                <td>2014.6.30</td>
                                <td>出库</td>
                                <td class="text-error">-100</td>
                                <td class="text-error">-1000</td>
                            </tr>
                            <tr>
                                <td>2014.6.30</td>
                                <td>出库</td>
                                <td class="text-error">-150</td>
                                <td class="text-error">-1500</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 面板2｝ -->
            <!-- 面板3｛ -->
            <div class="span6 panel panel-default" style="margin: 0;">
                <div class="panel-heading">我的货架</div>
                <div class="panel-body">
                    <p><span class="span6">货架总数：5</span><span class="span6">货位总数：60</span></p>
                    <p><span class="span6">已用货架：2</span><span class="span6">已用货位：15</span></p>
                    <p><span class="span6">剩余货架：3</span><span class="span6">剩余货位：45 （<strong class="text-success">充足</strong>）</span></p>
                    <p>货架编号：</p>
                    <p>001、002、003、004</p>
                </div>
            </div>
            <!-- 面板3｝ -->
            <!-- 面板4｛ -->
            <div class="span6 panel panel-default">
                <div class="panel-heading">新闻中心</div>
                <div class="panel-body">
                    <p><span class="pull-right">2014.6.30</span><a href="#">新闻标题链接1</a></p>
                    <p><span class="pull-right">2014.6.30</span><a href="#">新闻标题链接2</a></p>
                    <p><span class="pull-right">2014.6.30</span><a href="#">新闻标题链接3</a></p>
                    <p><span class="pull-right">2014.6.30</span><a href="#">新闻标题链接4</a></p>
                    <p><span class="pull-right">2014.6.30</span><a href="#">新闻标题链接5</a></p>
                </div>
            </div>
            <!-- 面板4｝ -->
        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>