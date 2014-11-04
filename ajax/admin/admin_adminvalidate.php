<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测管理员是否被注册
$username = trim(base::g('username'));
if ($username=='') exit('null');
if (adminpub::adminuservalidate($username)) {
	exit('yes');
} else {
	exit('no');
}
?>