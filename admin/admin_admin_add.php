<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$sys = (int)base::p('sys');
	$roleid = (int)base::p('roleid');
	$username = trim(base::p('username'));
	$password = trim(base::p('password'));
	$repassword = trim(base::p('repassword'));
	$isshow = (int)base::p('isshow');
	
	$addtime = $time;
	$ip = '0.0.0.0';
	
	
	// 检测
	if ($sys==0 && $roleid==0) exit(base::alert('请选择角色！'));
	if ($sys==1) $roleid=0; // 如果是系统管理员，不选择角色
	if ($username=='') exit(base::alert('请输入管理员登录名！'));
	$one = $db->get_one("select id from ###_admin where username='$username'");
	if ($one[0]) exit(base::alert('该用户已经被注册，请重新选择一个登录名！'));
	if ($password=='') exit(base::alert('请输入登录密码！'));
	if ($password!=$repassword) exit(base::alert('登录密码和确认密码必须相同！'));
	$mdpass = base::md5($password);
	// 入库
	$sql = "insert into ###_admin(username,password,roleid,sys,addtime,ip,isshow) values ('$username','$mdpass','$roleid','$sys','$addtime','$ip','$isshow')";
	$db->query($sql);
	
	exit(base::alert('管理员添加成功，请返回！','?mod=admin_admin'));
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.roleid.value==0 && !frm.sys.checked) {
		alert('请选择角色！');
		frm.roleid.focus();
		return false;
	}
	
	if (frm.username.value=='') {
		alert('请输入管理员登录名！');
		frm.username.focus();
		return false;
	}
	if ($('#isexists').text()=='yes') {
		alert('该用户已经被注册，请重新选择一个登录名！');
		frm.username.value='';
		frm.username.focus();
		return false;
	}
	if (frm.password.value=='') {
		alert('请输入登录密码！');
		frm.password.focus();
		return false;
	}
	if (frm.password.value!=frm.repassword.value) {
		alert('登录密码和确认密码必须相同！');
		frm.password.focus();
		return false;
	}
	return true;
}
function isreg() {
	if ($.trim($('#username').val())=='') {
		$('#reginfo').css('color','red');
		$('#reginfo').text('请正确输入登录名。');
		$('#isexists').text('yes');
		return ;
	} else {
		$.get('admincp.php',{r:Math.random(),a:'ajax',mod:'admin_adminvalidate','username':$('#username').val()},function(data){
			if ($.trim(data)=='yes') {
				$('#reginfo').css('color','red');
				$('#reginfo').text('该用户已经被注册，请重新选择一个登录名。');
				$('#isexists').text('yes');
				return ;
			} else {
				$('#reginfo').css('color','blue');
				$('#reginfo').text('恭喜您，此用户可以注册。');
				$('#isexists').text('no');
				return ;
			}
		});
	}
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<span class="ajax" id="isexists">yes</span>
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">系统管理员：
	    <input name="action" type="hidden" id="action" value="add"></th>
      <td><input type="checkbox" name="sys" id="checkbox" value="1" onClick="if (this.checked){$('#flagspan').css('display','none');}else{$('#flagspan').css('display','');}"></td>
    </tr>
    <tr id="flagspan">
      <th align="left">所属角色：</th>
      <td><?php echo adminpub::getrolelist();?></td>
    </tr>
    <tr>
      <th align="left">登 录 名：</th>
      <td><input name="username" type="text" id="username" onBlur="isreg();" size="30" maxlength="20" /> <span id="reginfo"></span></td>
    </tr>
    <tr>
      <th align="left">登录密码：</th>
      <td><input name="password" type="password" id="password" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <th align="left">密码确认：</th>
      <td><input name="repassword" type="password" id="repassword" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <th align="left">允许登录：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1" checked="checked" /></td>
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