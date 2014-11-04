<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$typeid = (int)base::g('typeid');
if ($typeid<0) exit(base::alert('请正确访问此页面。'));

$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;
if ($typeid>0) {
	$sqlt = " where typeid='$typeid'";
} else {
	$sqlt = "";
}
$recordcount = $db->get_count("select count(1) from ###_productattribute{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$db->query("select * from ###_productattribute{$sqlt} order by sortid asc,id asc limit $currentpage,$pagesize");

$homepage_url = "?mod=admin_productattribute&page=#homepage#";
$prevpage_url = "?mod=admin_productattribute&page=#prevpage#";
$nextpage_url = "?mod=admin_productattribute&page=#nextpage#";
$lastpage_url = "?mod=admin_productattribute&page=#lastpage#";
$pagenum_url = "?mod=admin_productattribute&page=#pagenum#";
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
function changType(values) {
	location.href='?mod=admin_product_attribute&typeid='+values;
}

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
          <td><a href="?mod=admin_product_attribute_add&typeid=<?php echo $typeid;?>" class="view">添加属性</a></td>
          <td class="active"><a href="?mod=admin_product_attribute&typeid=<?php echo $typeid;?>" class="view">修改属性</a></td>
        </tr>
      </table>
    </td>

  </tr>
</table>


<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>按产品类型显示：<select name="attributeid" id="attributeid" onChange="changType(this.value)">
        <option value="0">显示全部类型</option>
        <?php
        $re = $db->query("select id,title from ###_productptype order by sortid asc,id asc",false);
		while ($rs = $db->fetch_array($re)) {
		?>
        <option value="<?php echo $rs[0]?>"<?php echo $rs[0]==$typeid?' selected':'';?>><?php echo $rs[1]?></option>
        <?php }?>
      </select></td>
    </tr>
  </table>
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=60 height=22 align="center">选中</th>
        <th width="75">排序</th>
        <th>属性名称</th>
        <th>商品类型</th>
        <th>属性值的录入方式</th>
        <th>可选值列表</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f("id")?>"></td>
        <td align="center"><?php echo $db->f("sortid")?></td>
        <td><a href='?mod=admin_product_attribute_edit&typeid=<?php echo $db->f('typeid')?>&id=<?php echo $db->f('id')?>'><u><?php echo $db->f("title")?></u></a></td>
        <td align="center"><?php echo product::get_product_type($db->f('typeid'))?></td>
        <td align="center"><?php echo product::get_attr_input_type($db->f('attrinputtype'))?></td>
        <td align="center"><?php echo product::replace_crlf($db->f('attrvalue'))?></td>
        <td align="center"><a href='?mod=admin_product_attribute_edit&typeid=<?php echo $db->f('typeid')?>&id=<?php echo $db->f('id')?>'><u>编辑</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="7" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="7"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="productattribute" />
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