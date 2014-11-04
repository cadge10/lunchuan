<?php
if (base::g('action')=='out') {
	$_SESSION['m_logined'] = '';
	$_SESSION['m_userid'] = '';
	$_SESSION['m_username'] = '';
	exit(base::location('?mod=login'));
}

// 检测是否已经登录
$code = adminpub::getsafecode();
if (base::s('m_logined')==$code) exit(base::location('admincp.php'));
if (base::p('action')=='login') {
	$username = strtolower(trim(base::p('username')));
	$password = trim(base::p('password'));
	$yzcode = trim(base::p('yzcode'));
	
	// 进行验证
	if ($username=='') exit(base::alert('请输入登录名。'));
	if ($password=='') exit(base::alert('请输入密码。'));
	if ($yzcode=='') exit(base::alert('请输入验证码。'));
	if ($yzcode!=base::s('vCode')) exit(base::alert('请输入正确的验证码。'));
	
	$one = $db->get_one("select id,password,isshow from ###_admin where username='$username'");
	if (!$one) exit(base::alert('登录名或密码填写错误，请重新填写。'));
	if ($one['isshow']!=1) exit(base::alert('该登录名已被管理员禁用，如有疑问请联系管理员。'));
	if ($one['password']!=base::md5($password)) exit(base::alert('登录名或密码填写错误，请重新填写。'));
	
	// 登录成功，保存一些信息
	$_SESSION['m_logined'] = $code;
	$_SESSION['m_userid'] = $one['id'];
	$_SESSION['m_username'] = $username;
	
	// 更新登录信息
	$ip = $_SERVER['REMOTE_ADDR']; // 简单的IP地址
	$db->query("update ###_admin set ip='$ip',lasttime='$time' where id='".$one['id']."'");
	
	// 跳转
	exit(base::location('admincp.php'));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>&middot;网站管理系统<?php echo APP_VERSION;?></title>
<link rel="stylesheet" type="text/css" href="admin/images/login.css" />
<script type="text/javascript">
function checkForm()
{
	if(!document.login.username.value)
	{
		alert("请输入用户名");
		document.login.username.focus();
		return false;
	}
	if(!document.login.password.value)
	{
		alert("请输入密码！");
		document.login.password.focus();
		return false;
	}
	if(!document.login.yzcode.value)
	{
		alert("请输入验证码！");
		document.login.yzcode.focus();
		return false;
	}
}
function onFocus()
{
	document.login.username.focus();
}
</script>
</head>
<body onload="onFocus();">
<div class="mainarea">
<form name="login" method="post" action="" onsubmit="return checkForm()">
<input name="action" type="hidden" id="action" value="login" />
<table class="loginbox">
<tr>
            <td class="logo"><p>系统版本：<br />&middot;网站管理系统<?php echo APP_VERSION;?></p></td>
            <td>
                <table cellspacing="0" cellpadding="0" class="loginform">
                    <tr>
                        <th>账　号：</th>
                        <td><input type="text" name="username" class="t_input" id="username" style="width:148px;" /></td>
                    </tr>
                    <tr>
                        <th>密　码：</th>
                        <td><input type="password" name="password" class="t_input" style="width:148px;" /></td>
                    </tr>
                    <tr>
                      <th>验证码：</th>
                      <td><input name="yzcode" type="text" class="t_input" id="yzcode" style="width:60px;" maxlength="5" /><?php echo base::getcode();?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <input type="submit" class="button1 submit" name="btnsubmit" value="登录后台" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_DIR;?>">返回前台</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
</div>
<p class="footer">Powered by &middot;网站管理系统 &copy; 2005 - <?php echo date("Y");?> <a href="http://www.zhengkejian.cn" target="_blank">zhengkejian.cn</a></p>
</body>
</html>