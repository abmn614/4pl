<?php 
session_start();
include('../class/config.inc.php');
include('../class/model.class.php');
include('../class/page.class.php');

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>入库审核</title>
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
                <li><a href="#">库存管理</a><span class="divider"> / </span></li>
                <li>入库审核</li>
            </ul>
            <!-- 面包屑｝ -->

 

            <!-- 产品入库列表｛ -->
            <table class="table table-default table-hover table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>快递 / 单号</th>
                        <th>时间</th>
                        <th>说明</th>
                        <th>产品和数量 / 货架货位</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $in = M('stockin');

                        // 此处用先用到了page类的参数，所以要先实例化
                        $page = new Page($in->where("checked=1")->count(),5,5);

                        $in_info = $in->where("checked=1")->limit("{$page->offset},{$page->length}")->field('*')->select();

                        $user = M('user');
                        $shelf = M('shelf');
                        $storage = M('storage');

                        $product = M('product');
                        if ($in_info) {
                            foreach ($in_info as $rows) {
                                echo "
                                    <tr>
                                    <form action='incheck.php' id='form_{$rows['id']}' method='post'>
                                        <td>{$rows['id']}</td>
                                ";
                                $username = $user->where("id={$rows['uid']}")->find();
                                echo "
                                        <td>{$username['username']}</td>
                                        <td>{$rows['express']}({$rows['expressid']})</td>
                                        <td>{$rows['time']}</td>
                                        <td><input type='text' id='extra_{$rows['id']}' name='extra' placeholder='输入描述'></td>
                                        <td>
                                ";

                                $pid_arr = explode(',', $rows['pid']);
                                $num_arr = explode(',', $rows['num']);
                                foreach ($pid_arr as $key => $value) {
                                    $product_name = $product->where("id={$value}")->find();
                                    // echo "
                                    //     <select name='pid[]' class='span6'>
                                    //         <option value='{$pid_arr[$key]}'>{$product_name['name']}({$num_arr[$key]})</option>
                                    //     </select>
                                    // ";
                                    echo "<input type='text' value='{$product_name['name']}({$num_arr[$key]})' readonly='readonly' class='span6' />
                                        <input type='hidden' name='pid[]' value='{$value}'>
                                        <input type='hidden' name='num[]' value='{$num_arr[$key]}'>
                                    ";
                                    echo "
                                                <select name='stid[]' class='span6'>
                                    ";
                                    $shelf_info = $shelf->where("uid={$rows['uid']} and checked=2")->field('distinct stid')->select();
                                    if ($shelf_info) {
                                        foreach ($shelf_info as $rows_shelf) {
                                            $storage_name = $storage->where("id={$rows_shelf['stid']}")->find();
                                            echo "
                                                <option value='{$rows_shelf['stid']}'>{$storage_name['name']}</option>
                                            ";
                                        }
                                    } else {
                                        echo "<option value=''>该用户尚无可用货架</option>";
                                    }
                                    
                                    echo "</select><br>";
                                    // echo "
                                    //             <select name='slot[]' class='span4'>
                                    //                 <option value=''>货位</option>
                                    //                  <option value='1'>1</option>
                                    //                  <option value='2'>2</option>
                                    //                  <option value='3'>3</option>
                                    //                  <option value='4'>4</option>
                                    //                  <option value='5'>5</option>
                                    //                  <option value='6'>6</option>
                                    //                  <option value='7'>7</option>
                                    //                  <option value='8'>8</option>
                                    //                  <option value='9'>9</option>
                                    //                  <option value='10'>10</option>
                                    //                  <option value='11'>11</option>
                                    //                  <option value='12'>12</option>
                                    //             </select>
                                    //             <br>
                                    //     ";
                                    }


                                    echo "
                                        </td>
                                        <td>
                                            <input type='hidden' name='id' value='{$rows['id']}'>
                                            <input type='hidden' name='username' value='{$username['username']}'>
                                            <input type='submit' name='submit' value='通过' class='btn btn-primary'>
                                            <a href='#' id='{$rows['id']}' onclick='getme(this)' user='{$username['username']}' role='button' class='btn btn-danger' data-toggle='modal' data-target='#myModal'>拒绝</a>
                                        </td>
                                    </form>
                                    </tr>
                                    
                                ";
                            }
                        } else {
                            echo "<td colspan='9'>没有需要审核入库的产品！</td>";
                        }


                        // 处理审核
                        if ($_GET['action'] == 'pass_no') { // 审核不通过，状态为3
                            $update['checked'] = 3;
                            $update['extra'] = $_POST['reason'];
                            if ($in->where("id={$_POST['id']}")->update($update)) {
                                //写入日志
                                $log = M('log');
                                $insert_log['uid'] = $_SESSION['userid'];
                                $insert_log['event'] = "产品入库-审核不通过";
                                $insert_log['content'] = "{$_SESSION['username']}拒绝了 {$_POST['username']} 的产品入库请求<br>拒绝理由：<br>{$_POST['reason']}<br>快递单号：{$rows['expressid']}";
                                $log->insert($insert_log);

                                echo "<script>alert('操作成功！已拒绝用户的入库请求！');location='incheck.php';</script>";
                            } else {
                                echo "<script>alert('操作失败！');location='incheck.php';</script>";
                            }
                        }

                        if ($_POST['submit']) { // 通过审核
                            if (!in_array('', $_POST['stid'])) { // 确保填写了货位信息
                                $id = $_POST['id'];
                                $update['extra'] = $_POST['extra'];
                                $update['stid'] = implode(',', $_POST['stid']);
                                // $update['slot'] = implode(',', $_POST['slot']);
                                $update['checked'] = 2;

                                if ($in->where("id={$id}")->update($update)) {

                                    // 更新产品表库存数
                                    foreach ($_POST['pid'] as $key_pid => $value_pid) {
                                        $product_num_pre = $product->where("id={$value_pid}")->find();
                                        $update_product['num'] = $product_num_pre['num'] + $_POST['num'][$key_pid];
                                        $product->where("id={$value_pid}")->update($update_product);
                                    }

                                    // 写入日志
                                    $log = M('log');
                                    $insert_log['uid'] = $_SESSION['userid'];
                                    $insert_log['event'] = "产品入库-审核通过";
                                    foreach ($update as $key => $value) {
                                        $content_log .= $key.' => '.$value.'<br>';
                                    }
                                    $stockin_log = $in->where("id={$id}")->find();
                                    $pid_arr_log = explode(',', $stockin_log['pid']);
                                    $num_arr_log = explode(',', $stockin_log['num']);
                                    $stid_arr_log = explode(',', $stockin_log['stid']);
                                    // for ($i=0; $i < count($pid_arr_log); $i++) { 
                                    foreach ($pid_arr_log as $key => $value) {
                                        $product_name_log = $product->where("id={$pid_arr_log[$key]}")->find();
                                        $storage_name_log = $storage->where("id={$stid_arr_log[$key]}")->find();
                                        $product_log .= "{$product_name_log['name']} => {$num_arr_log[$key]} ({$storage_name_log['name']})<br>";
                                    }
                                    
                                    $insert_log['content'] = "{$_SESSION['username']}通过了{$_POST['username']} 的产品入库：<br>{$content_log}<br>入库的产品：<br>{$product_log}";
                                    $log->insert($insert_log);

                                    echo "<script>alert('入库成功！');location='incheck.php';</script>";
                                } else {
                                    echo "<script>alert('入库失败！');</script>";
                                }
                                
                            }else {
                                echo "<script>alert('请选择货架！');</script>";
                            }
                        }
                     ?>

                </tbody>
            </table>
            <!-- 产品入库列表｝ -->

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

<!-- 模态框 -->
    <form action="incheck.php?action=pass_no" method="post">
        <div id="myModal" class="modal hide fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">拒绝通过的理由</h3>
            </div>
            <div class="modal-body">
                <textarea name="reason" cols="100" rows="2" class="span5"></textarea>
                <input type="hidden" name="id" id="myid">
                <input type="hidden" name="username" id="myusername">
                <script>
                    function getme(obj){
                        var myid = obj.id;
                        var myusername = obj.getAttribute('user');
                        document.getElementById("myid").value = myid;
                        document.getElementById("myusername").value = myusername;
                    }
                </script>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">确认</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
            </div>
        </div>
    </form>

<?php 
// 引入尾部
include('../footer.php');
 ?>
