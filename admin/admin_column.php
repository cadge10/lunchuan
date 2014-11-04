<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$parentid = (int)base::g('parentid');
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
    <td><h1><?php echo adminpub::detailtitle($view);?> ( <?php if ($parentid==0) {?><a href="?mod=admin_column_add">[添加一级栏目]</a><?php }else{?><a href="?mod=admin_column">[一级栏目]</a> <a href="?mod=admin_column_add&parentid=<?php echo $parentid;?>">[添加二级栏目]</a><?php }?> )</h1></td>
  </tr>
</table>

<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=60 height=22 align="center"><b>选中</b></th>
        <th width="75"><b>编号</b></th>
        <th ><b>顺序</b></th>
        <th><b>栏目标题</b></th>
        <th>栏目标识</th>
        <th>是否显示</th>
        <th>操作</th>
      </tr>
	<?php
    $parentid = (int)base::g('parentid');
    $sqlt = '';
    $sqlt = " and parentid='$parentid'";
    $sql = "select id,title,url,isshow,sortid,hidden,topshow,close from ###_admincolumn where 1=1{$sqlt} order by sortid asc,id asc";
    $db->query($sql);
    $data = array();
	if ($db->num_rows()>0) {
    while ($db->next_record()) {
    ?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"<?php echo $db->f('id')==1?" disabled":""?>></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <td align="center"><span onClick="liuList.edit(this,'admincolumn','sortid',<?php echo $db->f('id')?>);"><?php echo $db->f('sortid')?></span></td>
        <td><a href="?mod=admin_column_edit&id=<?php echo $db->f('id')?>"><u><?php echo $db->f('title')?></u></a><?php if ($parentid==0 && $db->f('hidden')==1){?> <span style="color:#C00;">[隐藏二级]</span><?php }?><?php if ($parentid==0 && $db->f('topshow')==1){?> <span style="color:#C00;">[顶部显示]</span><?php }?><?php if ($parentid!=0 && $db->f('close')==1){?> <span style="color:#C00;">[屏蔽功能]</span><?php }?></td>
        <td><?php echo $db->f('url')?></td>
        <td align="center"><img onClick="liuList.staToogle(this,'admincolumn','isshow',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('isshow')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><?php if ($parentid==0) {?><a href="?mod=admin_column&parentid=<?php echo $db->f('id')?>"><u>二级栏目</u></a> | <?php }?><a href="?mod=admin_column_edit&id=<?php echo $db->f('id')?>"><u>编辑</u></a></td>
      </tr>
    <?php } } else {?>
      <tr>
        <td colspan="7" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
    <?php }?>
      <tr>
        <td colspan="7">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="admincolumn" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?>&parentid=<?php echo $parentid;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit">

        </td>
      </tr>
    </tbody> 
  </table>
</form>


<table class="helptable"  cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>注意：删除一级栏目时同时也将删除其所有子栏目，请谨慎操作。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>