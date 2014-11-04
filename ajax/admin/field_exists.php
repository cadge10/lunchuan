<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 验证模块中字段是否唯一，是 true 否 false
$table = strtolower(trim(base::g('table'))); // 验证表名
$field = trim(base::g('field')); // 验证字段
$value = trim(base::g($field)); // 验证值，针对jquery.validate.js
$oldfield = trim(base::g('oldfield'));
$moduleid = (int)base::g('moduleid');

if ($table == '' || $field == '' || $value == '') exit('false');

// 获取数据库表字段
$all = getFields($table);
foreach ($all as $k=>$v) {
	$t = @$k;
	if (strtolower(trim($t)) == $value && strtolower(trim($t)) != $oldfield) exit('false');
}
//*/

$count = (int)@$db->get_count("SELECT COUNT(1) FROM `###_{$table}` WHERE `$field`='$value' AND `$field`<>'$oldfield' AND moduleid='$moduleid' LIMIT 1");

if ($count<=0) {
	exit('true');
} else {
	exit('false');
}

function getFields($tableName) {
	$result =   $GLOBALS['db']->get_all('SHOW COLUMNS FROM ###_'.$tableName);
	$info   =   array();
	if($result) {
		foreach ($result as $key => $val) {
			$info[$val['Field']] = array(
				'name'    => $val['Field'],
				'type'    => $val['Type'],
				'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
				'default' => $val['Default'],
				'primary' => (strtolower($val['Key']) == 'pri'),
				'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
			);
		}
	}
	return $info;
}
?>