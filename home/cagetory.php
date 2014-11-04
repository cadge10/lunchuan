<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 新闻列表例子
$file_title = '行业资讯';

$table = trim(base::g('table','news'));

//最新资讯
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 12";
$new = $db->get_all($sql);

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 1 LIMIT 1";
$banner = $db->get_one($sql);

//分类信息
$id = base::gp('id',0);
if($id <= 0)exit(base::msg('参数传递错误'));
$sql    =   "SELECT * FROM ###_newstype WHERE id = ".$id;
$info   =   $db->get_one($sql);
if(!$info)exit(base::msg('数据已删除'));

$table = trim(base::g('table','news'));
$page = (int)base::g('page',1);
$pagesize=22;
$sqlt = ' AND isshow=1';
$type = pub::get_child_newstype($id);
$str  = implode(',',$type);
$sqlt .= " AND typeid in ($str) ";

$orderby = "sortid ASC,id DESC"; // 排序

$sql = "SELECT COUNT(id) FROM ###_{$table} WHERE 1{$sqlt}";
$recordcount = $db->get_count($sql); // 总记录数

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount>0 ? $pagecount : 0;
$currentpage = ($page-1)*$pagesize;

$sql = "SELECT id FROM ###_{$table} WHERE 1{$sqlt} ORDER BY {$orderby} LIMIT $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "SELECT * FROM ###_{$table} WHERE id IN($idcond) ORDER BY {$orderby}";
$get_data = $db->get_all($sql);
// 分页字符串
$page_obj = new page($recordcount,$pagesize);
$pagestr = $page_obj->show();

$here = "<a href=''>".$info['title']."</a>";

$tpl->assign('file_title',$file_title);
$tpl->assign('new',$new);
$tpl->assign('banner',$banner);
$tpl->assign('info',$info);
$tpl->assign('get_data',$get_data);
$tpl->assign('pagestr',$pagestr);
$tpl->assign('here',$here);
?>