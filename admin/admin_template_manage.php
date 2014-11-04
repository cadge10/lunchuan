<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$template_url = "templates";
$current_theme = trim(base::g('theme','default'));

$dirname = trim(base::g('dirname'));

if (base::g('act') == 'del') {
	base::issubmit();
	if ($dirname != '') {
		$_dirname = $dirname.'/';
	}
	@unlink(__ROOT__.'/'.$template_url.'/'.$current_theme.'/'.$_dirname.base::g('filename'));
}

$cfg_templets_dir = __ROOT__.'/'.$template_url;
$templetdir  = $cfg_templets_dir; // 模板路径
$templetdird = $templetdir.'/'.$current_theme; // 当前模板的路径
$templeturld = WEB_DIR.$template_url.'/'.$current_theme; // 当前模板的绝对目录

if ($dirname != '') {
	$templetdird = $templetdird.'/'.$dirname; // 当前模板的绝对目录
}

if(ereg("\.",$current_theme))
{
	exit(base::msg('Not Allow dir '.$current_theme.'!'));
}

//获取默认文件说明信息
function GetInfoArray($filename)
{
	$arrs = array();
	$dlist = file($filename);
	foreach($dlist as $d)
	{
		$d = trim($d);
		if($d!='')
		{
			list($dname,$info) = explode(',',$d);
			$arrs[$dname] = $info;
		}
	}
	return $arrs;
}

$fileinfos = @GetInfoArray($templetdird.'/file_memo.inc');
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/lhgDialog/lhgcore.dialog.min.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>

<?php if (base::g('act') == 'edit') {
	if (base::p('action') == 'add') {
		base::issubmit();
		$title = trim(base::p('title'));
		$oldtitle = trim(base::p('oldtitle'));
		$content = stripslashes_deep(base::p('content'));
		if ($title == '') $title = 'oldtitle';
		
		// 删除原来的，暂不删除
		//@unlink($templetdird.'/'.$oldtitle);
		// 重写
		file_put_contents($templetdird.'/'.$title,$content);
		
		exit(base::alert('修改成功，请返回。','javascript:parent.location.reload();'));
	}

$file_c = $templetdird.'/'.trim(base::g('filename'));
if (!file_exists($file_c)) {
	exit(base::msg('该模板文件不存在，请返回。','javascript:parent.location.reload();'));
}
$file_content = @file_get_contents($file_c);
?>

<form action="" method="post" name="form1" id="form1">
<input name="action" type="hidden" id="action" value="add">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">模板文件名：</th>
      <td><input type="hidden" id="oldtitle" name="oldtitle" size="50" value="<?php echo trim(base::g('filename'));?>" /><input type="text" id="title" name="title" size="50" value="<?php echo trim(base::g('filename'));?>" />         * 只能是英文文件名，请不要在前面加../之类的目录。</td>
    </tr>
    <tr>
      <td colspan="2"><textarea name="content" id="content" cols="45" rows="5" style="width:100%; height:500px;"><?php echo $file_content;?></textarea></td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="保　存" class="submit">
  <input type="button" name="Submit2" value="不做修改，返回" onClick="parent.location.reload();">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php exit();}?>

当前模板：<span style="color:blue;"><?php echo $current_theme;?></span>　<?php if ($dirname!=''){?>
<a href="?mod=admin_template_manage&theme=<?php echo $current_theme;?>">返回模板主目录</a><?php }?>
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
      <tr> 
        <th height="22">文件名</th>
        <th>文件描述</th>
        <th>修改时间</th>
        <th width="90">操作</th>
      </tr>
   <?php
   $dh = dir($templetdird);
   $m_count = 0;
   while($filename=$dh->read())
   {
	  if ($filename=='.' || $filename=='..') continue;
   	  if(!ereg("\.html|\.htm|\.php|\.tpl",$filename) && (!is_dir($templetdir.'/'.$current_theme.'/'.$filename) || $filename!='libs')) continue;
   	  $filetime = filemtime($templetdird.'/'.$filename);
      $filetime = date("Y-m-d H:i",$filetime);
	  if (!is_dir($templetdir.'/'.$current_theme.'/'.$filename)) {
      	$fileinfo = (isset($fileinfos[$filename]) ? $fileinfos[$filename] : '未知模板');
	  } else {
		$fileinfo = '';
	  }
   ?>
      <tr class="darkrow"> 
        <td style="font-family:Arial, 宋体;"><?php echo $filename; ?></td>
        <td align="center"><?php echo $fileinfo;?></td>
        <td align="center"><?php echo $filetime; ?></td>
        <td align="center"><?php if (is_dir($templetdir.'/'.$current_theme.'/'.$filename)){?>
		<a href='?mod=admin_template_manage&theme=<?php echo $current_theme; ?>&dirname=<?php echo $filename;?>&filename=<?php echo $filename; ?>'><u>进入目录</u></a>
		<?php }else{?><a style="cursor:pointer;" onClick="openDialog('?mod=admin_template_manage&act=edit&theme=<?php echo $current_theme; ?>&dirname=<?php echo $dirname;?>&filename=<?php echo $filename; ?>','修改模板',800,500);"><u>修改</u></a>
			<?php
			if(!isset($fileinfos[$filename]))
			{
			?>
			 | 
			<a href='?mod=admin_template_manage&act=del&theme=<?php echo $current_theme;?>&dirname=<?php echo $dirname;?>&filename=<?php echo $filename;?>' onClick="if (!confirm('您确定要删除吗？该操作不可恢复。')){return false;}"><u>删除</u></a>
			<?php
		   } else {
			   echo ' | <span style="color:gray">删除</span>';
		   }
			?><?php }?></td>
      </tr>
   <?php $m_count++;}
   if ($m_count <= 0) {
   ?>
      <tr>
        <td colspan="4" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
   <?php }?>
  </tbody> 
</table>




<table class="listtable" cellpadding="0" cellspacing="0" border="0" width="100%" style="display:none;">
  <tr>
    <td>[新建模板]　[上传模板]</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>