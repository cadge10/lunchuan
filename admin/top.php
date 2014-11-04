<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>Tool Bar</title>
<link type="text/css" rel="stylesheet" href="admin/images/style.css" />
<script language="javascript" type="text/javascript" src="admin/images/admin.js"></script>
</head>

<body id="header">
<div id="sitetitle">
<strong>&nbsp;</strong>
<a href="http://www.zjr1.com/" target="_blank">&middot;网站管理系统<?php echo APP_VERSION;?></a>
</div>
<div id="topmenu">
<ul>

<li><a href="admincp.php"  target="_top" class="current">后台首页</a></li>
<?php
$db->query("select title,url,id from ###_admincolumn where parentid=0 and isshow=1 and topshow=1 order by sortid asc,id asc");
$data = array();
$totalitem = 0;
while ($db->next_record()) {
	if (!adminpub::getuservalidate(base::s('m_userid'),$db->f('url'))) continue; // 权限控制
	if ((int)base::s('m_userid')!=1 && $db->f('id')==1) continue; // 后台栏目管理非管理员不显示
?>
<li><a href="?mod=admin_<?php echo $db->f(1);?>" target="mainframe" onclick="channelNav(this, '<?php echo $db->f(1);?>');"><?php echo $db->f(0);?></a></li>
<?php }?>

</ul>
</div>

<a href="javascript:;" onclick="sideSwitch();" id="sideswitch" class="opened">关闭侧栏</a>

<div id="topinfo">
<ul>
<li class="sitehomelink"><a href="?mod=admin_info" style="font-weight:bold;" target="mainframe">个人账户管理</a></li>
<li class="sitehomelink"><a href="<?php echo WEB_DIR;?>" target="_blank">查看网站首页</a></li>
<li class="logout"><a href="?mod=login&action=out" target="_parent" onclick="return confirm('您确定要退出吗？')">退出</a></li>
<li style="float:right">有问题请联系网站管理员。</li>
</ul>
</div>
</body>
</html>



