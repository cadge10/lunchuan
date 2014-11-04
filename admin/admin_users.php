<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

$sqlt = '';
$qstr = '';

$typeid = isset($_REQUEST['typeid'])?(int)$_REQUEST['typeid']:0;
if ($typeid) {
	$childstr = adminpub::gettreechildall($typeid);
	$sqlt .= " and typeid in($childstr)";
	$qstr .= "&typeid=$typeid";
}

$userid = isset($_REQUEST['userid'])?(int)$_REQUEST['userid']:0;
if ($userid) {
	$sqlt .= " and userid='$userid'";
	$qstr .= "&userid=$userid";
}

$onlypage = isset($_REQUEST['onlypage'])?(int)$_REQUEST['onlypage']:0;
if ($onlypage) {
	$sqlt .= " and onlypage='$onlypage'";
	$qstr .= "&onlypage=$onlypage";
}

$keyword = isset($_REQUEST['keyword'])?base::quotes(trim($_REQUEST['keyword'])):'';
if ($keyword) {
	$sqlt .= " and username like '%$keyword%'";
	$qstr .= "&keyword=$keyword";
}

$recordcount = $db->get_count("select count(id) from ###_users where 1=1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_users where 1=1{$sqlt} order by id desc limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select * from ###_users where id in($idcond) order by id desc";
$db->query($sql);

$homepage_url = "?mod=admin_users$qstr&page=#homepage#";
$prevpage_url = "?mod=admin_users$qstr&page=#prevpage#";
$nextpage_url = "?mod=admin_users$qstr&page=#nextpage#";
$lastpage_url = "?mod=admin_users$qstr&page=#lastpage#";
$pagenum_url  = "?mod=admin_users$qstr&page=#pagenum#";
$pagestr = base::parse_page();

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function(){
	$('#typeid').change(function(){
		window.location.href='?mod=admin_users&typeid='+$('#typeid').val()+'&keyword='+$('#keyword').val();
	});
	
	
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>

<form name="form2" method="post" action="?mod=admin_users">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="top">按昵称搜索：
        <input name="keyword" type="text" id="keyword" size="30" value="<?php echo $keyword;?>" maxlength="50">
      <input type="submit" name="button" id="button" value=" 搜  索 ">
      <input name="userid" type="hidden" id="userid" value="<?php echo $userid?>"></td>
    </tr>
  </table>
</form>
<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=60 height=22 align="center">选中</th>
        <th width="75">用户ID</th>
        <th>用户</th>
        <th>会员类型</th>
        <th>手机</th>        
        <th>邮箱</th>
        <th>最后登录时间</th>
        <th>注册时间</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <td><?php echo $db->f('username')?></td>
        <td align="center"><?php echo $db->f('utype') == 1 ? '供应商' : '采购商';?></td>
        <td align="center"><?php echo $db->f('phone');?></td>       
        <td align="center"><?php echo $db->f('email')?></td>
        <td align="center"><?php echo date('Y-m-d', $db->f('last_date'))?></td>
        <td align="center"><?php echo date('Y-m-d',$db->f('reg_date'));?></td>
        <td align="center"><a href="?mod=admin_users_edit&id=<?php echo $db->f('id').'&r=yes'.$qstr?>&page=<?php echo $page;?>"><u>修改</u></a></td>
      </tr>
<?php } } else {?>   
      <tr>
        <td colspan="12" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="12"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="users" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit"></div>
<?php echo $pagestr;?>        </td>
      </tr>
    </tbody> 
  </table>
</form>

<?php include('bottom.php');?>
</body>
</html>