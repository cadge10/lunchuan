<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 新闻列表例子
$file_title = '行业资讯';

$table = trim(base::g('table','news'));

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id IN (12,13,14) LIMIT 3";
$banner = $db->get_all($sql);

//最新资讯
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 6";
$new = $db->get_all($sql);

//专题活动
$type = pub::get_child_newstype(18);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 2";
$active = $db->get_all($sql);

//企业动态
$type = pub::get_child_newstype(7);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 5";
$company = $db->get_all($sql);

//视频新闻
$type = pub::get_child_newstype(19);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 11";
$movie = $db->get_all($sql);

//行业动态
$type = pub::get_child_newstype(9);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$hydt = $db->get_all($sql);

//市场研究
$type = pub::get_child_newstype(10);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$scyj = $db->get_all($sql);

//政策法规
$type = pub::get_child_newstype(11);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 6";
$zcfg = $db->get_all($sql);

//企业新闻
$type = pub::get_child_newstype(12);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$qyxw = $db->get_all($sql);

//业界名人
$type = pub::get_child_newstype(13);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$yjmw = $db->get_all($sql);

//新品推荐
$type = pub::get_child_newstype(14);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 6";
$xptj = $db->get_all($sql);

//行业知识
$type = pub::get_child_newstype(15);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$hyzs = $db->get_all($sql);

//再利用技术
$type = pub::get_child_newstype(16);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 3";
$zly = $db->get_all($sql);

//成功故事
$type = pub::get_child_newstype(17);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 6";
$cggs = $db->get_all($sql);

$tpl->assign('file_title',$file_title);
$tpl->assign('new',$new);
$tpl->assign('banner',$banner);
$tpl->assign('active',$active);
$tpl->assign('company',$company);
$tpl->assign('movie',$movie);
$tpl->assign('hydt',$hydt);
$tpl->assign('scyj',$scyj);
$tpl->assign('zcfg',$zcfg);
$tpl->assign('qyxw',$qyxw);
$tpl->assign('yjmw',$yjmw);
$tpl->assign('xptj',$xptj);
$tpl->assign('hyzs',$hyzs);
$tpl->assign('zly',$zly);
$tpl->assign('cggs',$cggs);
?>