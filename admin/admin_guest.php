<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

$sqlt = "";
$recordcount = $db->get_count("select count(id) from ###_guest{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$db->query("select id,realname,tel,email,title,addtime from ###_guest{$sqlt} order by id desc limit $currentpage,$pagesize");

$homepage_url = "?mod=admin_guest&page=#homepage#";
$prevpage_url = "?mod=admin_guest&page=#prevpage#";
$nextpage_url = "?mod=admin_guest&page=#nextpage#";
$lastpage_url = "?mod=admin_guest&page=#lastpage#";
$pagenum_url = "?mod=admin_guest&page=#pagenum#";
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
	$('.darkrow').hover(function(){$(this).addClass('darkrow_out');},function(){$(this).removeClass('darkrow_out');});
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>

<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=60 height=22 align="center">选中</th>
        <th width="75">编号</th>
        <th>留言标题</th>
        <th>留言姓名</th>
        <th>联系电话</th>
        <th>E-mail</th>
        <th>留言时间</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f("id")?>"></td>
        <td align="center"><?php echo $db->f("id")?></td>
        <td><?php echo $db->f("title")?></td>
        <td><?php echo $db->f("realname")?></td>
        <td><?php echo $db->f("tel")?></td>
        <td><?php echo $db->f("email")?></td>
        <td><?php echo date("Y-m-d",$db->f("addtime"))?></td>
        <td align="center"><a href="?mod=admin_guest_edit&id=<?php echo $db->f("id")?>"><u>查看留言</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="8" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="8"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="guest" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit"></div>
<?php echo $pagestr;?>
        </td>
      </tr>
    </tbody> 
  </table>
</form>

<?php include('bottom.php');?>
</body>
</html>