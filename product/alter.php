<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>修改产品</title>
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
                <li><a href="#">我的产品</a><span class="divider"> / </span></li>
                <li>修改产品</li>
            </ul>
            <!-- 面包屑｝ -->
            
            <?php 
                $id = $_GET['id'];
                $product = M('product');
                $product_info = $product->where("id={$id}")->field('*')->select();
                $pclass = M('pclass');
                $pclass_info = $pclass->field('*')->select();

             ?>

            <!-- 修改产品｛ -->
            <div class="container reg">
                <form action="alter.php" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <h2>修改产品</h2>
                    <div class="control-group">
                        <label for="pclass" class="control-label">分类</label>
                        <div class="controls">
                            <select id="pclass" name="cid" required>

                                <?php 
                                    foreach ($pclass_info as $key => $value) {
                                        echo "<br><br><br><br>{$pclass_info[$key]['id']}";
                                        if ($pclass_info[$key]['id']==$product_info[0]['cid']) {
                                            echo "
                                                <option value='{$pclass_info[$key]['id']}' selected='selected'>{$pclass_info[$key]['name']}</option>
                                            ";
                                        } else {
                                            echo "
                                                <option value='{$pclass_info[$key]['id']}'>{$pclass_info[$key]['name']}</option>
                                            ";
                                        }
                                    }
                                 ?>
                            </select> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pname" class="control-label">产品名称</label>
                        <div class="controls">
                            <input type="text" id="pname" name="name" value="<?=$product_info[0]['name']?>" placeholder="请输入产品名称" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ppic" class="control-label">产品图片</label>
                        <div class="controls">
                            <input type="file" id="ppic" name="pic">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pweight" class="control-label">单重</label>
                        <div class="controls">
                            <input type="text" id="pweight" name="weight" value="<?=$product_info[0]['weight']?>" placeholder="请输入产品单重">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pprice" class="control-label">单价</label>
                        <div class="controls">
                            <input type="text" id="pprice" name="price" value="<?=$product_info[0]['price']?>" placeholder="请输入产品单价" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="psize" class="control-label">规格</label>
                        <div class="controls">
                            <input type="text" id="psize" name="size" value="<?=$product_info[0]['size']?>" placeholder="请输入产品规格">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pcolor" class="control-label">颜色</label>
                        <div class="controls">
                            <input type="text" id="pcolor" name="color" value="<?=$product_info[0]['color']?>" placeholder="请输入产品颜色">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ptop" class="control-label">上限</label>
                        <div class="controls">
                            <input type="text" id="ptop" name="max" value="<?=$product_info[0]['max']?>" placeholder="请输入产品存储上限" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pbottom" class="control-label">下限</label>
                        <div class="controls">
                            <input type="text" id="pbottom" name="min" value="<?=$product_info[0]['min']?>" placeholder="请输入产品存储下限" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pnote" class="control-label">备注</label>
                        <div class="controls">
                            <textarea id="pnote" rows="3" name="note" placeholder="请输入备注信息"><?=$product_info[0]['note']?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="submit" value="确认修改" name="submit" class="btn btn-primary btn-large btn-block">
                    </div>
                </form>
            </div>
            <!-- 修改产品｝ -->

            <?php 
                // 处理更新操作
                $update['name'] = $_POST['name'];
                $update['cid'] = $_POST['cid'];
                $update['weight'] = $_POST['weight'];
                $update['price'] = $_POST['price'];
                $update['size'] = $_POST['size'];
                $update['color'] = $_POST['color'];
                $update['max'] = $_POST['max'];
                $update['min'] = $_POST['min'];
                $update['note'] = $_POST['note'];

                if ($_POST['submit']) {

                    $file = $_FILES;
             
                    // 处理产品图片｛
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

                    if (in_array($fnameext, $acceptftype)) {
                        // 限制文件大小
                        if ($fsize <= 1024*1024) {
                            if (move_uploaded_file($tmpfname, $destination)) {
                                $update['pic'] = $destination;
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
                    // 处理产品图片｝

                    if ($product->where("id={$_POST['id']}")->update($update)) {

                        // 写入日志
                        $log = M('log');
                        $insert_log['uid'] = $_SESSION['userid'];
                        $insert_log['event'] = "修改产品";
                        foreach ($update as $key => $value) {
                            $content_log .= $key.' => '.$value.'<br>';
                        }
                        $insert_log['content'] = "{$_SESSION['username']}修改了产品：<br>{$content_log}";
                        $log->insert($insert_log);

                        echo "<script>alert('产品修改成功！');location='index.php';</script>";
                    } else {
                        // echo "<script>alert('产品修改失败！');history.back();</script>";
                               echo "<pre>";
                    print_r($_FILES);
                    print_r($update);
                    print_r($_POST);
                    echo "</pre>";
                    }
                    
                }

             ?>

        </div>
        <!-- 右侧内容｝ -->
    </div>
</div>
<!-- 主要内容｝ -->

<?php 
// 引入尾部
include('../footer.php');
 ?>