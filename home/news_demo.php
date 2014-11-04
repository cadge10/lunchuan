<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 新闻列表例子
$table = trim(base::g('table','news'));
$page = (int)base::g('page',1);
$pagesize=1;
$sqlt = ' AND isshow=1';

// 检查要检索的表是否存在
$get_tables = mo::table_exists($table);
if (!$get_tables) exit(base::msg('您检索的表不存在，请检查后重新操作。'));

// 关键字搜索
$keyword = trim(base::gp('keyword'));
if ($keyword!='') {
	$sqlt .= " AND title LIKE '%$keyword%'";
}

$orderby = "sortid ASC,id DESC"; // 排序

$recordcount = $db->get_count("SELECT COUNT(id) FROM ###_{$table} WHERE 1{$sqlt}"); // 总记录数

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount>0 ? $pagecount : 0;
$currentpage = ($page-1)*$pagesize;

$sql = "SELECT id FROM ###_{$table} WHERE 1{$sqlt} ORDER BY {$orderby} LIMIT $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "SELECT * FROM ###_{$table} WHERE id IN($idcond) ORDER BY {$orderby}";
// 获得数据
$get_data = $db->get_all($sql);

$page_obj = new page($recordcount,$pagesize);
// 分页字符串
$pagestr = $page_obj->show();

print_r($get_data);

echo $pagestr;
?>