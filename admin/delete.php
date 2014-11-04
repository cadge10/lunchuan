<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 处理页面

base::issubmit();
$location = trim(base::p('location'))!=""?trim(base::p('location')):trim(base::g('location')); // 优先使用POST方式获取处理后跳转的地址
if ($location!="") {
	$location = "admincp.php?mod=".$location;
}
$table = trim(base::p('table')); // 表名
if ($table == '') $table = trim(base::g('table')); // get方式获取表名
$fld = trim(base::p('fld')); // 条件字段
if ($fld == '') $fld = trim(base::g('fld')); // get方式获取条件字段
if ($fld =='') $fld = 'id';
$chk = base::p('chk'); // 被选中的项目ID
$delid = (int)base::g('delid'); // 删除单个时选择的ID
if (!is_array($chk) && !$delid) {
	exit(base::alert('请选择要删除的项目！'));
}
if (!$table) {
	exit(base::alert('数据库表错误！'));
}
if (is_array($chk)) {
	$qstr = implode(',',$chk);
} else {
	$qstr = $delid;
}
switch ($table) {
	case 'admincolumn' :
	// 非创始人不能删除
	if ((int)base::s('m_userid') != 1) exit(base::alert('对不起，您没有权限执行删除操作！'));
	$db->query("delete from ###_{$table} where parentid in($qstr)");
	break;
	
	case 'role' :
	$db->query("delete from ###_admin where roleid in($qstr)");
	break;
	
	case 'newstype' :
	$one = $db->get_one("select id from ###_newstype where typeid='$qstr' limit 1");
	if ($one) exit(base::alert('请删除所有子栏目后再删除此栏目！'));
	// 删除所有文章
	$db->query("delete from ###_news where typeid='$qstr'");
	break;
	
	case 'linkstype' :
	$db->query("delete from ###_links where typeid in($qstr)");
	break;
	
	case 'producttype' :
	$one = $db->get_one("select id from ###_producttype where typeid='$qstr' limit 1");
	if ($one) exit(base::alert('请删除所有子栏目后再删除此栏目！'));
	// 删除所有产品
	$db->query("delete from ###_product where typeid='$qstr'");
	break;
	
	case 'productptype' :
	$db->query("delete from ###_productattribute where typeid in($qstr)");
	break;
	
	// 以下字段针对模型使用===================================================================
	case 'module' :
	// 非创始人不能删除
	if ((int)base::s('m_userid') != 1) exit(base::alert('对不起，您没有权限执行删除操作！'));
	
	$cou = @$db->get_count("SELECT COUNT(1) FROM ###_category WHERE moduleid='$qstr'");
	// 删除模型前，须把栏目也删除
	if ($cou>0) exit(base::alert('该模型下有栏目，请删除所有栏目后再删除模型！'));
	
	$module = new module();
	$module->delete_module($qstr);
	break;
	
	case 'field' :
	// 非创始人不能删除
	if ((int)base::s('m_userid') != 1) exit(base::alert('对不起，您没有权限执行删除操作！'));
	// 系统字段不能删除
	$one = $db->get_one("SELECT a.title,a.issystem,b.name FROM ###_field AS a,###_module AS b WHERE a.moduleid=b.id AND a.id='$qstr'");
	if (empty($one)) exit(base::alert('请选择要删除的项目！'));
	if ($one['issystem']==1) {
		exit(base::alert('对不起，您无法删除系统字段！'));
		exit();
	}
	// 删除字段
	$field = $one['title'];
	$name = $one['name'];
	@$db->query("ALTER TABLE ###_".$name." DROP `$field`");
	break;
	
	case 'category' :
	$location = $location.'&moduleid='.(int)base::gp('moduleid');
	$one = $db->get_one("select id from ###_category where typeid='$qstr' limit 1");
	if ($one) exit(base::alert('请删除所有子栏目后再删除此栏目！'));
	
	// 删除栏目是，要检查模型表里是否有数据，如果有，不允许删除（安全起见）。
	$name = @$db->get_count("SELECT b.name FROM ###_category AS a LEFT JOIN ###_module AS b ON(b.id=a.moduleid) WHERE a.id='$qstr'");
	if (!$name) continue;
	
	// 删除所有数据
	$db->query("delete from ###_{$name} where typeid='$qstr'");

	break;
	// 以下字段针对模型使用结束================================================================
	
	case '' :
	
	break;
}

// 清理所有关联数据
$relation_id = (int)base::gp('relation_id');
$relation_table = trim(base::gp('relation_table'));
$moduleid = (int)base::gp('moduleid');
if (!$relation_id && $relation_table && trim(base::gp('action'))=='admin_module_table_del') {
	$_sql = "DELETE FROM ###_{$relation_table} WHERE relation_id IN ($qstr)";
	$db->query($_sql,false);
}

$db->query("delete from ###_{$table} where {$fld} in($qstr)");
exit(base::alert('已经删除，请返回！',$location));
?>