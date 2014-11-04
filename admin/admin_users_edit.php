<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action') == 'edit') {
	base::issubmit();
	$username = trim(base::p('username'));
	$email				=	base::p('email');
	$password			=	trim(base::p('password'));
	$phone				=	trim(base::p('phone'));
	$ugrade				=	(int)base::p('ugrade');
	$gourl = trim(base::p('gourl'));
	
	// 入库
	$sql = "update ###_users set email = '$email',"
	."phone = '$phone',uGrade = "
	."'$ugrade' where username='$username'";
	$db->query($sql);
	
	exit(base::alert('修改成功，请返回。','?mod=admin_users'.$gourl));
}
$id = (int)base::g('id');
$uType = (int)base::g('utype');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_users where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
$gourl = $_SERVER['QUERY_STRING'];
$gourlarr = explode('&r=yes',$gourl);
$gourl = @$gourlarr[1];
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
	if (frm.title.value=='') {
		alert('请填写文章标题！');
		frm.title.focus();
		return false;
	}
	if (frm.typeid.value==0) {
		alert('请选择文章栏目！');
		frm.typeid.focus();
		return false;
	}
	if (frm.checktype.value == 'no') {
		alert('您只能在最后一级栏目下添加产品！');
		frm.typeid.focus();
		return false;
	}
}
function checkTypeId(str) {
	$.get('admin.php',{r:Math.random(),a:'ajax',mod:'admin_news_checktype',typeid:str},function(data){
		if ($.trim(data) == 'no') {
			$('#checktype').val('no');
			$('#typemsg').html('<font color="red" style="font-family:Arial;" title="请您选择一个有效的栏目，并且只能选择最后一级栏目。"> X</font>');
		} else {
			$('#checktype').val('yes');
			$('#typemsg').html('<font color="green" style="font-family:Arial;"> &radic;</font>');
		}
	});
}
$(function(){
	checkTypeId($('#typeid').val());
	$('#typeid').change(function(){
		checkTypeId($('#typeid').val());
	});
	
	
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<input name="gourl" type="hidden" id="gourl" value="<?php echo $gourl?>">
<input name="checktype" type="hidden" id="checktype" value="no">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">用户名：</th>
      <td width="552"><input name="username" id="username" type="hidden" value="<?php echo $one['username']?>"><?php echo $one['username']?></td>
    </tr>
    <tr>
	  <th width="107" align="left">会员等级：</th>
      <td width="552"><select name="ugrade" id="ugrade">
      <option value="0">0级</option>
      	<?php $query = $db->query("select title,id from ###_usergroup");while($o = $db->fetch_array($query)){ ?>
        <option value="<?php echo $o['id']; ?>" <?php if($one['uGrade'] == $o['id']){echo "selected";} ?>><?php echo $o['title']; ?></option>
        <?php } ?>
      </select></td>
    </tr>
    <tr>
	  <th width="107" align="left">手机：</th>
      <td width="552"><input name="phone" type="text" id="phone" value="<?php echo $one['phone']?>" size="30">&nbsp;</td>
    </tr>
    <tr>
	  <th width="107" align="left">邮箱：</th>
      <td width="552"><input name="email" type="text" id="email" value="<?php echo $one['email']?>" size="30">&nbsp;</td>
    </tr>     
  </tbody> 
</table>
<div class="buttons">
<input type="hidden" value="edit" name="action" />
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>