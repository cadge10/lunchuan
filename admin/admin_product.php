<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

$sqlt = '';
$qstr = '';

$typeid = isset($_REQUEST['typeid'])?(int)$_REQUEST['typeid']:0;
if ($typeid) {
	$childstr = product::gettreechildall_p($typeid);
	$sqlt .= " and typeid in($childstr)";
	$qstr .= "&typeid=$typeid";
}

$userid = isset($_REQUEST['userid'])?(int)$_REQUEST['userid']:0;
if ($userid) {
	$sqlt .= " and userid='$userid'";
	$qstr .= "&userid=$userid";
}

$keyword = isset($_REQUEST['keyword'])?trim($_REQUEST['keyword']):'';
if ($keyword) {
	$sqlt .= " and title like '%$keyword%'";
	$qstr .= "&keyword=$keyword";
}

$recordcount = $db->get_count("select count(id) from ###_product where 1=1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_product where 1=1{$sqlt} order by id desc limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select * from ###_product where id in($idcond) order by id desc";
$db->query($sql);

$homepage_url = "?mod=admin_product$qstr&page=#homepage#";
$prevpage_url = "?mod=admin_product$qstr&page=#prevpage#";
$nextpage_url = "?mod=admin_product$qstr&page=#nextpage#";
$lastpage_url = "?mod=admin_product$qstr&page=#lastpage#";
$pagenum_url  = "?mod=admin_product$qstr&page=#pagenum#";
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
		window.location.href='?mod=admin_product&typeid='+$('#typeid').val()+'&keyword='+$('#keyword').val();
	});
	
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

<form name="form2" method="post" action="?mod=admin_product">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="top">快速选择栏目：<?php echo product::getartcol_p($typeid,'默认所有栏目');?>　　搜索：
        <input name="keyword" type="text" id="keyword" size="30" value="<?php echo stripslashes_deep($keyword);?>" maxlength="50">
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
        <th width="75">编号</th>
        <th>产品名称</th>
        <th>所属栏目</th>
        <th>发布人</th>
        <th>是否显示</th>
        <th>添加时间</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <td><a href="?mod=admin_product_edit&id=<?php echo $db->f('id').'&r=yes'.$qstr?>&page=<?php echo $page;?>"><u><?php echo base::sub_str($db->f('title'),40)?></u></a><?php echo $db->f('hot')==1?' <span style="color:#00F" title="热销产品">[热]</span>':'';?><?php if ($db->f("url")!=''){?> <span style="color:#00F">[外链]</span><?php }?><?php if ($db->f("video_url")!=''){?> <span style="color:#00F; cursor:pointer;" title="附带视频">[视频]</span><?php }?><?php echo $db->f('recommend')==1?' <span style="color:#00F; cursor:pointer;" title="网站推荐">[荐]</span>':'';?></td>
        <td align="center"><a href="?mod=admin_product&typeid=<?php echo $db->f('typeid')?>"><u><?php echo product::getnewstype_p($db->f('typeid'))?></u></a></td>
        <td align="center"><a href="?mod=admin_product&userid=<?php echo $db->f('userid')?>"><u><?php echo adminpub::getusername($db->f('userid'))?></u></a></td>
        <td align="center"><?php echo $db->f('isshow')==1?'<font color="blue">是</font>':'<font color="gray">否</font>';?></td>
        <td align="center"><?php echo date('Y-m-d H:i:s',$db->f('addtime'));?></td>
        <td align="center"><a href="?mod=admin_product_edit&id=<?php echo $db->f('id').'&r=yes'.$qstr?>&page=<?php echo $page;?>"><u>修改</u></a></td>
      </tr>
<?php } } else {?>   
      <tr>
        <td colspan="8" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="8"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="product" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?><?php echo $qstr?>&page=<?php echo $page;?>" />
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