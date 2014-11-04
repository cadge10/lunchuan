<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = (int)base::g('moduleid');
if ($moduleid <= 0) exit(base::msg('请正确访问此页面。'));

$page = (int)base::g('page',1);
$pagesize=100;

$sqlt = '';
$qstr = array('mod'=>'admin_module_field');

$sqlt .= " AND moduleid='$moduleid'";

$recordcount = $db->get_count("select count(id) from ###_field a where 1=1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_field where 1=1{$sqlt} order by sortid asc,id desc limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select * from ###_field where id in($idcond) order by sortid asc,id desc";
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
          <td><a href="?mod=admin_module_add" class="view"><?php echo adminpub::detailtitle_one('admin_module_add');?></a></td>
          <td><a href="?mod=admin_module" class="view"><?php echo adminpub::detailtitle_one('admin_module');?></a></td>
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_field_add&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one($view.'_add');?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_field&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one($view);?></a></td>
        </tr>
      </table>
  </tr>
</table>


<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=80 height=22 align="center">排序</th>
        <th>字段名</th>
        <th>字段别名</th>
        <th>字段类型</th>
        <th>系统字段</th>
        <th>必填项</th>
        <th>是否启用</th>
        <th>管理操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><span onClick="liuList.edit(this,'field','sortid',<?php echo $db->f('id')?>);"><?php echo $db->f('sortid')?></span></td>
        <td><?php echo $db->f('title')?></td>
        <td><span onClick="liuList.edit(this,'field','name',<?php echo $db->f('id')?>);"><?php echo $db->f('name')?></span></td>
        <td><?php echo $db->f('type')?></td>
        <td align="center"><img src="<?php echo $app_dir;?>images/<?php echo $db->f('issystem')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><img onClick="liuList.staToogle(this,'field','required',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('required')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><img onClick="liuList.staToogle(this,'field','status',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('status')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><a href="?mod=admin_module_field_edit&moduleid=<?php echo $moduleid?>&id=<?php echo $db->f('id')?>"><u>修改</u></a> | <?php if ($db->f('issystem')==1){?><span style="color:#808080;">删除</span><?php }else{?><a href="?mod=delete&table=field&action=admin_module_field_del&delid=<?php echo $db->f('id')?>" onClick="return confirm('您确定要删除吗？该操作不可恢复。')"><u>删除</u></a><?php }?></td>
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