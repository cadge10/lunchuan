<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 设置项目排序
$v = trim(base::g('lang'));
if(!$v)exit('no');
$_SESSION['lang'] = $v;
exit("ok");
?>