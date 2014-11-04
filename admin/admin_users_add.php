<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$username			=	trim(base::p('username'));
	$password			=	base::p('password');
	$repassword			=	base::p('repassword');
	$email				=	base::p('email');
	$uGrade				=	(int)base::p('uGrade');
	$phone				=	trim(base::p('phone'));
	if($password != $repassword)exit(base::alert('两次密码不一样！'));
	$sql = "insert into ###_users (username,password,phone,`uGrade`,email,last_date,reg_date) values ('$username','".md5($password)."','$phone','$uGrade','$email',$time,$time)";
	$db->query($sql);
	
	exit(base::alert('添加成功，请返回！','?mod=admin_users'));
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/PCASClass.js"></script>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert('请填写栏目名称。');
		frm.title.focus();
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
<input name="action" type="hidden" id="action" value="add">
<table>			
			<tbody>
				<tr>
					<td width="108" align="right"><b>用户名：</b></td>
					<td><input name="username" type="text" class="w208" id="username" /><span>*</span><label for="username">用户名可以是6-14位的字母、数字（注册后不可修改）</label></td>
				</tr>
				<tr>
					<td align="right"><b>密码：</b></td>
					<td><input name="password" type="password" class="w208" id="password" /><span>*</span>可以是6-20位以内的字母、数字、符号</td>
				</tr>
				<tr>
					<td align="right"><b>确认密码：</b></td>
					<td><input name="repassword" type="password" class="w208" id="repassword" /><span>*</span>再输入一遍上面所填写的密码</td>
				</tr>				
				<tr>
					<td align="right"><b>会员等级：</b></td>
					<td><select name="uGrade">
						<?php $data = $db->get_all("select title,id from ###_usergroup where isshow = 1 order by sortid");foreach($data as $v){?>
						<option value="<?php echo $v['id']?>"><?php echo $v['title']?></option>
						<?php }?>
					</select></td>
				</tr>   
				<tr>
					<td align="right"><b>手机：</b></td>
					<td><input name="phone" type="text" class="w208" id="phone" maxlength="11"  />&nbsp;<span>*</span> 和联系人必须一致</td>
				</tr>                
				<tr>
					<td align="right"><b>E-mail：</b></td>
					<td><input name="email" type="text" class="w252" id="email" /><span>*</span></td>
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