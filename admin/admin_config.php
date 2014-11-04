<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$table = "_config"; // 去掉前缀的表名，要保证和文件名相同
if (base::p('action')=='add') {
	base::issubmit();
	$re = $db->query("select id from ###{$table} where `hidden`=0",false);
	while ($rs = $db->fetch_array($re)) {
		$value = base::p('items_'.$rs[0]);
		$sql = "update ###{$table} set `value`='$value' where id='".$rs[0]."'";
		$db->query($sql,false);
	}
	exit(base::alert('更新成功，请返回！','?mod=admin'.$table));
}

$group_data = $db->get_all("SELECT groupname FROM ###_config GROUP BY groupname");

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script></head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1">
<input name="action" type="hidden" id="action" value="add">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="tabstyle">
	<?php
	$count = count($group_data);
    foreach ($group_data as $g=>$group) {
    ?>
    <div<?php echo $g==0?' class="current"':'';?> id="tab_btn_<?php echo $g;?>" onClick="tabit(this,<?php echo $count;?>);"><?php echo $group[0]?></div>
    <?php }?>
    </td>
  </tr>
</table>
<?php
foreach ($group_data as $g=>$group) {
?>
<div id="tab_div_<?php echo $g;?>"<?php if ($g>0){echo ' style="display:none;"';}?>>
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <?php
    $all = $db->get_all("select * from ###{$table} where `hidden`=0 and groupname='".$group[0]."' order by sortid asc");
	foreach ($all as $k=>$v) {
		$content = '';
		$typeid = $v['typeid'];
		switch($typeid) {
			case 1:
			$content .= '<input type="text" name="items_'.$v['id'].'" id="items_'.$v['id'].'" value="'.$v['value'].'"'.($v['width']>0?' style="width:'.$v['width'].'px;"':'').' />';
			break;
			case 2:
			$content .= '<textarea name="items_'.$v['id'].'" id="items_'.$v['id'].'" cols="45" rows="5"'.($v['width']>0?' style="width:'.$v['width'].'px;"':'').'>'.$v['value'].'</textarea><br />';
			break;
			case 3:
			$item = $v['items'];
			$arr = explode('|',$item);
			$_i = 1;
			foreach ($arr as $temp) {
				$info = explode('#####',$temp);
				$content .= '<input type="radio" name="items_'.$v['id'].'" id="items_'.$v['id'].'" value="'.$info[1].'"'.($info[1]==$v['value']?' checked':'').' /> '.$info[0].' ';
				if ($_i % 5 == 0) $content .= '<br />';
				$_i++;
			}
			break;
			case 4:
			$content .= '<div style="float:left;"><input type="text" class="input" name="items_'.$v['id'].'" id="items_'.$v['id'].'" value="'.$v['value'].'"'.($v['width']>0?' style="width:'.$v['width'].'px;"':'').' title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="50">
		</div>
		<div style="float:left; padding-left:7px;"><iframe src="includes/upload.php?name=items_'.$v['id'].'" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部图片，必须以http://开头。</div>';
			break;
			//5,6
			default:
			$content .= '未知类型';
			break;
		}
	?>
    <tr>
	  <th width="130" align="left"><?php echo $v['title']?>：</th>
      <td><?php echo $content?><span title="对应的字段名称" style="cursor:pointer;">[<?php echo $v['field']?>]</span><?php if ($v['description'] != ''){echo ' * '.$v['description'];}?></td>
    </tr>
    <?php }?>
  </tbody> 
</table>
</div>
<?php }?>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>