<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测管理员是否被注册
$id = (int)base::g('id');
$attr_group = (int)base::g('attr_group');
if ($id>0) {
	$one = $db->get_one("select attr_group from ###_productptype where id='$id'");
	if (!empty($one)) {
		$attr_groups = explode("\n", str_replace("\r", '', $one[0]));  // 分组
		$str = '';
		foreach ($attr_groups as $key=>$value) {
			if ($value=='') continue;
			$selected = '';
			if ($attr_group == $key) {
				$selected = ' selected';
			}
			$str .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
		}
		exit($str);
	} else {
		exit('');
	}
} else {
	exit('');
}
?>