<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$id = (int)base::s('m_userid');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_admin where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));

if (base::p('action')=='add') {
	base::issubmit();
	if ($id==0) exit(base::alert('参数传递错误！'));
	$username = trim(base::p('username'));
	$oldpassword = trim(base::p('oldpassword'));
	$password = trim(base::p('password'));
	$repassword = trim(base::p('repassword'));	
	
	// 检测
	if ($username=='') exit(base::alert('请输入管理员登录名！'));
	if ($password=='') exit(base::alert('管理员修改成功，请返回！','?mod=admin_info'));
	if ($password!='' && $password!=$repassword) {
		exit(base::alert('如果您修改密码，请确定登录密码和确认密码必须相同！'));
		if ($oldpassword=='') exit(base::alert('请输入原密码！'));
	}
	if (base::md5($oldpassword)!=$one['password']) exit(base::alert('请输入正确的原密码！'));
	$tj = '';
	if ($password!='') {
		$mdpass = base::md5($password);
		$tj = "password='$mdpass'";
	}
	// 入库
	$sql = "update ###_admin set {$tj} where id='$id'";
	$db->query($sql);
	
	exit(base::alert('账户修改成功，请返回！','?mod=admin_info'));
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.password.value!='' && frm.password.value!=frm.repassword.value) {
		if (frm.oldpassword.value=='') {
			alert('请输入原密码！');
			frm.oldpassword.focus();
			return false;
		}
		alert('如果您修改密码，请确定登录密码和确认密码必须相同！');
		frm.password.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1>个人账户管理</h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">登 录 名：
	    <input name="action" type="hidden" id="action" value="add"></th>
      <td><input name="username" type="text" id="username" value="<?php echo $one['username']?>" size="30" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr>
      <th align="left">原 密 码：</th>
      <td><input name="oldpassword" type="password" id="oldpassword" size="30" maxlength="20" /> 
        * 密码不修改可不填。</td>
    </tr>
    <tr>
      <th align="left">新 密 码：</th>
      <td><input name="password" type="password" id="password" size="30" maxlength="20" /> * 密码不修改请留空。</td>
    </tr>
    <tr>
      <th align="left">密码确认：</th>
      <td><input name="repassword" type="password" id="repassword" size="30" maxlength="20" /></td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>