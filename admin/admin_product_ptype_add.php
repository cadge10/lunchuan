<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$title = trim(base::p('title'));
	$sortid = (int)base::p('sortid');
	$attr_group = trim(base::p('attr_group'));
	if ($title=='') exit(base::alert('请填写栏目名称！'));
	$sql = "insert into ###_productptype(title,attr_group,sortid)values('$title','$attr_group','$sortid')";
	$db->query($sql);
	
	exit(base::alert('添加成功，请返回！','?mod=admin_product_ptype'));
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
	if (frm.title.value=='') {
		alert('请填写类型名称。');
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
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">类型名称：</th>
      <td><input name="title" type="text" id="title" size="30" maxlength="50" /></td>
    </tr>
    <tr>
      <th align="left">属性分组：</th>
      <td><textarea name="attr_group" id="attr_group" cols="45" rows="5"></textarea><br />每行一个商品属性组。排序也将按照自然顺序排序。
</td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="5" />
*数字越小越靠前。</td>
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