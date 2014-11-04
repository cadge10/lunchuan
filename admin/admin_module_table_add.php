<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = (int)base::g('moduleid');
$relation_id = (int)base::g('relation_id');
$relation_table = trim(base::g('relation_table'));
if ($moduleid <= 0) exit(base::msg('请正确访问此页面。'));
$module_data = $db->get_one("SELECT * FROM ###_module WHERE status=1 AND id='$moduleid'");
if (empty($module_data)) exit(base::msg('此模型已经禁止使用，请返回。'));
$table = $module_data['name'];

// 是否允许添加
if ($module_data['isadd']!=1) exit(base::msg('当前模型禁止添加数据，请返回。'));

// 栏目ID
$typeid = (int)base::g('typeid');
if ($typeid>0) {
	$_POST['typeid'] = $typeid;
}


if (base::p("action")) {
	base::issubmit();
	$post_data = isset($_POST) ? $_POST : array();
	if (empty($post_data)) exit(base::msg('您提交的数据为空，请返回。'));
	
	$_POST['title_style'] = '';
	
	if(@$_POST['style_color']) $_POST['style_color'] = 'color:'.$_POST['style_color'].';';
	if(@$_POST['style_bold']) $_POST['style_bold'] =  'font-weight:'.$_POST['style_bold'].';';
	if(@$_POST['style_color'] || @$_POST['style_bold']) $_POST['title_style'] = $_POST['style_color'].$_POST['style_bold'];
	
	$post_data = $_POST;
	
	unset($post_data['action'],$post_data['Submit']);
	unset($post_data['style_color'],$post_data['style_bold']);
	
	$data = module::getFields($table);
	
	$new_data   = array();
	$new_data_k = array();
	$new_data_v = array();
	foreach ($post_data as $k=>$v) {
		if (!array_key_exists($k,$data)) continue;
		
		// 进行一些特有的字符转换
		$mo_data = $db->get_one("SELECT `type`,`required` FROM ###_field WHERE moduleid='$moduleid' AND title='$k'");
		$key = $mo_data[0];
		if ($key == 'datetime') $v = @(int)strtotime($v);
		
		if (is_array($v)) {
			$_v = array();
			foreach ($v as $tmp) {
				if ($tmp=='') continue;
				$_v[] = $tmp;
			}
			$v = implode(',',$_v);
		}
		$new_data["`$k`"] = "'".$v."'";
		$new_data_k[] = "`$k`";
		$new_data_v[] = "'".$v."'";
		if ($mo_data[1] == 1 && $v == '') exit(base::msg('您有必填的项目没有填写，请返回填写。'));
	}
	if (empty($new_data)) exit(base::msg('您提交的数据为空，请返回。'));
	$sql = "INSERT INTO ###_{$table} (".implode(',',$new_data_k).") VALUES (".implode(',',$new_data_v).")";
	
	if ($db->query($sql)) {
		exit(base::alert('数据添加成功，请返回。','?mod=admin_module_table&moduleid='.$moduleid));
	} else {
		exit(base::msg('信息添加失败，请返回检查数据是否合法。'));
	}
}

$sql = "SELECT * FROM ###_field WHERE moduleid='$moduleid' AND status=1 AND `type`<>'relationid' ORDER BY sortid ASC,id DESC";
$field_data = $db->get_all($sql);
if (empty($field_data)) exit(base::msg('此模型还没有设置字段，请返回。'));
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--[if gt IE 8]>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<![endif]-->
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="admin/images/validate.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<link href="js/calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="admin/images/jquery.colorpicker.js"></script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo $module_data['title']?></h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <?php
          if ($module_data['isadd']==1 && !$relation_id) {
		  ?><td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_table_add&moduleid=<?php echo $moduleid?>" class="view">添加数据</a></td><?php
		  }
		  ?>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_table&moduleid=<?php echo $moduleid.($relation_id?'&relation_id='.$relation_id:'').($relation_table?'&relation_table='.$relation_table:'')?>" class="view">数据列表</a></td>
        </tr>
      </table>
  </tr>
</table>


<form action="" method="post" name="form1" id="myform">
<input name="action" type="hidden" id="action" value="add">
<input name="moduleid" type="hidden" id="moduleid" value="<?php echo $moduleid?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <?php
	$form = new form();
    foreach ($field_data as $k=>$v) {
	?>
    <tr>
	  <th width="130" align="left"><?php echo $v['name']?>：</th>
      <td><?php
      echo $form->getform($form,$v);
	  ?></td>
    </tr>
    <?php }?>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>