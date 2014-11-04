<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '供求信息';

$table = trim(base::g('table','information'));
$page = (int)base::g('page',1);
$pagesize=15;

$type = base::g('type',1);

$sqlt = " AND i.ttype = ".$type;
$orderby = "i.id DESC"; // 排序

$code = base::g('code','');
if($code != ''){
    $sqlt .= " AND i.city = ".$code;
}
$cp = base::g('cp','');
if($cp != ''){
    $sqlt .= " AND i.mingcheng = '".$cp."'";
}

$sql = "SELECT COUNT(i.id) FROM ###_{$table} i WHERE 1{$sqlt}";
$recordcount = $db->get_count($sql); // 总记录数

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount>0 ? $pagecount : 0;
$currentpage = ($page-1)*$pagesize;

$sql = "SELECT i.id FROM ###_{$table} i WHERE 1{$sqlt} ORDER BY {$orderby} LIMIT $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "SELECT i.*,c.name FROM ###_{$table} i LEFT JOIN ###_city c ON (c.code = i.city) WHERE i.id IN($idcond) ORDER BY {$orderby}";
$get_data = $db->get_all($sql);
// 分页字符串
$page_obj = new page($recordcount,$pagesize);
$pagestr = $page_obj->show();

//地区
$sql    =   "SELECT * FROM (SELECT c.name,i.city,count(i.city) tot FROM ###_$table i LEFT JOIN ###_city c ON (c.code = i.city) WHERE 1 GROUP BY i.city) lin ORDER BY tot LIMIT 10";
$city   =   $db->get_all($sql);

//产品
$sql    =   "SELECT * FROM (SELECT i.mingcheng,count(i.mingcheng) tot FROM ###_$table i  WHERE 1 GROUP BY i.mingcheng) lin ORDER BY tot LIMIT 10";
$product   =   $db->get_all($sql);


$tpl->assign('file_title',$file_title);
$tpl->assign('get_data',$get_data);
$tpl->assign('pagestr',$pagestr);
$tpl->assign('city',$city);
$tpl->assign('product',$product);
?>