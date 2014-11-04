<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	if ($id==(int)base::s('m_userid')) exit(base::alert('您不能在此处修改您自己！'));
	$sys = (int)base::p('sys');
	$roleid = (int)base::p('roleid');
	$username = trim(base::p('username'));
	$password = trim(base::p('password'));
	$repassword = trim(base::p('repassword'));
	$isshow = (int)base::p('isshow');
	
	
	// 检测
	if ($sys==0 && $roleid==0) exit(base::alert('请选择角色！'));
	if ($sys==1) $roleid=0; // 如果是系统管理员，不选择角色
	if ($username=='') exit(base::alert('请输入管理员登录名！'));
	if ($password!='' && $password!=$repassword) exit(base::alert('如果您修改密码，请确定登录密码和确认密码必须相同！'));
	$tj = '';
	if ($password!='') {
		$mdpass = base::md5($password);
		$tj = ",password='$mdpass'";
	}
	// 入库
	$sql = "update ###_admin set roleid='$roleid',sys='$sys',isshow='$isshow'{$tj} where id='$id'";
	$db->query($sql);
	
	exit(base::alert('管理员修改成功，请返回！','?mod=admin_admin'));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
if ($id==(int)base::s('m_userid')) exit(base::alert('您不能在此处修改您自己！'));
$one = $db->get_one("select * from ###_admin where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
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
	if (frm.password.value!='' && frm.password.value!=frm.repassword.value) {
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
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">系统管理员：
	    <input name="action" type="hidden" id="action" value="add">
	    <input name="id" type="hidden" id="id" value="<?php echo $one['id']?>"></th>
      <td><input type="checkbox" name="sys" id="checkbox" value="1" onClick="if (this.checked){$('#flagspan').css('display','none');}else{$('#flagspan').css('display','');}"<?php if ($one['sys']==1) {?> checked="checked"<?php }?>></td>
    </tr>
    <tr id="flagspan"<?php if ($one['sys']==1) {?> style="display:none;"<?php }?>>
      <th align="left">所属角色：</th>
      <td><?php echo adminpub::getrolelist($one['roleid']);?></td>
    </tr>
    <tr>
      <th align="left">登 录 名：</th>
      <td><input name="username" type="text" id="username" size="30" maxlength="20" value="<?php echo $one['username']?>" readonly="readonly" /></td>
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
      <td><input name="isshow" type="checkbox" id="isshow" value="1"<?php if ($one['isshow']==1) {?> checked="checked"<?php }?> /></td>
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