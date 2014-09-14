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
<title><?=$lang['添加产品']?></title>
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
                <li><a href="index.php"><?=$lang['我的产品']?></a><span class="divider"> / </span></li>
                <li><?=$lang['添加产品']?></li>
            </ul>
            <!-- 面包屑｝ -->

            <?php 
                $insert['uid'] = $_SESSION['userid'];
                $insert['cid'] = $_POST['class'];
                $insert['name'] = $_POST['name'];
                $insert['weight'] = $_POST['weight'];
                $insert['price'] = $_POST['price'];
                $insert['size'] = $_POST['size'];
                $insert['color'] = $_POST['color'];
                $insert['max'] = $_POST['max'];
                $insert['min'] = $_POST['min'];
                $insert['note'] = $_POST['note'];
                // 产品ID截取时间戳
                $insert['pid'] = time();

                // 处理产品图片｛
                $file = $_FILES;
                // 取文件名
                $fname = $file['pic']['name'];

                $fnamearr = explode('.', $fname); // 按.分割文件名
                $fnameext = array_pop($fnamearr); // 弹出最后一个，并保存

                // 取文件类型
                $fmime = $file['pic']['type']; // 取mime类型
                $fmimearr = explode('/', $fmime); // 按/分割mime
                $ftype = $fmimearr[0]; // 取出类型的文本

                // 设置目录
                if ($ftype == 'image') {
                    $destination = '../upload/images/'.time().'.'.$fnameext;
                } else {
                    $destination = '../upload/files/'.time().'.'.$fnameext;
                }

                // 取临时文件路径
                $tmpfname = $file['pic']['tmp_name'];

                // 把临时文件移动到目标目录

                // 限制文件类型
                $acceptftype = array('jpg','png','gif','rar','zip');
                $fsize = $file['pic']['size'];

                if ($fnameext) {
                    if ($fnameext && in_array($fnameext, $acceptftype)) {
                        // 限制文件大小
                        if ($fsize <= 1024*1024) {
                            if (move_uploaded_file($tmpfname, $destination)) {
                                $insert['pic'] = $destination;
                            } else {
                               echo "图片上传失败";
                            }
                        } else {
                           echo "图片文件大小为 ".ceil($fsize/1024)."KB<br />"; 
                           echo "超出限制，最大只能上传 1024KB";
                        }
                    } else {
                        echo "没有选择文件，或者不支持后缀是 {$fnameext} 的文件类型";
                    }
                }
                
                // 处理产品图片｝

                $product = M('product');
                if ($_POST['submit']) {
                    if ($product->insert($insert)) {

                        // 写入日志
                        $log = M('log');
                        $insert_log['uid'] = $_SESSION['userid'];
                        $insert_log['event'] = "添加产品";
                        foreach ($insert as $key => $value) {
                            $content_log .= $key.' => '.$value.'<br>';
                        }
                        $insert_log['content'] = "{$_SESSION['username']}添加了产品：<br>{$content_log}";
                        $log->insert($insert_log);

                        echo "<script>alert('{$lang['添加成功']}！');</script>";
                    } else {
                        echo "<script>alert('{$lang['添加失败']}！');location='index.php';</script>";
                    }
                    
                }

             ?>

            <!-- 添加产品｛ -->
            <div class="container reg">
                <form action="add.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <h2><?=$lang['添加产品']?></h2>
                    <div class="control-group">
                        <label for="pclass" class="control-label"><?=$lang['产品分类']?></label>
                        <div class="controls">
                            <select id="pclass" name="class">
                                <?php 
                                    $pclass = M('pclass');
                                    $pclass_info = $pclass->field('*')->select();
                                    foreach ($pclass_info as $rows) {
                                        echo "
                                            <option value='{$rows['id']}'>{$rows['name']}</option>
                                        ";
                                    }
                                 ?>

                            </select> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pname" class="control-label"><?=$lang['产品名称']?></label>
                        <div class="controls">
                            <input type="text" id="pname" name="name" placeholder="<?=$lang['产品名称']?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ppic" class="control-label"><?=$lang['产品图片']?></label>
                        <div class="controls">
                            <input type="file" id="ppic" name="pic" required>
                        </div>
                    </div>
                    <div class="control-group input-append">
                        <label for="pweight" class="control-label"><?=$lang['单重']?></label>
                        <div class="controls">
                            <input class="span12" type="text" id="pweight" name="weight" placeholder="<?=$lang['单重']?>">
                            <span class="add-on">kg</span>
                        </div>
                    </div>
                    <div class="control-group input-append">
                        <label for="pprice" class="control-label"><?=$lang['单价']?></label>
                        <div class="controls">
                            <input class="span12" type="text" id="pprice" name="price" placeholder="<?=$lang['单价']?>" required>
                            <span class="add-on">￥</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="psize" class="control-label"><?=$lang['规格']?></label>
                        <div class="controls">
                            <input type="text" id="psize" name="size" placeholder="<?=$lang['规格']?>">
                            <p class="text-info"><?=$lang['一般衣服填S/M/L/XL/XXL等，鞋子填码数即可，其他产品视情况填写']?></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pcolor" class="control-label"><?=$lang['颜色']?></label>
                        <div class="controls">
                            <input type="text" id="pcolor" name="color" placeholder="<?=$lang['颜色']?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ptop" class="control-label"><?=$lang['上限']?></label>
                        <div class="controls">
                            <input type="text" id="ptop" name="max" placeholder="<?=$lang['上限']?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pbottom" class="control-label"><?=$lang['下限']?></label>
                        <div class="controls">
                            <input type="text" id="pbottom" name="min" placeholder="<?=$lang['下限']?>" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pnote" class="control-label"><?=$lang['备注']?></label>
                        <div class="controls">
                            <textarea id="pnote" rows="3" name="note" placeholder="<?=$lang['备注']?>"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <input type="submit" value="<?=$lang['添加产品']?>" name="submit" class="btn btn-primary btn-large btn-block">
                    </div>
                </form>
            </div>
            <!-- 添加产品｝ -->

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
// 引入尾部
include('../footer.php');
 ?>