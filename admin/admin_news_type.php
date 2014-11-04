<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$formatdata = adminpub::getnewstypearray();
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
        <th width="75" height="22"><b>编号</b></th>
        <th ><b>栏目名称</b></th>
        <th><b>文章总数</b></th>
        <th>是否显示</th>
        <th>外部链接</th>
        <th>操作</th>
      </tr>
<?php
if (count($formatdata)) {
	foreach($formatdata as $tree) {
?>
      <tr class="darkrow"> 
        <td align="center"><?php echo $tree['id']?></td>
        <td><?php echo str_repeat('　　',$tree['stack'])?><?php echo $tree['sortid']?>、<?php echo $tree['title']?></td>
        <td align="center"><a href="?mod=admin_news&typeid=<?php echo $tree['id'];?>"><u><?php echo adminpub::gettypenewsdall($tree['id'])?></u></a></td>
        <td align="center"><?php if ($tree['isshow']==1) {?><font color="#0000FF">显示</font><?php }else {?><font color="#808080">不显示</font><?php }?></td>
        <td><?php echo $tree['url']?></td>
        <td align="center"><a href="?mod=admin_news_type_add&parentid=<?php echo $tree['id']?>"><u>添加子栏目</u></a> | <a href="?mod=admin_news_type_edit&id=<?php echo $tree['id']?>"><u>编辑</u></a> | <a href="?mod=delete&table=newstype&action=admin_news_type_del&delid=<?php echo $tree['id']?>" onClick="return confirm('您确定要删除吗？该操作同时删除此栏目下的所有文章')"><u>删除</u></a></td>
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