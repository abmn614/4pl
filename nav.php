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
?>
        <div class="span2">
            <div class="sidebar-menu">
                <a href="#" class="nav-header menu-first collapsed first-child" data-toggle="collapse" data-target="#user"><i class="icon-user"></i> 用户管理</a>
                <ul id="user" class="nav nav-list collapse menu-second">
                    <li class="selected"><a href="../user/index.php"><i class="icon-edit"></i> 用户列表</a></li>
                    <li><a href="../user/v.php"><i class="icon-ok"></i> 用户认证</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#cangku"><i class="icon-th-large"></i> 仓库管理</a>
                <ul id="cangku" class="nav nav-list collapse menu-second">
                    <li><a href="../storage/index.php"><i class="icon-th-list"></i> 仓库列表</a></li>
                    <li><a href="../storage/add.php"><i class="icon-plus"></i> 添加仓库</a></li>
                    <li><a href="../storage/alter.php"><i class="icon-edit"></i> 修改仓库</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#huojia"><i class="icon-th"></i> <?=$lang['我的货架']?></a>
                <ul id="huojia" class="nav nav-list collapse menu-second">
                    <li><a href="../shelf/index.php"><i class="icon-th-list"></i> <?=$lang['货架列表']?></a></li>
                    <li><a href="../shelf/manage.php"><i class="icon-wrench"></i> <?=$lang['管理货架']?></a></li>
                    <li><a href="../shelf/check.php"><i class="icon-ok-circle"></i> 审核货架</a></li>
                    <li><a href="../shelf/buy.php"><i class="icon-download-alt"></i> <?=$lang['购买货架']?></a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#product"><i class="icon-shopping-cart"></i> <?=$lang['我的产品']?></a>
                <ul id="product" class="nav nav-list collapse menu-second">
                    <li><a href="../product/index.php"><i class="icon-th-list"></i> <?=$lang['产品列表']?></a></li>
                    <li><a href="../product/add.php"><i class="icon-plus"></i> <?=$lang['添加产品']?></a></li>
                    <li><a href="../product/alter.php"><i class="icon-edit"></i> <?=$lang['修改产品']?></a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed" data-toggle="collapse" data-target="#kucun"><i class="icon-inbox"></i> <?=$lang['库存管理']?></a>
                <ul id="kucun" class="nav nav-list collapse menu-second">
                    <li><a href="../store/index.php"><i class="icon-th-list"></i> <?=$lang['库存列表']?></a></li>
                    <li><a href="../store/in.php"><i class="icon-circle-arrow-up"></i> <?=$lang['产品入库']?></a></li>
                    <li><a href="../store/incheck.php"><i class="icon-ok-circle"></i> 入库审核</a></li>
                    <li><a href="../store/outlist.php"><i class="icon-circle-arrow-up"></i> <?=$lang['出库列表']?></a></li>
                    <li><a href="../store/out.php"><i class="icon-circle-arrow-down"></i> <?=$lang['产品出库']?></a></li>
                    <li><a href="../store/outcheck.php"><i class="icon-ok-circle"></i> 出库审核</a></li>
                </ul>
                <a href="#" class="nav-header menu-first collapsed last-child" data-toggle="collapse" data-target="#caiwu"><i class="icon-star"></i> <?=$lang['财务管理']?></a>
                <ul id="caiwu" class="nav nav-list collapse menu-second">
                    <li><a href="../finance/index.php"><i class="icon-th-list"></i> <?=$lang['财务清单']?></a></li>
                    <li><a href="../finance/in.php"><i class="icon-plus"></i> <?=$lang['账户充值']?></a></li>
                    <li><a href="../finance/incheck.php"><i class="icon-ok-circle"></i> 充值审核</a></li>
                    <li><a href="../finance/out.php"><i class="icon-minus"></i> <?=$lang['账户提现']?></a></li>
                    <li><a href="../finance/outcheck.php"><i class="icon-ok-circle"></i> 提现审核</a></li>
                </ul>
            </div>

        </div>