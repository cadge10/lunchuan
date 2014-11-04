<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';

// 根据模型ID返回属于该模型下的所有栏目
$parentid = (int)trim(base::g('parentid')); // 模型ID
$moduleid = (int)trim(base::g('moduleid')); // 模型ID
exit(module::getartcol($parentid,'默认一级栏目',$moduleid));
?>