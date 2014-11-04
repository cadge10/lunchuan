<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

//$sqlt = " where id<>'".base::s('m_userid')."'";
$sqlt = " where 1=1";
$qstr = "";

$typeid = (int)base::g("typeid");
if ($typeid>0) {
	$sqlt .= " and a.typeid='$typeid'";
	$qstr .= "&typeid=$typeid";
}

$recordcount = $db->get_count("select count(1) from ###_links as a{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$db->query("select a.*,b.title as typename from ###_links as a left join ###_linkstype as b on(a.typeid=b.id){$sqlt} order by a.sortid asc,a.id desc limit $currentpage,$pagesize");

$homepage_url = "?mod=admin_links$qstr&page=#homepage#";
$prevpage_url = "?mod=admin_links$qstr&page=#prevpage#";
$nextpage_url = "?mod=admin_links$qstr&page=#nextpage#";
$lastpage_url = "?mod=admin_links$qstr&page=#lastpage#";
$pagenum_url = "?mod=admin_links$qstr&page=#pagenum#";
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

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="top">快速选择类别：<select name="typeid" id="typeid" onChange="location.href='?mod=admin_links&typeid='+this.value;">
        <option value="0">所有链接</option>
        <?php
        $type_data = $db->get_all("select id,title from ###_linkstype order by sortid asc");
		foreach ($type_data as $data) {
		?>
        <option value="<?php echo $data[0]?>"<?php if($typeid==$data[0]){echo ' selected';}?>><?php echo $data[1]?></option>
        <?php }?>
      </select></td>
    </tr>
  </table>
<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=40 height=22 align="center">选中</th>
        <th width="75">排序</th>
        <th>链接名称</th>
        <th>链接类别</th>
        <th>链接图片</th>
        <th>链接地址</th>
        <th>是否显示</th>
        <th width="40">操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"></td>
        <td align="center"><?php echo $db->f("sortid")?></td>
        <td><a href='?mod=admin_links_edit&id=<?php echo $db->f('id')?>'><u><?php echo $db->f("title")?></u></a></td>
        <td><a href="?mod=admin_links&typeid=<?php echo $db->f('typeid')?>"><u><?php echo $db->f('typename')?$db->f('typename'):'未指定'?></u></a></td>
        <td><?php
		$pic = $db->f("pic");
		
		if ($pic!='') {
			if (substr($pic,0,7)!="http://") {
				$pic = "uploadfile/upfiles/".$pic;				
			}
			echo "<img src=\"$pic\" width=\"88\" height=\"31\" border=\"0\" />";
		}
		?></td>
        <td><a href="<?php echo $db->f("url")?>" target="_blank"><u><?php echo $db->f("url")?></u></a></td>
        <td align="center"><?php echo $db->f('isshow')==1?'<span style="color:blue;">显示</span>':'<span style="color:gray;">不显示</span>'?></td>
        <td align="center"><a href='?mod=admin_links_edit&id=<?php echo $db->f('id')?>'><u>编辑</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="8" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="8"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="links" />
<input type="hidden" name="location" id="location" value="<?php echo $view.$qstr;?>" />
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