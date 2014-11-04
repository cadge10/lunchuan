<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = (int)base::g('moduleid');
if ($moduleid<=0) $moduleid = 0;
$formatdata = module::gettypearray(0,$moduleid);
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
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_category_add&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one($view.'_add');?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_category&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one($view);?></a></td>
        </tr>
      </table>
  </tr>
</table>



<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width="75" height="22">编号</th>
        <th >排序</th>
        <th >栏目名称</th>
        <th>所属模型</th>
        <th>是否显示</th>
        <th>操作</th>
      </tr>
<?php
if (count($formatdata)) {
	foreach($formatdata as $tree) {
?>
      <tr class="darkrow"> 
        <td align="center"><?php echo $tree['id']?></td>
        <td align="center"><span onClick="liuList.edit(this,'category','sortid',<?php echo $tree['id']?>);"><?php echo $tree['sortid']?></span></td>
        <td><?php echo str_repeat('　　',$tree['stack'])?><span onClick="liuList.edit(this,'category','title',<?php echo $tree['id']?>);"><?php echo $tree['title']?></span></td>
        <td><?php echo module::get_catetory_module($tree['id'])?></td>
        <td align="center"><img onClick="liuList.staToogle(this,'category','isshow',<?php echo $tree['id']?>)" src="<?php echo $app_dir;?>images/<?php echo $tree['isshow']==1?'yes':'no'?>.gif" /></td>
        <td align="center"><a href="?mod=admin_category_add&parentid=<?php echo $tree['id']?>&moduleid=<?php echo module::get_catetory_module($tree['id'],'id')?>"><u>添加子栏目</u></a> | <a href="?mod=admin_category_edit&id=<?php echo $tree['id']?>&moduleid=<?php echo $moduleid;?>"><u>编辑</u></a> | <a href="?mod=delete&table=category&action=admin_category_del&delid=<?php echo $tree['id']?>&location=admin_category&moduleid=<?php echo $moduleid?>" onClick="return confirm('您确定要删除吗？该操作同时删除此栏目下的所有文章')"><u>删除</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="6" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
    </tbody> 
  </table>
</form>


<?php include('bottom.php');?>
</body>
</html>