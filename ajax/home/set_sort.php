<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 设置项目排序
$sort_type = strtolower(trim(base::g('sort'))); // ASC 或 DESC
$name = trim(base::g('name')); // 保存SESSION的前缀
if ($name == "") $name = 'me'; // 如果没有SESSION，默认的前缀
$field = trim(base::g('field'));
$_SESSION['sort'] = NULL; // 每次得到数据前，清空其他的
if ($sort_type=="") {
	$_SESSION['sort'][$name.'_'.$field.'_sort'] = NULL;
} elseif ($sort_type=="desc") {
	$_SESSION['sort'][$name.'_'.$field.'_sort'] = "DESC";
} else {
	$_SESSION['sort'][$name.'_'.$field.'_sort'] = "ASC";
}
exit("success");
?>