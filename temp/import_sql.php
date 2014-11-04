<?php
header("Content-type:text/html; charset=utf-8");
@set_time_limit(360);
$mode = isset($_POST["mode"]);
if ($mode == "import") {
	// 导入数据库
	$dbhost = isset($_POST["dbhost"])?trim($_POST["dbhost"]):"";
	$dbname = isset($_POST["dbname"])?trim($_POST["dbname"]):"";
	$dbuser = isset($_POST["dbuser"])?trim($_POST["dbuser"]):"";
	$dbpass = isset($_POST["dbpass"])?trim($_POST["dbpass"]):"";
	if ($dbhost=="") alert("请填写数据库服务器，有端口请加端口，如：localhost:3306。");
	if ($dbname=="") alert("请填写数据库名。");
	if ($dbuser=="") alert("请填写登录名。");
	if ($dbpass=="") alert("请填写登录密码。");
	$files = isset($_FILES["sqldata"])?$_FILES["sqldata"]:"";
	if (!is_array($files)) alert("请选择您要导入的数据库文件。");
	
	$cfg_txttype = "sql|txt";
	$sqldata = @$_FILES["sqldata"]['tmp_name'];
	$sqldata_type = @$_FILES["sqldata"]['type'];
	$sqldata_name = @$_FILES["sqldata"]['name'];
	if(!is_uploaded_file($sqldata)) alert("请选择您要导入的数据库文件！");
	//if(!preg_match("#^text#", $sqldata_type)) alert("你上传的不是文本类型附件！");
	
	$sqldata_name = trim(preg_replace("#[ \r\n\t\*\%\\\/\?><\|\":]{1,}#", '', $sqldata_name));
    if(!preg_match("#\.(".$cfg_txttype.")#i", $sqldata_name)) alert("你选择的数据库文件存在问题，文章扩展名必须是.sql或.txt！");
	// 读取数据库文件
	if (!file_exists($sqldata)) alert('该备份文件不存在，请重新选择！');
	$sqlfile=fopen($sqldata,'rb');
	$str=fread($sqlfile,filesize($sqldata));
	$str=str_replace("\r","\n",$str);
	$sqlarr=explode(";\n",trim($str));
	$queryarr = array();
	foreach($sqlarr as $key => $values)
	{
		foreach(explode("\n",trim($values)) as $rows)
		@$queryarr[$key].= $rows[0]=='#' || $rows[0].$rows[1] == '--' ? '' : $rows;
	}
	$link=@mysql_connect($dbhost,$dbuser,$dbpass) or exit('您填写的数据库信息无法连接数据库，请查证后重新填写！');
	@mysql_select_db($dbname,$link) or exit('您填写的数据库不存在，请查证后重新填写！');
	@mysql_query("set names 'utf8'",$link);
	foreach($queryarr as $values)
	{
		if(!@mysql_query($values,$link)) exit("导入失败，请检查数据库中是否存在该表，或语法错误。");
	}
	exit('导入成功，请关闭此页面，并及时删除！');
}

function alert($msg) {
	if (trim($msg)=="") exit();
	exit('<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提示信息</title><script>alert("'.$msg.'");history.back();</script><body><body></html>');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据库导入程序</title>
<style type="text/css">
* {font-size:12px;}
</style>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.dbhost.value=='') {
		alert("请填写数据库服务器，有端口请加端口，如：localhost:3306。");
		frm.dbhost.focus();
		return false;
	}
	if (frm.dbname.value=='') {
		alert("请填写数据库名。");
		frm.dbname.focus();
		return false;
	}
	if (frm.dbuser.value=='') {
		alert("请填写登录名。");
		frm.dbuser.focus();
		return false;
	}
	if (frm.dbpass.value=='') {
		alert("请填写登录密码。");
		frm.dbpass.focus();
		return false;
	}
	if (frm.sqldata.value=='') {
		alert("请选择导入数据库文件。");
		frm.sqldata.focus();
		return false;
	}
	if (confirm("您确定要导入吗？导入后原有的数据可能被覆盖或删除，请谨慎操作。")) {
		return true;
	} else {
		return false;
	}
}
</script>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return checkForm(this)">
<input name="mode" type="hidden" id="mode" value="import" />
<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
      <td height="30" align="right" bgcolor="#FFFFFF">数据库服务器：</td>
      <td align="left" bgcolor="#FFFFFF"><input name="dbhost" type="text" id="dbhost" maxlength="50" /> 
        *一般为localhost，有端口后加如:3306</td>
    </tr>
    <tr>
      <td width="120" height="30" align="right" bgcolor="#FFFFFF">数据库名：</td>
      <td align="left" bgcolor="#FFFFFF"><input name="dbname" type="text" id="dbname" maxlength="50" /> 
        *数据库名必须存在。</td>
    </tr>
    <tr>
      <td height="30" align="right" bgcolor="#FFFFFF">登录名：</td>
      <td align="left" bgcolor="#FFFFFF"><input name="dbuser" type="text" id="dbuser" maxlength="50" /></td>
    </tr>
    <tr>
      <td height="30" align="right" bgcolor="#FFFFFF">登录密码：</td>
      <td align="left" bgcolor="#FFFFFF"><input name="dbpass" type="text" id="dbpass" maxlength="50" /></td>
    </tr>
    <tr>
      <td height="30" align="right" bgcolor="#FFFFFF">SQL文件：</td>
      <td align="left" bgcolor="#FFFFFF"><input type="file" name="sqldata" id="sqldata" /> * 必须是文本文件。</td>
    </tr>
    <tr>
      <td height="30" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="left" bgcolor="#FFFFFF"><input type="submit" name="button" id="button" value="导入数据" /></td>
    </tr>
  </table>
</form>
</body>
</html>