<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 状态更新
$table = trim(base::g("table"));
$field = trim(base::g("field"));
$key_id = trim(base::g("key_id"));
$key_id_name = trim(base::g("key_id_name",'id'));

if ($table == '' || $field == '' || $key_id == '') exit('');


// 在此处添加权限控制


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