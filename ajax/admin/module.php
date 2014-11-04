<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 验证模块中字段是否唯一，是 true 否 false
$table = strtolower(trim(base::g('table'))); // 验证表名
$field = trim(base::g('field')); // 验证字段
$value = trim(base::g($field)); // 验证值，针对jquery.validate.js

if ($table == '' || $field == '' || $value == '') exit('false');

// 获取数据库表
$all = $db->get_all("SHOW TABLES");
foreach ($all as $v) {
	$t = @$v[0];
	if (strtolower(trim($t)) == DB_PREFIX . $value) exit('false');
}

$count = (int)@$db->get_count("SELECT COUNT(1) FROM `###_{$table}` WHERE `$field`='$value' LIMIT 1");

if ($count<=0) {
	exit('true');
} else {
	exit('false');
}
?>