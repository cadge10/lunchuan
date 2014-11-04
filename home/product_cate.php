<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 新闻列表例子
$file_title = '商品中心';

$table = trim(base::g('table','product'));

//最新资讯
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_news WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 12";
$new = $db->get_all($sql);

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 8 LIMIT 1";
$banner = $db->get_one($sql);

$table = trim(base::g('table','product'));
$page = (int)base::g('page',1);
$pagesize=10;
$sqlt = ' AND p.isshow=1';

//分类信息
$id = base::g('id',0);
if($id > 0){
    $type = product::get_child_producttype($id);
    $str  = implode(',',$type);
    $sqlt .= " AND p.typeid in ($str) ";
    $sql = "SELECT id,title FROM ###_producttype WHERE id = ".$id;
    $info = $db->get_one($sql);
    $here = "<a href='?mod=product'>商品中心</a> > <a href=''>".$info['title']."</a>";
    $file_title = $info['title'].'-'.$file_title;
}else{
    $here = "<a href='?mod=product'>商品中心</a>";
}

//地区
$code = base::g('code','');
if($code != ''){
    $sqlt .= " AND p.code = '".$code."'";
}

$orderby = "p.id DESC"; // 排序

$sql = "SELECT COUNT(p.id) FROM ###_{$table} p WHERE 1{$sqlt}";
$recordcount = $db->get_count($sql); // 总记录数

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount>0 ? $pagecount : 0;
$currentpage = ($page-1)*$pagesize;

$sql = "SELECT p.id FROM ###_{$table} p WHERE 1{$sqlt} ORDER BY {$orderby} LIMIT $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "SELECT p.*,t.title tname,c.name FROM ###_{$table} p LEFT JOIN ###_producttype t ON (t.id = p.typeid) LEFT JOIN ###_city c ON (c.code = p.city) WHERE p.id IN($idcond) ORDER BY {$orderby}";
$get_data = $db->get_all($sql);
// 分页字符串
$page_obj = new page($recordcount,$pagesize);
$pagestr = $page_obj->show();

//地区
$sql    =   "SELECT * FROM (SELECT c.name,i.city,count(i.city) tot FROM ###_$table i LEFT JOIN ###_city c ON (c.code = i.city) WHERE 1 GROUP BY i.city) lin ORDER BY tot LIMIT 10";
$city   =   $db->get_all($sql);

//分类
$sql    =   "SELECT * FROM (SELECT t.title,i.typeid id,count(i.typeid) tot FROM ###_$table i LEFT JOIN ###_producttype t ON (t.id = i.typeid)  WHERE 1 GROUP BY i.typeid) lin ORDER BY tot LIMIT 10";
$type   =   $db->get_all($sql);

$tpl->assign('file_title',$file_title);
$tpl->assign('new',$new);
$tpl->assign('city',$city);
$tpl->assign('id',$id);
$tpl->assign('code',$code);
$tpl->assign('banner',$banner);
$tpl->assign('type',$type);
$tpl->assign('get_data',$get_data);
$tpl->assign('pagestr',$pagestr);
$tpl->assign('here',$here);
?>