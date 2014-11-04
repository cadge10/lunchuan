<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '最新人才-招聘中心';

//人才
$page = (int)base::g('page',1);
$pagesize=22;

$sql = "SELECT COUNT(id) FROM ###_careers WHERE 1";
$recordcount = $db->get_count($sql); // 总记录数

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount>0 ? $pagecount : 0;
$currentpage = ($page-1)*$pagesize;

$sql = "SELECT * FROM ###_careers WHERE 1 ORDER BY addtime DESC LIMIT $currentpage,$pagesize";
$users = $db->get_all($sql);
// 分页字符串
$page_obj = new page($recordcount,$pagesize);
$pagestr = $page_obj->show();

//名企招聘
$type = pub::get_child_newstype(22);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_news WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 9";
$mqzp = $db->get_all($sql);

//教你用人
$type = pub::get_child_newstype(23);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_news WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 9";
$jnyr = $db->get_all($sql);

//职场资讯
$type = pub::get_child_newstype(24);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_news WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 9";
$zczx = $db->get_all($sql);

$here = "<a href='?mod=jobs'>招聘中心</a> > <a href=''>最新人才</a>";

$tpl->assign('file_title',$file_title);
$tpl->assign('users',$users);
$tpl->assign('mqzp',$mqzp);
$tpl->assign('jnyr',$jnyr);
$tpl->assign('zczx',$zczx);
$tpl->assign('pagestr',$pagestr);
$tpl->assign('here',$here);
?>