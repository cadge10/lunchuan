<?php
require('../inc.php');
// 管理员必须登录后才能使用此功能
$code = adminpub::getsafecode();
if (base::s('m_logined')!=$code) {
	exit('必须登录后才能使用上传功能。');
}

$UpFilePath="../uploadfile/upfiles/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
function checkForm() {
	if (document.getElementById('file').value == '') {
		alert('请选择您要上传的文件！');
		return false;
	}
	return true;
}
function del_pic(pname) {
	purl = $.trim(parent.document.getElementById(pname).value);
	if (purl=="") {
		alert("没有上传图片，不能删除。");
		return false;
	}
	if (confirm('您确定要删除原来的附件吗？该操作不可恢复。')) {
		$.get('../admincp.php',{'r':Math.random(),'a':'ajax','mod':'admin_del_pic','pic':purl},function(data){
		if ($.trim(data)=="success") {
			alert("已经成功删除。");
			parent.document.getElementById(pname).value = "";
		} else {
			alert("删除失败，请检查该附件是否存在。");
		}
		});
	}
}
</script>
<title>文件上传</title>
<style type="text/css">
<!--
body,td,th {
	font-family: 宋体;
	font-size: 12px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
input{border:1px solid #CCC;height:21px; background:#FFFFFF}
-->
</style></head>

<body>
<?php
$action = isset($_GET['action'])?$_GET['action']:'';
$name =isset($_GET['name'])?$_GET['name']:'';
if ($name == '') {
	$name = 'pic';
}
if ($action == 'ok') {
	$file = new upload($UpFilePath,'rar,zip,7z,doc,xls,docx,xlsx,pdf');
	$bool = $file->start('file');
	if (!$bool) {
		die("<script>alert('上传失败，文件格式不正确，请返回重新上传！');history.back();</script>");
	}
	die("<div style='padding-top:5px; color:#666'>附件上传成功！ <a href=\"?name=$name\">重新上传</a></div><script>parent.document.getElementById('{$name}').value='{$bool}';</script>");
}
?>
<form action="?action=ok&name=<?php echo $name;?>" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return checkForm();">
  <span title="点击删除以前上传的附件" id="ajax_del" style="cursor:pointer;" onclick="return del_pic('<?php echo $name;?>')">删除</span>
  <input name="file" type="file" id="file" size="30" />
  <input name="Submit" type="submit" value="上传" />
</form>
</body>
</html>
