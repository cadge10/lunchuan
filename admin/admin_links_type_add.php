<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p("action")=="add") {
	base::issubmit();
	$title = trim(base::p("title"));
	$sortid = (int)trim(base::p("sortid"));
	$isshow = (int)base::p("isshow");
	// 检索
	if ($title=='') exit(base::alert("类别名称不能为空。"));
	// 入库
	$sql = "insert into ###_linkstype(title,sortid,isshow) values ('$title','$sortid','$isshow')";
	$db->query($sql);
	exit(base::alert("添加成功，请返回。","?mod=admin_links_type"));
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
		alert("链接名称不能为空。");
		frm.title.focus();
		return false;
	}
	if (frm.sortid.value=='') {
		alert("链接顺序不能为空，如不排序，可默认为0。");
		frm.sortid.focus();
		return false;
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
<input name="action" type="hidden" id="action" value="add">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">类别名称：</th>
      <td><input name="title" type="text" id="title" size="30" maxlength="100" /></td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="5" />
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="radio" id="radio" value="1" checked>
        显示
          <input type="radio" name="isshow" id="radio2" value="0">
        不显示</td>
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