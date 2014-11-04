<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p("action")=="add") {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p("title"));
	$sortid = (int)trim(base::p("sortid"));
	$isshow = (int)base::p("isshow");
	// 检索
	if ($title=='') exit(base::alert("类别名称不能为空。"));
	// 入库
	$sql = "update ###_linkstype set title='$title',sortid='$sortid',isshow='$isshow' where id='$id'";
	$db->query($sql);
	exit(base::alert("修改成功，请返回。","?mod=admin_links_type"));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_linkstype where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
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


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this)">
<input name="action" type="hidden" id="action" value="add">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">类别名称：</th>
      <td><input type="text" id="title" name="title" value="<?php echo $one['title']?>" size="30" /></td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="5" />
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="radio" id="radio" value="1"<?php if ($one['isshow']==1){echo ' checked';}?>>
        显示
          <input type="radio" name="isshow" id="radio2" value="0"<?php if ($one['isshow']==0){echo ' checked';}?>>
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