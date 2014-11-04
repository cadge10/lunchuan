<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// AJAX更新数据

$table = trim(base::g("table"));
$field = trim(base::g("field"));
$value = trim(base::g("value"));
$key_id = trim(base::g("key_id"));
$key_id_name = trim(base::g("key_id_name",'id'));

$data = array("message"=>"传送的数据不全","error"=>-1,"content"=>"");

if ($table == '' || $field == '' || $key_id == '')
if ($value == '') {
	$data['message'] = '值不能为空';
	exit(json_encode($data));
}

// 在此处添加权限控制

$bool = $db->query("UPDATE ###_{$table} SET $field='$value' WHERE $key_id_name='$key_id'");
if ($bool) {
	$data['message'] = '';
	$data['error'] = 0;
	$data['content'] = $value;
} else {
	$data['message'] = '数据无法更新，请检查';
}

exit(json_encode($data));

/**
此功能JS使用方法：
<span onClick="liuList.edit(this,'table','field',id[,key_id]);">value</span>

*/
?>