<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

//$sqlt = " where id<>'".base::s('m_userid')."'";
$sqlt = "";
$recordcount = $db->get_count("select count(1) from ###_linkstype{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$db->query("select id,title,sortid,isshow from ###_linkstype{$sqlt} order by sortid asc,id desc limit $currentpage,$pagesize");

$homepage_url = "?mod=admin_linkstype&page=#homepage#";
$prevpage_url = "?mod=admin_linkstype&page=#prevpage#";
$nextpage_url = "?mod=admin_linkstype&page=#nextpage#";
$lastpage_url = "?mod=admin_linkstype&page=#lastpage#";
$pagenum_url = "?mod=admin_linkstype&page=#pagenum#";
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
        <th>类别名称</th>
        <th>排列顺序</th>
        <th>是否显示</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <td><a href='?mod=admin_links_type_edit&id=<?php echo $db->f('id')?>'><u><?php echo $db->f("title")?></u></a></td>
        <td align="center"><?php echo $db->f("sortid")?></td>
        <td align="center"><?php echo $db->f('isshow')==1?'<span style="color:blue;">显示</span>':'<span style="color:gray;">不显示</span>'?></td>
        <td align="center"><a href='?mod=admin_links_type_edit&id=<?php echo $db->f('id')?>'><u>编辑</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="6" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="6"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="linkstype" />
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