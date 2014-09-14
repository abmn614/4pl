<?php 
// session_start();

$dict = array(
    "语言" => "Language",
    "登录" =>"Login",
    "用户登录" =>"Login",
    "退出登录" =>"Log out",
    "注册" =>"Register",
    "用户注册" =>"Register",
    "请输入用户名" =>"Username",
    "请输入密码" =>"Password",
    "验证码" =>"Verify code",
    "请输入验证码" =>"Please enter verify code",
    "同意本站注册条款" =>"Agree the license",
    "记住我" =>"Remmber me",
    "忘记密码？" =>"Forgot password?",
    "登录成功" =>"Login succeed",
    "退出登录成功" =>"Log out succeed",
    "密码错误" =>"wrong password",
    "用户名错误" =>"wrong username",
    "验证码错误" =>"wrong Verify code",
    "首页" =>"Home",
    "我的货架" =>"My Shelf",
    "管理货架" =>"Shelf Manage",
    "购买货架" =>"Rent a Shelf",
    "我的产品" =>"My Items",
    "产品列表" =>"Items List",
    "添加产品" =>"Add Items",
    "修改产品" =>"Modify Items",
    "库存管理" =>"Stock Manage",
    "库存列表" =>"Stock List",
    "产品入库" =>"Items Receipt",
    "出库列表" =>"Delivery List",
    "产品出库" =>"Items Delivery",
    "财务管理" =>"Financial Manage",
    "财务清单" =>"Financial Bill",
    "账户充值" =>"Recharge",
    "账户提现" =>"Withdrawals",
    "注册用户" =>"Registered",
    "个人用户" =>"Individual user",
    "已认证" =>"Certified",
    "企业用户" =>"Business user",
    "用户名" =>"Userame",
    "类型" =>"Type",
    "座机" =>"Tel",
    "请输入座机" =>"Please enter your telephone",
    "手机" =>"Cellphone",
    "请输入手机号" =>"Please enter your cellphone",
    "QQ" =>"QQ",
    "邮箱" =>"Email",
    "地址" =>"Address",
    "发货人" =>"Sender",
    "发货人职位" =>"Sender Jobs",
    "身份证号" =>"Sender ID",
    "身份证复印件" =>"ID Copy",
    "营业执照" =>"Business license",
    "操作" =>"Operation",
    "查看" =>"View",
    "修改" =>"Modify",
    "删除" =>"Delete",
    "上一页" =>"Pre",
    "下一页" =>"Next",
    "末页" =>"End",
    "共计1页，11条记录" =>"Totall 1 page(s),11 recorad(s)",
    "实名认证" =>"Name Identified",
    "个人认证" =>"Individual Identified",
    "企业认证" =>"Business Identified",
    "请输入身份证编号" =>"Please enter your ID nunmber",
    "认证" =>"Identified",
    "资料修改" =>"Change Profile",
    "密码" =>"Password",
    "旧密码" =>"Old Password",
    "新密码" =>"New Password",
    "重复密码" =>"Repeat Password",
    "请再次输入密码" =>"Repeat Password",
    "重复新密码" =>"Repeat new Password",
    "确认修改" =>"Confirm the Change",
    "如果需要修改密码则填此项和下面两项，否则跳过。" =>"If you need to modify the password you fill in this and the following two,otherwise skip.",
    "货架编号" =>"ShelfNo",
    "状态" =>"State",
    "正常" =>"Normal",
    "等待审核" =>"Waitting for check",
    "选择仓库" =>"Chose Warehouse",
    "可选货架" =>"Shelves can be used",
    "为了方便您管理，建议从前往后选择连续的货架。" =>"For your convenience,management,front to back is recommended to select a continuous Shelves.",
    "确认购买" =>"Confirm to Rent",
    "选择产品分类" =>"Chose the items sort",
    "选择产品" =>"Chose a item",
    "数量" =>"Num",
    "产品分类" =>"Items sort",
    "产品ID" =>"Items ID",
    "产品名称" =>"Items Name",
    "产品图片" =>"Items Pic",
    "单重" =>"Weight",
    "单价" =>"Price",
    "规格" =>"Size",
    "颜色" =>"Color",
    "上/下限" =>"Max/Min",
    "上限" =>"Max",
    "下限" =>"Min",
    "备注" =>"Note",
    "共计" =>"Total",
    "1件产品" =>"1pcs",
    "入库" =>"Receipt",
    "出库" =>"Delivery",
    "物流方式" =>"Shipment",
    "快递单号" =>"Track Number",
    "快递 / 单号" =>"Express / ID",
    "产品 / 数量 / 仓库" =>"Items / Num / Warehouse",
    "订单号" =>"Order Number",
    "审核状态" =>"Check State",
    "已审核" =>"Checked",
    "未审核" =>"Not Checked",
    "审核未通过" =>"Unapprove",
    "未知" =>"Unknown",
    "时间" =>"Time",
    "财务中心" =>"Financial Center",
    "账户余额" =>"Account Balance",
    "内容" =>"Content",
    "费用" =>"Fee",
    "操作人" =>"Operator",
    "库存总数" =>"Stock Number",
    "货架总数" =>"Shelf Number",
    "新闻中心" =>"News Center",
    "元" =>"￥",
    "请先登录" =>"You haven't login yet",
    "点击确认跳转至登录页面" =>"Click to login",
    "当前用户非管理员" =>"Not admin",
    "密码修改成功" =>"change password success",
    "密码未作出任何修改" =>"Nothing done",
    "两次输入的新密码不一致" =>"The new password is inconsistent",
    "两次输入的密码不一致" =>"The password is inconsistent",
    "旧密码不正确" =>"Old password is not right",
    "请设置新密码" =>"Please reset password",
    "资料修改成功" =>"change success",
    "资料未作出任何修改" =>"Nothing done",
    "该用户名已存在" =>"Username is exited",
    "注册成功" =>"Register success",
    "注册失败" =>"Register faild",
    "个人资料" =>"personal profile",
    "货架列表" =>"Shelf List",
    "没有记录" =>"No records",
    "总货架" =>"Total shelfs",
    "已购买，等待审核中" =>"bought, wating checked",
    "已删除，等待审核中" =>"deleted, wating checked",
    "请先购买货架" =>"Please buy a shelf first",
    "操作成功，等待管理员审核" =>"Operation is successful, wating checked",
    "操作失败" =>"Operation is failed",
    "一般衣服填S/M/L/XL/XXL等，鞋子填码数即可，其他产品视情况填写" =>"Clothes: S/M/L/XL/XXL, Shoes: size, Others: depends",
    "添加成功" =>"Add success",
    "添加失败" =>"Add failed",
    "修改成功" =>"alter failed",
    "修改失败" =>"alter failed",
    "共计" =>"Total",
    "页" =>"pages",
    "条记录" =>"records",
    "请先选择产品" =>"Please select a item",
    "请先添加产品" =>"Please add a item first",
    "重复选择了" =>"Repeated",
    "次" =>"times",
    "请检查是否有还项目没有填写" =>"Please check whether the blank is not complete",
    "没有库存或未审核" =>"No stock or unchecked",
    "第" =>"No.",
    "个产品的数量超过了库存数量" =>"counts overflow",
    "姓名" =>"Name",
    "国家" =>"Nation",
    "州/省" =>"State",
    "城市" =>"City",
    "地址" =>"Adress",
    "邮编" =>"Zcode",







    );

if ($_SESSION['lang'] == 'en') {
    $lang = $dict;
} else {
    foreach ($dict as $key => $value) {
        $lang[$key] = $key;
    }
}

 ?>