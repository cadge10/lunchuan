<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '登录';
if(base::gp('act') == 'out')//退出
{
    $_SESSION['login_id'] = null;
    $_SESSION['login_user'] = null;
    $_SESSION['login_utype'] = null;
    setcookie('auto_login',null,time()-3600*24);
    setcookie('auto_id',null,time()-3600*24);
    setcookie('auto_user',null,time()-3600*24);
    setcookie('auto_utype',null,time()-3600*24);
    exit(base::msg('注销成功'));
}
if(isset($_COOKIE['auto_login']) && $_COOKIE['auto_login'] == 1){
    $_SESSION['login_id']   = $_COOKIE['auto_id'];
    $_SESSION['login_user'] = $_COOKIE['auto_user'];
    $_SESSION['login_utype'] = $_COOKIE['auto_utype'];
}
if(base::p('act') == 'login'){
    $user = isset($_POST['user']) ? trim($_POST['user']) : '';
    $pass = isset($_POST['pass']) ? trim($_POST['pass']) : '';
    $rem = isset($_POST['rem']) ? trim($_POST['rem']) : 0;
    if($user == '' || $pass == '')exit(base::msg('请输入用户名或密码'));
    $sql = "SELECT * FROM ###_users WHERE username = '".$user."' AND password = '".md5($pass)."' LIMIT 1";
    $result = $db->get_one($sql);
    if($result)//登录成功
    {
        $_SESSION['login_id']   = $result['id'];
        $_SESSION['login_user'] = $result['username'];
        $_SESSION['login_utype'] = $result['utype'];
        exit(base::msg('登录成功','/'));
    }
    exit(base::msg('登录失败'));
}
if($_POST)
{
    $user = isset($_POST['username']) ? trim($_POST['username']) : '';
    $pass = isset($_POST['password']) ? trim($_POST['password']) : '';
    $code = isset($_POST['code']) ? trim($_POST['code']) : '';
    $rem = isset($_POST['rem']) ? trim($_POST['rem']) : 0;
    if($user == '' || $pass == '')exit(base::msg('请输入用户名或密码'));
    if(isset($_POST['code']) && $code != base::s('vCode'))exit(base::msg('请输入正确的验证码'));
    $sql = "SELECT * FROM ###_users WHERE username = '".$user."' AND password = '".md5($pass)."' LIMIT 1";
    $result = $db->get_one($sql);
    if($result)//登录成功
    {
        $_SESSION['login_id']   = $result['id'];
        $_SESSION['login_user'] = $result['username'];
        $_SESSION['login_utype'] = $result['utype'];
        exit(base::msg('登录成功','/'));
    }
    if($rem == 1){//自动登录
        setcookie('auto_login',1,time()+3600*24);
        setcookie('auto_id',$result['id'],time()+3600*24);
        setcookie('auto_user',$result['username'],time()+3600*24);
        setcookie('auto_utype',$result['utype'],time()+3600*24);
    }
    exit(base::msg('登录失败'));
}


$tpl->assign('file_title',$file_title);
?>