<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

if (base::p('action')=='add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$parentid = (int)base::p('parentid');
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
	$sql = "update ###_admincolumn set title='$title',parentid='$parentid',sortid='$sortid',url='$url',isshow='$isshow',topshow='$topshow',quick='$quick',hidden='$hidden',close='$close' where id='$id'";
	$db->query($sql);
	
	exit("<script>alert('修改成功，请返回！');parent.leftframe.location.reload();parent.topframe.location.reload();location.href='?mod=admin_column&parentid=$parentid'</script>");
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_admincolumn where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
$parentid = $one['parentid'];
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
        <input name="action" type="hidden" id="action" value="add"><input name="parentid" type="hidden" id="parentid" value="<?php echo $parentid;?>">
        <input name="id" type="hidden" id="id" value="<?php echo $one['id']?>"></th>
      <td><input name="title" type="text" id="title" size="30" maxlength="20" value="<?php echo $one['title'];?>" /></td>
    </tr>
    <tr>
      <th align="left">栏目顺序：</th>
      <td><input name="sortid" type="text" id="sortid" size="10" maxlength="5" value="<?php echo $one['sortid'];?>" /> 
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">栏目标识：</th>
      <td><input name="url" type="text" id="url" size="30" maxlength="50" value="<?php echo $one['url'];?>" /> * 请确定栏目标识不相同（一级栏目与二级栏目也不能相同）。</td>
    </tr>
    <?php if ($parentid==0) {?>
    <tr>
      <th align="left">顶部菜单显示：</th>
      <td><input name="topshow" type="checkbox" id="topshow" value="1"<?php if ($one['topshow']==1){echo ' checked';}?> />
        是</td>
    </tr>
    <?php }?>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1"<?php if ($one['isshow']==1){echo ' checked';}?> />
        是</td>
    </tr>
    <?php if ($parentid==0) {?>
    <tr>
      <th align="left">隐藏二级：</th>
      <td><input name="hidden" type="checkbox" id="hidden" value="1"<?php if ($one['hidden']==1){echo ' checked';}?> />
是</td>
    </tr>
    <?php }
	if ($parentid!=0) {
	?>
    <tr>
	  <th align="left">屏蔽功能：</th>
      <td><input name="close" type="checkbox" id="close" value="1"<?php if ($one['close']==1){echo ' checked';}?> />
        是</td>
    </tr>
    <tr>
	  <th align="left">快捷菜单：</th>
      <td><input name="quick" type="checkbox" id="quick" value="1"<?php if ($one['quick']==1){echo ' checked';}?> />
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