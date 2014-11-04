<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 状态更新
$table = trim(base::g("table"));
$field = trim(base::g("field"));
$key_id = trim(base::g("key_id"));
$key_id_name = trim(base::g("key_id_name",'id'));
$moduleid = trim(base::g("moduleid"));

if ($table == '' || $field == '' || $key_id == '') exit('');


// 在此处添加权限控制
if ($moduleid > 0) {
	$userid = (int)base::s('m_userid');
	// 读取数据库权限
	$one = $db->get_one("select id,roleid,sys,isshow from ###_admin where id='$userid'");
	$roleid = $one[1];
	$sys = $one[2];
	// 获取角色模型权限
	$one = $db->get_one("select id,module_role from ###_role where id='".$one[1]."'");
	$module_role = trim($one[1])!=''?unserialize($one[1]):array();
	// 获取模型表名
	$module_table = @$db->get_count("SELECT `name` FROM ###_module WHERE id='$moduleid'");
	if (isset($module_role[$module_table]['edit']) || $sys==1 || $userid==1) {
		
	} else {
		exit('');
	}
} else {
	// 其他方式控制
	if (!adminpub::getuservalidate(base::s('m_userid'),"admin_{$table}_edit")) {
		exit('');
	}
}

$one = $db->get_one("SELECT $field FROM ###_{$table} WHERE $key_id_name='$key_id'");
if (empty($one)) exit('');

if ($one[$field] == 0) {
	$bool = $db->query("UPDATE ###_{$table} SET $field=1 WHERE $key_id_name='$key_id'");
	if ($bool) {
		exit(WEB_DIR.$app_file.'/images/yes.gif');
	}
} else {
	$bool = $db->query("UPDATE ###_{$table} SET $field=0 WHERE $key_id_name='$key_id'");
	if ($bool) {
		exit(WEB_DIR.$app_file.'/images/no.gif');
	}
}

/**
此功能JS使用方法（需有两张图片：yes.gif和no.gif）：
<img onClick="liuList.staToogle(this,'table','field',id[,key_id])" src="/admin/images/no.gif" />

*/
?>