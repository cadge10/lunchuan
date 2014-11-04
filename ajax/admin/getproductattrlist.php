<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测管理员是否被注册
$typeid = (int)base::g('typeid');
$productid = (int)base::g('productid');
if ($typeid>0) {
	echo product::build_attr_html($typeid,$productid);
} else {
	echo '';
}
?>