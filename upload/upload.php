<?php 
header("content-type:text/html;charset=utf8");
include('../class/config.inc.php');
include('../class/model.class.php');
session_start();

// 获取上传文件数组
$file = $_FILES;

// 限制文件类型
$acceptftype = array('jpg','png','gif','rar','zip');

$update['username'] = $_POST['uname'];
$update['idcard'] = $_POST['idcard'];

switch (count($file)) {
    case 2: // 收到2个文件，企业认证
        if ($file['idcard_copy']['error'] == 0) {
            if ($file['business_license']['error'] == 0) {
                // 取文件名
                $idcard_copy = $file['idcard_copy']['name'];
                $business_license = $file['business_license']['name'];
                $idcard_copy_arr = explode('.', $idcard_copy); // 按.分割文件名
                $idcard_copy_ext = array_pop($idcard_copy_arr); // 弹出最后一个，并保存
                $business_license_arr = explode('.', $business_license); // 按.分割文件名
                $business_license_ext = array_pop($business_license_arr); // 弹出最后一个，并保存
                // 取文件类型
                $idcard_copy_mime = $file['idcard_copy']['type']; // 取mime类型
                $idcard_copy_mimearr = explode('/', $idcard_copy_mime); // 按/分割mime
                $idcard_copy_type = $idcard_copy_mimearr[0]; // 取出类型的文本
                $business_license_mime = $file['business_license']['type']; // 取mime类型
                $business_license_mimearr = explode('/', $business_license_mime); // 按/分割mime
                $business_license_type = $business_license_mimearr[0]; // 取出类型的文本
                // 设置目录
                if ($idcard_copy_type == 'image' && $business_license_type == 'image') {
                    $idcard_copy_destination = 'images/'.time().'0.'.$idcard_copy_ext;
                    $business_license_destination = 'images/'.time().'1.'.$business_license_ext;
                } else {
                    $idcard_copy_destination = 'files/'.time().'0.'.$idcard_copy_ext;
                    $business_license_destination = 'files/'.time().'1.'.$business_license_ext;
                }
                // 取临时文件路径
                $idcard_copy_tmp = $file['idcard_copy']['tmp_name'];
                $business_license_tmp = $file['business_license']['tmp_name'];
                // 把临时文件移动到目标目录
                // 限制文件类型
                $idcard_copy_size = $file['idcard_copy']['size'];
                $business_license_size = $file['business_license']['size'];
                if (in_array($idcard_copy_ext, $acceptftype) && in_array($business_license_ext, $acceptftype)) {
                    // 限制文件大小
                    if ($idcard_copy_size <= 1024*1024 && $business_license_size <= 1024*1024) {
                        if (move_uploaded_file($idcard_copy_tmp, $idcard_copy_destination) && move_uploaded_file($business_license_tmp, $business_license_destination)) {
                            $user = M('user');
                            if ($userid = $user->where("username='{$_POST['uname']}'")->field('id')->select()) {
                                $update['idcard_copy'] = $idcard_copy_destination;
                                $update['business_license'] = $business_license_destination;
                                $update['v'] = 2; // 企业认证
                                if ($user->where("id={$userid[0]['id']}")->update($update)) {
                                    $type = $user->where("username = '{$_POST['uname']}'")->field('type')->select();
                                    if ($update['v'] == $type[0]['type']) {
                                        // 写入日志
                                        $log = M('log');
                                        $insert_log['uid'] = $_SESSION['userid'];
                                        $insert_log['event'] = "企业认证";
                                        foreach ($update as $key => $value) {
                                            $content_log .= $key." => ".$value."<br>";
                                        }
                                        $insert_log['content'] = "{$_SESSION['username']}为{$_POST['uname']}认证成功，信息如下：<br><pre>{$content_log}</pre>";
                                        $log->insert($insert_log);

                                        echo "<script>alert('企业认证成功')</script>";
                                        echo "<script>location='../user/v.php'</script>";
                                    } else {
                                        echo "<script>alert('数据插入成功，但认证类型与用户类型不匹配！\\n请检查用户类型后重新认证！');history.back();</script>";
                                    }
                                    
                                }else{
                                    echo $userid;
                                    echo "<script>alert('更新数据库失败')</script>";
                                }
                            }else{
                                echo "<script>alert('用户名不正确')</script>";
                            }
                        } else {
                            echo "<script>alert('企业认证失败')</script>";
                        }
                    } else {
                        echo "身份证图片大小为 ".ceil($idcard_copy_size/1024)."KB<br />"; 
                        echo "营业执照图片大小为 ".ceil($business_license_size/1024)."KB<br />"; 
                        echo "超出限制，最大只能上传 1024KB";
                    }
                } else {
                    echo "<script>alert('不支持后缀是 {$idcard_copy_ext} 的文件类型')</script>";
                    echo "<script>alert('不支持后缀是 {$business_license_ext} 的文件类型')</script>";
                }
            }elseif ($file['business_license']['error'] == 4) {
                echo "<script>alert('请上传营业执照！');</script>";
                echo "<script>location='../user/v.php';</script>";
            }else{
                echo "错误代码：{$file['idcard_copy']['error']}";
            }
        }elseif ($file['idcard_copy']['error'] == 4) {
            echo "<script>alert('请上传身份证复印件！');</script>";
            echo "<script>location='../user/v.php';</script>";
        }else{
            echo "错误代码：{$file['idcard_copy']['error']}";
        }
        break;
    
    default: // 默认必定收到1个文件，个人认证
        if ($file['idcard_copy']['error'] == 0) { // 已上传文件
            // 取文件名
            $fname = $file['idcard_copy']['name'];

            $fnamearr = explode('.', $fname); // 按.分割文件名
            $fnameext = array_pop($fnamearr); // 弹出最后一个，并保存

            // 取文件类型
            $fmime = $file['idcard_copy']['type']; // 取mime类型
            $fmimearr = explode('/', $fmime); // 按/分割mime
            $ftype = $fmimearr[0]; // 取出类型的文本

            // 设置目录
            if ($ftype == 'image') {
                $destination = 'images/'.time().'.'.$fnameext;
            } else {
                $destination = 'files/'.time().'.'.$fnameext;
            }

            // 取临时文件路径
            $tmpfname = $file['idcard_copy']['tmp_name'];

            // 把临时文件移动到目标目录
            // 取文件大小
            $fsize = $file['idcard_copy']['size'];

            if (in_array($fnameext, $acceptftype)) {
                // 限制文件大小
                if ($fsize <= 1024*1024) {
                    if (move_uploaded_file($tmpfname, $destination)) {
                        $user = M('user');
                        if ($userid = $user->where("username='{$_POST['uname']}'")->field('id')->select()) {
                            $update['idcard_copy'] = $destination;
                            $update['v'] = 1; // 个人认证
                            if ($user->where("username = '{$_POST['uname']}'")->update($update)) {
                                $type = $user->where("username = '{$_POST['uname']}'")->field('type')->select();
                                if ($update['v'] == $type[0]['type']) {
                                    // 写入日志
                                    $log = M('log');
                                    $insert_log['uid'] = $_SESSION['userid'];
                                    $insert_log['event'] = "个人认证";
                                    foreach ($update as $key => $value) {
                                        $content_log .= $key." => ".$value."<br>";
                                    }
                                    $insert_log['content'] = "{$_SESSION['username']}为{$_POST['uname']}认证成功，信息如下：<br><pre>{$content_log}</pre>";
                                    $log->insert($insert_log);

                                    echo "<script>alert('个人认证成功');</script>";
                                    echo "<script>location='../user/v.php';</script>";
                                } else {
                                    echo "<br><br><br><br>";
                                    var_dump($type);
                                    echo "<script>alert('数据插入成功，但认证类型与用户类型不匹配！\\n请检查用户类型后重新认证！');history.back();</script>";
                                }
                            }else{
                                echo "<script>alert('更新数据库出错！');</script>";
                                echo "<script>location='../user/v.php';</script>";
                            }
                        }else{
                            echo "<script>alert('用户名不正确')</script>";
                            echo "<script>location='../user/v.php';</script>";
                        }
                    } else {
                        echo "<script>alert('个人认证失败');</script>";
                        echo "<script>location='../user/v.php';</script>";
                    }
                } else {
                    echo "当前文件大小为 ".ceil($fsize/1024)."KB<br />"; 
                    echo "超出限制，最大只能上传 1024KB";
                }
            } else {
                echo "不支持后缀是 {$fnameext} 的文件类型";
            }
        }elseif ($file['idcard_copy']['error'] == 4) {
            echo "<script>alert('请上传身份证复印件！');</script>";
            echo "<script>location='../user/v.php';</script>";
        }else{
            echo "错误代码：{$file['idcard_copy']['error']}";
        }
        break;
}

 ?>