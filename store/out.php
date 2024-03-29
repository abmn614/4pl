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

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$lang['产品出库']?></title>
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
                <li><a href="index.php"><?=$lang['库存管理']?></a><span class="divider"> / </span></li>
                <li><?=$lang['产品出库']?></li>
            </ul>
            <!-- 面包屑｝ -->
            
            <!-- 提示信息｛ -->
            <div class="alert alert-block fade in hide">
                <h4></h4>
                <p class="alert-text"></p>
            </div>
            <!-- 提示信息｝-->

            <!-- 出库表单｛ -->
            <div class="container-fluid store">
                <form id="form_out" class="form-horizontal">
                    <h2><?=$lang['产品出库']?></h2>
                    <div>
                        <div class="span4">
                            <div class="control-group">
                                <label for="order" class="control-label"><?=$lang['订单号']?></label>
                                <div class="controls">
                                    <input type="text" id="order" name="orderid" placehoder="<?=$lang['订单号']?>" required autofocus>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="name" class="control-label"><?=$lang['姓名']?></label>
                                <div class="controls">
                                    <input type="text" id="name" name="name" placehoder="<?=$lang['姓名']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="nation" class="control-label"><?=$lang['国家']?></label>
                                <div class="controls">
                                    <input type="text" id="nation" name="nation" placehoder="<?=$lang['国家']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="state" class="control-label"><?=$lang['州/省']?></label>
                                <div class="controls">
                                    <input type="text" id="state" name="state" placehoder="<?=$lang['州/省']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="city" class="control-label"><?=$lang['城市']?></label>
                                <div class="controls">
                                    <input type="text" id="city" name="city" placehoder="<?=$lang['城市']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="adress" class="control-label"><?=$lang['地址']?></label>
                                <div class="controls">
                                    <input type="text" id="adress" name="adress" placehoder="<?=$lang['地址']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="zcode" class="control-label"><?=$lang['邮编']?></label>
                                <div class="controls">
                                    <input type="text" id="zcode" name="zcode" placehoder="<?=$lang['邮编']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="tel" class="control-label"><?=$lang['座机']?></label>
                                <div class="controls">
                                    <input type="text" id="tel" name="tel" placehoder="<?=$lang['座机']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="cellphone" class="control-label"><?=$lang['手机']?></label>
                                <div class="controls">
                                    <input type="text" id="cellphone" name="cellphone" placehoder="<?=$lang['手机']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="express" class="control-label"><?=$lang['物流方式']?></label>
                                <div class="controls">
                                    <input type="text" id="express" name="express" placehoder="<?=$lang['物流方式']?>" required>
                                </div>    
                            </div>
                            <div class="control-group">
                                <label for="expressid" class="control-label"><?=$lang['快递单号']?></label>
                                <div class="controls">
                                    <input type="text" id="expressid" name="expressid" placehoder="<?=$lang['快递单号']?>" required>
                                </div>    
                            </div>
                        </div>
                        <div class="span8" id="addcon">
                            <div class="store-bar">
                                <a href="javascript:;" id="submit" class="btn btn-primary pull-right"><?=$lang['出库']?></a>
                                <div class="btn-group">
                                    <a href="javascript:;" class="btn btn-primary" id="addbtn"><?=$lang['添加产品']?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- 出库表单｝ -->
        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
// 引入尾部
include('../footer.php');
 ?>

 <!-- 处理ajax -->
<script>
    $("#addbtn").click(function() {
        $.post('ajax_get.php?action=get_stockin', function(data) {
            // alert(data);
            $("#addcon").append(data);
        });
        
    });

    $("#submit").click(function() {
        var form_out_str = $("#form_out").serialize();
        $.post('ajax_get.php?action=submit_form_out', form_out_str, function(data) {
            alert(data);
            if (data.indexOf("成功") >= 0) {
                location.href="in.php";
            };
        });
        
    });

</script>