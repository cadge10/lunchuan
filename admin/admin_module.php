<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

$page = (int)base::g('page',1);
$pagesize=100;

$sqlt = '';
$qstr = array('mod'=>'admin_module');


$recordcount = $db->get_count("select count(id) from ###_module a where 1=1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_module a where 1=1{$sqlt} order by sortid asc,id desc limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select * from ###_module where id in($idcond) order by sortid asc,id desc";
$db->query($sql);

$pagestr = base::parse_page($qstr);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/transport.js"></script>
<script type="text/javascript" src="admin/images/liulist.js"></script>

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
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_add" class="view"><?php echo adminpub::detailtitle_one($view.'_add');?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module" class="view"><?php echo adminpub::detailtitle_one($view);?></a></td>
        </tr>
      </table>
  </tr>
</table>



<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width="75" height="22">编号</th>
        <th>排序</th>
        <th>模型名称</th>
        <th>模型表名</th>
        <th>模型简介</th>
        <th>前台搜索</th>
        <th>是否启用</th>
        <th>管理操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align="center"><?php echo $db->f('id')?></td>
        <td align="center"><span onClick="liuList.edit(this,'module','sortid',<?php echo $db->f('id')?>);"><?php echo $db->f('sortid')?></span></td>
        <td><span onClick="liuList.edit(this,'module','title',<?php echo $db->f('id')?>);"><?php echo $db->f('title')?></span></td>
        <td><?php echo $db->f('name')?></td>
        <td><?php echo $db->f('description')?></td>
        <td align="center"><img onClick="liuList.staToogle(this,'module','issearch',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('issearch')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><img onClick="liuList.staToogle(this,'module','status',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('status')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><a href="?mod=admin_module_field&moduleid=<?php echo $db->f('id')?>"><u>模型字段</u></a> | <a href="?mod=admin_category&moduleid=<?php echo $db->f('id')?>"><u>栏目管理</u></a> | <a href="?mod=admin_module_edit&id=<?php echo $db->f('id')?>"><u>修改</u></a> | <a href="?mod=delete&table=module&action=admin_module_del&delid=<?php echo $db->f('id')?>" onClick="return confirm('您确定要删除吗？该操作不可恢复。')"><u>删除</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="8" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
    </tbody> 
  </table>
</form>

<?php include('bottom.php');?>
</body>
</html>