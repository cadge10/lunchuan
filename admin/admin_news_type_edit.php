<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p('title'));
	$sortid = (int)base::p('sortid');
	$isshow = (int)base::p('isshow');
	$url = trim(base::p('url'));
	if ($title=='') exit(base::alert('请填写栏目名称！'));
	
	$sql = "update ###_newstype set title='$title',sortid='$sortid',url='$url',isshow='$isshow' where id='$id'";
	$db->query($sql);
	
	exit(base::alert('修改成功，请返回！','?mod=admin_news_type'));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_newstype where id='$id'");
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
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">栏目名称：</th>
      <td><input type="text" id="title" name="title" size="30" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">所属栏目：</th>
      <td><?php echo adminpub::getartcol($one['typeid'],'默认一级栏目');?> *栏目不能修改。<script type="text/javascript">document.form1.typeid.disabled=true;</script></td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1"<?php if ($one['isshow']==1){echo ' checked';}?> />
        是</td>
    </tr>
    <tr>
      <th align="left">栏目顺序：</th>
      <td><input name="sortid" type="text" id="sortid" size="10" maxlength="5" value="<?php echo $one['sortid']?>" />
*数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">外部链接：</th>
      <td><input name="url" type="text" id="url" size="30" value="<?php echo $one['url']?>" /> 
        *填写后该栏目跳转到该地址。</td>
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