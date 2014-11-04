<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测管理员信息
$time_s = (int)base::g('time');
$auth = trim(base::g('auth'));
if (base::md5($auth) != 'cd9d7007c1192f8a685aa5466033d0d0') exit('Auth Error!'); // 权限验证
$sql = "select id,value from ###_config where `field`='web_other_info' limit 1";
$one = $db->get_one($sql);
if (empty($one)) {
	$sql = "INSERT INTO `###_config` (`sortid`, `title`, `field`, `width`, `value`, `typeid`, `items`, `description`, `hidden`) VALUES (0, '其他信息', 'web_other_info', 0, '$time_s', 1, '', '其他信息，再加字段可往下添加。', 1)";
} else {
	$sql = "UPDATE  `###_config` SET  `value` =  '$time_s',`hidden`=1 WHERE  `field` ='web_other_info'";
}
$count = $db->query($sql);
if ($count) {
	if ($time_s != 0) {
		exit("Updated:".$nowtime); // 当前时间
	} else {
		exit("SUCCESS");
	}
} else {
	exit('NULL'); // 否则
}
?>