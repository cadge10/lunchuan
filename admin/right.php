<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
$os = explode(" ", php_uname());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<title>Administrator's Control Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css">
</head>
<body id="main">

<table summary="" id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><h1>欢迎您使用 <?php echo APP_NAME;?>！<span>[您当前的角色：<?php echo adminpub::getuserrolename(base::s("m_userid")).(base::s("m_userid")==1?'(创始人)':'')?>]</span></h1></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%" border="0">
	<tr>
		<td  valign="top">
<!--此处可以放公告-->

<table cellpadding="0" cellspacing="0" border="0" width="98%" class="maintable" style="margin-bottom:15px;">
<tr><td height="30">
快捷操作：<?php
$db->query("select title,url from ###_admincolumn where parentid<>0 and quick=1 order by id asc");
$data = array();
while ($db->next_record()) {
	echo '<a href="?mod='.$db->f('url').'">'.$db->f('title').'</a>　';
}
?>
</td></tr></table>

<table cellpadding="0" cellspacing="0" border="0" width="98%" class="maintable">
<tr>
					<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">



  <tr>
    <td width="15%" align="right">当前版本：</td>
    <td width="34%"><?php echo APP_NAME;?><?php echo APP_VERSION;?>(<?php echo APP_RELEASE;?>)</td>
    <td width="14%"  align="right">域名/IP地址：</td>
    <td width="37%"><?php echo $_SERVER['SERVER_NAME']?>(<?php echo @gethostbyname($_SERVER['SERVER_NAME'])?>)</td>
  </tr>
  
  <tr>
    <td align="right">操作系统：</td>
	<td><?php echo $os[0];?>&nbsp;内核版本：<?php echo $os[2]?></td>
    <td align="right">解译引擎：</td>
	<td><?php echo $_SERVER['SERVER_SOFTWARE']?></td>
  </tr>


  <tr>
    <td align="right">PHP版本：</td>
	<td><?php echo PHP_VERSION?></td>
    <td width="14%" align="right">ZEND支持：</td>
    <td><?php echo (get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")) ?'是':'否'?></td>
  </tr>
  
  <tr>
    <td align="right">MYSQL支持：</td>
	<td><?php echo isfun("mysql_close")?></td>
    <td align="right">Session支持：</td>
	<td><?php echo isfun("session_start")?></td>
  </tr>
</table>
<?php
  function isfun($funName)
  {
      return (false !== function_exists($funName))?'是':'否';
}?></td>
			  </tr>
			</table>
</td>
	</tr>
</table>
<br>
<?php include('bottom.php');?>
</body>
</html>
