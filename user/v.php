<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>实名认证</title>
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
                <li><a href="#"><i class="icon-home"> </i> 首页</a><span class="divider"> / </span></li>
                <li><a href="#">用户管理</a><span class="divider"> / </span></li>
                <li>实名认证</li>
            </ul>
            <!-- 面包屑｝ -->

            <!-- 用户认证｛ -->
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn btn-primary" id="personal">个人认证</button>
                <button class="btn btn-primary" id="company">企业认证</button>
            </div>
            <div class="container reg">
                <form action="../upload/upload.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <h2>用户认证</h2>
                    <div class="control-group">
                        <label for="username" class="control-label">用户名</label>
                        <div class="controls">
                            <input type="text" id="username" name="uname" placeholder="请输入用户名" required autofocus>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="idcard" class="control-label">身份证</label>
                        <div class="controls">
                            <input type="text" id="idcard" name="idcard" placeholder="请输入身份证编号" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="idpic" class="control-label">身份证复印件</label>
                        <div class="controls">
                            <input type="file" id="idpic" name="idcard_copy">
                        </div>
                    </div>
                    <div class="control-group" id="submit">
                        <input type="submit" value="认证" class="btn btn-primary btn-large btn-block">
                    </div>
                </form>
            </div>
            <!-- 用户认证｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#personal").click(function() {
            $("#business_license").remove();
            
        });

        $("#company").click(function() {
            $text = "<div class='control-group' id='business_license'><label for='zhizhao' class='control-label'>营业执照</label><div class='controls'><input type='file' id='zhizhao' name='business_license'></div></div>";
            if ($("#business_license").length == 0) {
                $("#submit").before($text);
            }
        });
    });
</script>
</body>
</html>