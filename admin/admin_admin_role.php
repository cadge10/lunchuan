<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

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
        <th width=60 height=22 align="center"><b>选中</b></th>
        <th width="75"><b>编号</b></th>
        <th ><b>角色名称</b></th>
        <th><b>角色介绍</b></th>
        <th width="80">操作</th>
      </tr>
	<?php
    $sql = "select id,title,content from ###_role order by id asc";
    $db->query($sql);
    if ($db->num_rows()) {
	while ($db->next_record()) {
    ?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <td align="center"><a href="?mod=admin_admin_role_edit&id=<?php echo $db->f('id')?>"><u><?php echo $db->f('title')?></u></a></td>
        <td><?php echo $db->f('content');?></td>
        <td align="center"><a href="?mod=admin_admin_role_edit&id=<?php echo $db->f('id')?>"><u>编辑</u></a></td>
      </tr>
    <?php
	} } else {
	?>
      <tr>
        <td colspan="5" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
    <?php }?>  
      <tr>
        <td colspan="5">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="role" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit">

        </td>
      </tr>
    </tbody> 
  </table>
</form>





<table class="helptable" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>注意：删除角色时同时删除该角色下的所有用户，请谨慎操作。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>