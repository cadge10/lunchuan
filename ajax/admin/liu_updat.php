<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// AJAX更新数据

$table = trim(base::g("table"));
$field = trim(base::g("field"));
$value = trim(base::g("value"));
$key_id = trim(base::g("key_id"));
$key_id_name = trim(base::g("key_id_name",'id'));
$moduleid = trim(base::g("moduleid"));

$data = array("message"=>"传送的数据不全","error"=>-1,"content"=>"");

if ($table == '' || $field == '' || $key_id == '')
if ($value == '') {
	$data['message'] = '值不能为空';
	exit(json_encode($data));
}

// 在此处添加权限控制
if ($moduleid > 0) {
	// 模型控制
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
		$data['message'] = '您没有权限更新数据。';
		exit(json_encode($data));
	}
} else {
	// 其他方式控制
	if (!adminpub::getuservalidate(base::s('m_userid'),"admin_{$table}_edit")) {
		$data['message'] = '您没有权限更新数据。';
		exit(json_encode($data));
	}
}

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