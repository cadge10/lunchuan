<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测是否是终极栏目
$typeid = (int)base::g('typeid');
if ($typeid == 0) die('no');
$count = $db->get_count("select id from `###_producttype` where `typeid`='$typeid'");
if ($count) {
	exit('no'); // 不是最终栏目
} else {
	exit('yes'); // 是最终栏目
}
?>