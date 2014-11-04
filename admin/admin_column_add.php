<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$parentid = (int)base::g('parentid');

if (base::p('action')=='add') {
	base::issubmit();
	$title = trim(base::p('title'));
	$sortid = (int)base::p('sortid');
	$url = trim(base::p('url'));
	$isshow = (int)base::p('isshow');
	$topshow = (int)base::p('topshow');
	$quick = (int)base::p('quick');
	$hidden = (int)base::p('hidden');
	$close = (int)base::p('close');
	if ($title=='') exit(base::alert('请填写栏目名称！'));
	if ($url=='') exit(base::alert('请填写标识名称！'));
	$sql = "insert into ###_admincolumn(title,parentid,sortid,url,isshow,topshow,quick,hidden,close)values('$title','$parentid','$sortid','$url','$isshow','$topshow','$quick','$hidden','$close')";
	$db->query($sql);
	
	exit("<script>alert('添加成功，请返回！');parent.leftframe.location.reload();parent.topframe.location.reload();location.href='?mod=admin_column&parentid=$parentid'</script>");
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
		alert('请填写栏目名称！');
		frm.title.focus();
		return false;
	}
	if (frm.url.value=='') {
		alert('请填写栏目标识！');
		frm.url.focus();
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
      <th width="107" align="left">栏目名称：
        <input name="action" type="hidden" id="action" value="add"></th>
      <td><input name="title" type="text" id="title" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <th align="left">栏目顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="5" /> 
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">栏目标识：</th>
      <td><input name="url" type="text" id="url" size="30" maxlength="50" /> * 请确定栏目标识不相同（一级栏目与二级栏目也不能相同）。</td>
    </tr>
    <?php if ($parentid==0) {?>
    <tr>
      <th align="left">顶部菜单显示：</th>
      <td><input name="topshow" type="checkbox" id="topshow" value="1" checked />
        是</td>
    </tr>
    <?php }?>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1" />
        是</td>
    </tr>
    <?php if ($parentid==0) {?>
    <tr>
      <th align="left">隐藏二级：</th>
      <td><input name="hidden" type="checkbox" id="hidden" value="1" />
是</td>
    </tr>
    <?php }
	if ($parentid!=0) {
	?>
    <tr>
	  <th align="left">屏蔽功能：</th>
      <td><input name="close" type="checkbox" id="close" value="1" />
        是</td>
    </tr>
    <tr>
	  <th align="left">快捷菜单：</th>
      <td><input name="quick" type="checkbox" id="quick" value="1" />
        是</td>
    </tr>    
    <?php }?>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>


<table class="helptable" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>注释：“栏目标识”必须填写，对应所操作文件的名称。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>