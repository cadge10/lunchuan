<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p("action")=="add") {
	base::issubmit();
	$title = trim(base::p("title"));
	$pic = trim(base::p("pic"));
	$url = trim(base::p("url"));
	$sortid = (int)base::p("sortid");
	$isshow = (int)base::p("isshow")==1?1:0;
	
	if ($title == "") exit(base::alert("名称必须填写。"));
	if ($pic == "") exit(base::alert("图片必须上传。"));
	
	$sql = "insert into ###_banner (title,pic,url,sortid,isshow) values ('$title','$pic','$url','$sortid','$isshow')";
	$db->query($sql);
	exit(base::alert("添加成功，请返回。","?mod=admin_banner"));
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
	if (frm.title.value=="") {
		alert("名称必须填写。");
		frm.title.focus();
		return false;
	}
	if (frm.pic.value=="") {
		alert("图片必须上传。");
		frm.pic.focus();
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
      <th align="left">banner名称：</th>
      <td><input type="text" id="title" name="title" size="30" /></td>
    </tr>
    <tr>
      <th align="left">banner图片：</th>
      <td><div style="float:left;"><input name="pic" type="text" class="input" id="pic" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="50">
		</div>
		<div style="float:left; padding-left:7px;"><iframe src="includes/upload.php?name=pic" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部图片，必须以http://开头。</div></td>
    </tr>
    <tr>
	  <th width="107" align="left">banner链接：</th>
      <td width="552"><input type="text" id="url" name="url" size="50" /></td>
    </tr>
    <tr>
      <th align="left"><p>排列顺序：</p></th>
      <td><input name="sortid" type="text" id="sortid" size="10"> 
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><select name="isshow" id="isshow">
        <option value="1">是</option>
        <option value="0">否</option>
      </select></td>
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