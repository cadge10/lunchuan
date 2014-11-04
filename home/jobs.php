<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '招聘中心';

//招聘
$sql = "SELECT * FROM ###_jobs WHERE 1 AND isshow = 1 ORDER BY sortid,id DESC LIMIT 7";
$data = $db->get_all($sql);

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 5 LIMIT 1";
$banner = $db->get_one($sql);

//人才
$sql = "SELECT * FROM ###_careers WHERE 1 GROUP BY realname ORDER BY addtime DESC LIMIT 7";
$users = $db->get_all($sql);

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

$tpl->assign('file_title',$file_title);
$tpl->assign('jobs',$data);
$tpl->assign('users',$users);
$tpl->assign('mqzp',$mqzp);
$tpl->assign('jnyr',$jnyr);
$tpl->assign('zczx',$zczx);
$tpl->assign('banner',$banner);
?>