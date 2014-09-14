<?php 
include('../class/config.inc.php');
include('../class/model.class.php');
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

$product = M('product');
$pclass = M('pclass');
$in = M('stockin');
$out = M('stockout');

switch ($_GET['action']) {
    // 产品入库-添加产品
    case 'get_product':
        echo "
            <div class='store-list'>
                <select name='pid[]' class='span7' required>
                    <option value=''>{$lang['选择产品']}</option>
        ";
        $product_info = $product->order('cid')->field('*')->select();
        foreach ($product_info as $rows) {
            $cid = $rows['cid'];
            $pclass_info = $pclass->where("id={$cid}")->find();
            echo "
                <option value='{$rows['id']}'>{$pclass_info['name']}---{$rows['name']}---({$rows['pid']})</option>
            ";
        }
        echo "
                </select>
                <input type='text' name='num[]' placeholder='{$lang['数量']}' required>
                <a href='' class='btn btn-primary' data-dismiss='alert'>&times;</a>
            </div>
        ";

        break;

    // 产品入库-提交表单
    case 'submit_form_in':
        if ($_POST['pid']) {
            if (is_array($_POST['pid'])) { // 判断是否添加了产品就提交
                $pid_null = in_array('', $_POST['pid']);
                $num_null = in_array('', $_POST['num']);
            } else {
                echo "{$lang['请先添加产品']}！\n";
            }
            
            if (in_array('', $_POST) || $pid_null || $num_null) {
                echo "{$lang['请检查是否有还项目没有填写']}！";
            } else {
                // 检测是否重复选择了产品
                $pid_count = array_count_values($_POST['pid']);
                foreach ($pid_count as $key => $value) {
                    if ($pid_count[$key] > 1) { // 重复选择了产品
                        $product_name = $product->where("id={$key}")->find();
                        echo "【{$product_name['name']}】{$lang['重复选择了']}【{$pid_count[$key]}】{$lang['次']}！\n";
                        $once[] = false;
                    } else { // 保证每个产品只选择一次
                        $once[] = true;
                    }
                }

                if (!in_array(false, $once)) { // 在确保每个产品只选一次的情况下执行
                    $tot = count($_POST['pid']);
                    $in = M('stockin');
                    $insert['uid'] = $_SESSION['userid'];
                    $insert['express'] = $_POST['express'];
                    $insert['expressid'] = $_POST['expressid'];
                    $insert['pid'] = implode(',', $_POST['pid']); // 这里是产品表里的ID，不是产品id
                    $insert['num'] = implode(',', $_POST['num']);
                    $insert['checked'] = 1; // 未审核

                    if ($in->insert($insert)) { // 插入入库表


                        // 写入日志
                        $log = M('log');
                        $insert_log['uid'] = $_SESSION['userid'];
                        $insert_log['event'] = "产品入库-进入审核";
                        foreach ($insert as $key => $value) {
                            $content_log .= $key.' => '.$value.'<br>';
                        }
                        for ($i=0; $i < count($_POST['pid']); $i++) { 
                            $product_in_info = $product->where("id={$_POST['pid'][$i]}")->find();
                            $product_in .= $product_in_info['name'].' => '.$_POST['num'][$i].'<br>';
                        }
                        $insert_log['content'] = "{$_SESSION['username']}入库了产品：<br>{$content_log}<br>入库的产品和数量分别是：<br>{$product_in}";
                        $log->insert($insert_log);

                        echo "{$lang['操作成功，等待管理员审核']}！";
                    } else {
                        echo "{$lang['操作失败']}！";
                    }
                }
            }
        }else{
            echo "{$lang['请先选择产品']}";
        }
            
        break;

    // 产品出库-获得库存
    case 'get_stockin':
        echo "
            <div class='store-list'>
                <select name='pid[]' class='span7' required>
                    <option value=''>{$lang['选择产品']}</option>
        ";

        // 计算每个用户每个产品的存货数量｛
        $userid = $_SESSION['userid'];
        $in_info = $in->where("uid={$userid} and checked=2")->field('pid,num')->select();
        if ($in_info) {
            foreach ($in_info as $rows) {
                $pid_arr[] = $rows['pid'];
                $num_arr[] = $rows['num'];
            }

            foreach ($pid_arr as $key => $value) {
                $p[] = explode(',', $pid_arr[$key]);
                $n[] = explode(',', $num_arr[$key]);
            }
            $product_id_in = array();
            $num_in = array();
            foreach ($p as $key => $value) {
                foreach ($p[$key] as $key1 => $value1) {
                    $index = array_search($p[$key][$key1],$product_id_in);
                    if ($index !== false) {
                        $num_in[$index] += $n[$key][$key1];
                    } else {
                        $product_id_in[] = $p[$key][$key1];
                        $num_in[] = $n[$key][$key1];
                    }
                }
            }
            // 计算每个用户每个产品的存货数量｝

            foreach ($product_id_in as $key => $value) {
                $product_info = $product->where("id={$product_id_in[$key]}")->field('*')->select();
                foreach ($product_info as $rows) {
                    $cid = $rows['cid'];
                    $pclass_info = $pclass->where("id={$cid}")->find();
                    echo "
                        <option value='{$rows['id']}'>{$pclass_info['name']}---{$rows['name']}---({$rows['pid']})---{$num_in[$key]}</option>

                    ";
                }
            }
            echo "
                    </select>
                    <input type='text' name='num[]' placeholder='{$lang['数量']}' required>
                    <a href='' class='btn btn-primary' data-dismiss='alert'>&times;</a>
                </div>
            ";

            // 传递产品数据库id和数量，用来检测出库量是否超过库存量
            foreach ($product_id_in as $key => $value) {
                $product_info = $product->where("id={$product_id_in[$key]}")->field('*')->select();
                foreach ($product_info as $rows) {
                    echo "
                        <input type='hidden' name='num_max[{$rows['id']}]' value='{$num_in[$key]}'>

                    ";
                }
            }
        } else {
            echo "<option value=''>{$lang['没有库存或未审核']}</option>";
        }
        
        

        break;

    // 产品出库-提交表单
    case 'submit_form_out':
        if ($_POST['pid']) {
            if (is_array($_POST['pid']) && is_array($_POST['num'])) { // 必须先选择产品再提交
                $pid_null = in_array('', $_POST['pid']); // 如果存在返回真
                $num_null = in_array('', $_POST['num']);
            } else {
                echo "{$lang['请先添加产品']}！\n";
            }
            
            if (in_array('', $_POST) || $pid_null || $num_null) { // 只要有一个为真就证明还有东西没填
                echo "{$lang['请检查是否有还项目没有填写']}！";
            } else {
                // 检测是否重复选择了产品
                $pid_count = array_count_values($_POST['pid']);
                foreach ($pid_count as $key => $value) {
                    if ($pid_count[$key] > 1) { // 重复选择了产品
                        $product_name = $product->where("id={$key}")->find();
                        echo "【{$product_name['name']}】{$lang['重复选择了']}【{$pid_count[$key]}】{$lang['次']}！\n";
                        $once[] = false;
                    } else { // 保证每个产品只选择一次
                        $once[] = true;
                    }
                }

                if (!in_array(false, $once)) { // 在确保每个产品只选一次的情况下执行
                    // 检测出库量是否超过库存量
                    foreach ($_POST['num'] as $key => $value) {
                        // echo $_POST['num'][$key].'==='.$_POST['num_max'][$_POST['pid'][$key]].'\n';
                        if ($_POST['num'][$key] > $_POST['num_max'][$_POST['pid'][$key]]) {
                            // echo '第'.($key+1).'个产品的数量超过了库存数量！';
                            $overflow[] = $key+1;
                        }
                    }

                    if (count($overflow) > 0) { // 证明有超过库存的项
                        foreach ($overflow as $key => $value) {
                            $overflow_num .= '【'.$overflow[$key].'】';
                        }
                        echo "{$lang['第']}{$overflow_num}{$lang['个产品的数量超过了库存数量']}！";
                    } else { // 没有超过库存量
                        $tot = count($_POST['pid']); // 本次出库了多少产品
                        $out = M('stockout');
                        $insert['uid'] = $_SESSION['userid'];
                        $insert['express'] = $_POST['express'];
                        $insert['expressid'] = $_POST['expressid'];
                        $insert['orderid'] = $_POST['orderid'];
                        $insert['name'] = $_POST['name'];
                        $insert['nation'] = $_POST['nation'];
                        $insert['state'] = $_POST['state'];
                        $insert['city'] = $_POST['city'];
                        $insert['adress'] = $_POST['adress'];
                        $insert['zcode'] = $_POST['zcode'];
                        $insert['tel'] = $_POST['tel'];
                        $insert['phone'] = $_POST['cellphone'];

                        if (count($_POST['pid']) > 1) { // 避免出现单个产品无法组合为字符串而报警告的提示
                            $insert['pid'] = implode(',', $_POST['pid']); // 这里是产品表里的ID，不是产品id
                            $insert['num'] = implode(',', $_POST['num']);
                        } else {
                            $insert['pid'] = $_POST['pid'][0];
                            $insert['num'] = $_POST['num'][0];
                        }
                        
                        $insert['checked'] = 1; // 未审核

                        if ($out->insert($insert)) {

                            // 写入日志
                            $log = M('log');
                            $insert_log['uid'] = $_SESSION['userid'];
                            $insert_log['event'] = "产品出库-进入审核";
                            foreach ($insert as $key => $value) {
                                $content_log .= $key.' => '.$value.'<br>';
                            }
                            for ($i=0; $i < count($_POST['pid']); $i++) { 
                                $product_out_info = $product->where("id={$_POST['pid'][$i]}")->find();
                                $product_out .= $product_out_info['name'].' => '.$_POST['num'][$i].'<br>';
                            }
                            $insert_log['content'] = "{$_SESSION['username']}出库了产品：<br>{$content_log}<br>出库的产品和数量分别是：<br>{$product_out}";
                            $log->insert($insert_log);

                            echo "{$lang['操作成功，等待管理员审核']}！";
                        } else {
                            echo "{$lang['操作失败']}！";
                        }
                    }
                }
            }
        }else{
            echo "{$lang['请先添加产品']}！";
        }

        break;

    default:
        # code...
        break;
}