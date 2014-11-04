<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句

$page = (int)base::g('page',1);
$pagesize=20;

$sqlt = '';
$qstr = array('mod'=>'admin_news');

$typeid = isset($_REQUEST['typeid'])?(int)$_REQUEST['typeid']:0;
if ($typeid) {
	$childstr = adminpub::gettreechildall($typeid);
	$sqlt .= " and a.typeid in($childstr)";
	$qstr['typeid'] = $typeid;
}

$userid = isset($_REQUEST['userid'])?(int)$_REQUEST['userid']:0;
if ($userid) {
	$sqlt .= " and a.userid='$userid'";
	$qstr['userid'] = $userid;
}

$onlypage = isset($_REQUEST['onlypage'])?$_REQUEST['onlypage']:"";

// 频道页面
$onlypage = ((int)$onlypage)==1?1:0;
$sqlt .= " and a.onlypage='$onlypage'";
$qstr['onlypage'] = $onlypage;

$keyword = isset($_REQUEST['keyword'])?trim($_REQUEST['keyword']):'';
if ($keyword) {
	$sqlt .= " and a.title like '%$keyword%'";
	$qstr['keyword'] = $keyword;
}

$recordcount = $db->get_count("select count(id) from ###_news a where 1=1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_news a where 1=1{$sqlt} order by sortid asc,id desc limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select a.id,a.title,a.addtime,a.typeid,a.userid,a.isshow,a.recommend,a.onlypage,a.sortid,a.hits,b.title typename,a.url,c.username from ###_news a left join ###_newstype b on (a.typeid=b.id) left join ###_admin c on (a.userid=c.id) where a.id in($idcond) order by a.sortid asc,a.id desc";
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
<script type="text/javascript">
$(function(){
	$('#typeid').change(function(){
		window.location.href='?mod=admin_news&typeid='+$('#typeid').val()+'&keyword='+$('#keyword').val()+'&onlypage=<?php echo $onlypage;?>';
	});
	
	$('.darkrow').hover(function(){$(this).addClass('darkrow_out');},function(){$(this).removeClass('darkrow_out');});
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?><?php if ($onlypage==1){echo " [唯一页面]";}?></h1></td>
  </tr>
</table>

<form name="form2" method="post" action="?mod=admin_news">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="top">快速选择栏目：<?php echo adminpub::getartcol($typeid,'默认所有栏目');?>　　搜索：
        <input name="keyword" type="text" id="keyword" size="30" value="<?php echo stripslashes_deep($keyword);?>" maxlength="50">
      <input type="submit" name="button" id="button" value=" 搜  索 ">
      <input name="onlypage" type="hidden" id="onlypage" value="<?php echo $onlypage?>">
      <input name="userid" type="hidden" id="userid" value="<?php echo $userid?>"></td>
    </tr>
  </table>
</form>
<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=40 height=22 align="center">选中</th>
        <th width="60" align="left">排序</th>
        <th align="left">文章标题</th>
        <th align="left">所属栏目</th>
        <th align="left">发布人</th>
        <th width="120">发布时间</th>
        <th width="30">操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"<?php if ($db->f('onlypage')==1){echo " disabled";}?>></td>
        <td><?php echo $db->f('sortid')?></td>
        <td><?php echo $db->f('isshow')==1?'':'<font color="red" title="前台不显示" style="cursor:pointer;">[隐]</font>';?><?php echo $db->f('recommend')==1?'<span style="color:#00F; cursor:pointer;" title="网站推荐">[荐]</span>':'';?><?php if ($db->f("url")!=''){?> <span style="color:#00F; cursor:pointer;" title="外部链接">[链]</span><?php }?><a href="?mod=admin_news_edit&id=<?php echo $db->f('id');?>&r=yes<?php echo base::parse_array(array_slice($qstr,1))?>&page=<?php echo $page;?>"><u><?php echo base::sub_str($db->f('title'),40)?></u></a><span title="访问量" style="cursor:pointer;">(<?php echo $db->f('hits')?>)</span></td>
        <td><a href="?mod=admin_news&typeid=<?php echo $db->f('typeid')."&onlypage=".$onlypage?>"><u><?php echo $db->f('typename')!=''?$db->f('typename'):'未定义栏目';?></u></a></td>
        <td><a href="?mod=admin_news&userid=<?php echo $db->f('userid')."&onlypage=".$onlypage?>"><u><?php echo $db->f('username')!=''?$db->f('username'):'未定义用户';?></u></a></td>
        <td align="center"><?php echo date('Y-m-d H:i',$db->f('addtime'));?></td>
        <td align="center"><a href="?mod=admin_news_edit&id=<?php echo $db->f('id');?>&r=yes<?php echo base::parse_array(array_slice($qstr,1))?>&page=<?php echo $page;?>"><u>修改</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="7" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="7"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="news" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?><?php echo base::parse_array(array_slice($qstr,1))?>&page=<?php echo $page;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit"></div>
<?php echo $pagestr;?>
        </td>
      </tr>
    </tbody> 
  </table>
</form>

<?php if ($onlypage==1) {?>
<table class="helptable" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>提示：唯一页面（即频道页面）不能直接删除，如果确定要删除，请修改文章勾掉“唯一页面”选项后删除。</td>
  </tr>
</table>
<?php }?>

<?php include('bottom.php');?>
</body>
</html>