<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$page = isset($_GET['page'])?$_GET['page']:1;
$pagesize=20;

$sqlt = " where id<>'".base::s('m_userid')."' and id<>1";
$recordcount = $db->get_count("select count(id) from ###_admin{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$db->query("select id,username,addtime,ip,lasttime,isshow from ###_admin{$sqlt} order by id desc limit $currentpage,$pagesize");

$homepage_url = "?mod=admin_admin&page=#homepage#";
$prevpage_url = "?mod=admin_admin&page=#prevpage#";
$nextpage_url = "?mod=admin_admin&page=#nextpage#";
$lastpage_url = "?mod=admin_admin&page=#lastpage#";
$pagenum_url = "?mod=admin_admin&page=#pagenum#";
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
  </tr>
</table>


<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=60 height=22 align="center"><b>选中</b></th>
        <th><b>管理员名</b></th>
        <th><b>注册时间</b></th>
        <th>所属角色</th>
        <th>最后登录IP</th>
        <th>上次登录时间</th>
        <th>登录权限</th>
        <th>文章数</th>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"<?php echo $db->f('id')==1?" disabled":""?>></td>
        <td><a href='?mod=admin_admin_edit&id=<?php echo $db->f('id')?>'><u><?php echo $db->f('username')?></u></a></td>
        <td align="center"><?php echo date('Y-m-d H:i:s',$db->f('addtime'));?></td>
        <td align="center"><?php echo adminpub::getuserrolename($db->f('id'))?></td>
        <td align="center"><?php echo $db->f('ip')?></td>
        <td align="center"><?php echo $db->f('lasttime')>0?date('Y-m-d H:i:s',$db->f('lasttime')):'<span style="color:grey">暂未登录</span>';?></td>
        <td align="center"><img onClick="liuList.staToogle(this,'admin','isshow',<?php echo $db->f('id')?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('isshow')==1?'yes':'no'?>.gif" /></td>
        <td align="center"><a href="?mod=admin_news&userid=<?php echo $db->f('id')?>"><u><?php echo adminpub::getuserarticlecount($db->f('id'))?></u></a></td>
        <td align="center"><a href='?mod=admin_admin_edit&id=<?php echo $db->f('id')?>'><u>编辑</u></a></td>
      </tr>
<?php } } else {?>      
      <tr>
        <td colspan="9" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>      
      <tr>
        <td colspan="9"><div id="list_form_style">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="admin" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit"></div>
<?php echo $pagestr;?>
        </td>
      </tr>
    </tbody> 
  </table>
</form>





<table class="helptable" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>注意：当前登录账户不在此处显示，如修改信息请点击头部“<a href="?mod=admin_info" style="color:#F00;">个人账户管理</a>”进行修改。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>