<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '注册';
if($_POST){
    $user = isset($_POST['username']) ? trim($_POST['username']) : '';
    $pass = isset($_POST['password']) ? trim($_POST['password']) : '';
    $repass = isset($_POST['repass']) ? trim($_POST['repass']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $realname = isset($_POST['realname']) ? trim($_POST['realname']) : '';
    $company = isset($_POST['company']) ? trim($_POST['company']) : '';
    $province = isset($_POST['province']) ? trim($_POST['province']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $fax = isset($_POST['fax']) ? trim($_POST['fax']) : '';
    $sex = isset($_POST['sex']) ? trim($_POST['sex']) : '';
    $tel = isset($_POST['tel']) ? trim($_POST['tel']) : '';
    $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';
    $utype = isset($_POST['utype']) ? trim($_POST['utype']) : 1;
    if($user == '')exit(base::msg('请输入会员登录名'));
    if($pass == '')exit(base::msg('请输入密码'));
    if($pass != $repass)exit(base::msg('两次密码不一致'));
    if($repass == '')exit(base::msg('请输入确认密码'));
    if($realname == '')exit(base::msg('请输入您的姓名'));
    if($phone == '')exit(base::msg('请输入您的手机号码'));
    if($email == '')exit(base::msg('请输入您的电子邮箱'));
    if($tel == '')exit(base::msg('请输入您的固定电话'));
    $sql = "SELECT username FROM ###_users WHERE username = '".$user."'";
    $one = $db->get_one($sql);
    if($one)exit(base::msg('此会员已被注册，请重试'));
    $sql = "INSERT INTO ###_users (`username`,`password`,`email`,`realname`,`company`,`province`,`city`,`sex`,`phone`,`tel`,`fax`,`utype`,`qq`,`reg_date`,`last_date`)".
            " VALUES ('".$user."','".md5($pass)."','".$email."','".$realname."','".$company."','".$province."','".$city."','".$sex."','".$phone."','".$tel."','".$fax."','".$utype."','".$qq."','".$time."','".$time."')";
    $db->query($sql);
    $id = $db->insert_id();
    if($id > 0)//注册成功
    {
        $_SESSION['login_id']   = $id;
        $_SESSION['login_user'] = $user;
        $_SESSION['login_utype'] = $utype;
        exit(base::msg('注册成功','/'));
    }
    exit(base::msg('注册失败'));

}


$tpl->assign('file_title',$file_title);
?>