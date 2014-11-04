<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
//最新资讯
$table = trim(base::g('table','news'));
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_{$table} WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 12";
$new = $db->get_all($sql);

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 4 LIMIT 1";
$banner = $db->get_one($sql);

$id = base::g('id',0);
if($id <= 0)exit(base::msg('参数传递错误'));
$sql    =   "SELECT n.*,t.title tname FROM ###_news n,###_newstype t WHERE n.typeid = t.id AND n.id = ".$id;
$info   =   $db->get_one($sql);
if(!$info)exit(base::msg('数据已删除'));

//更新浏览量
$db->query("UPDATE ###_news SET hits = hits + 1 WHERE id = ".$id);

$file_title = $info['title'].'-'.$info['tname'];
$here = "<a href='?mod=jobs_news&id=".$info['typeid']."'>".$info['tname']."</a> > <a href=''>".$info['title']."</a>";

$sql 				=	"SELECT n.id,n.title FROM ###_".$table." n WHERE n.id > ".$id." AND typeid = ".$info['typeid']." ORDER BY n.id";
$next 				=	$db->get_one($sql);
$sql 				=	"SELECT n.id,n.title FROM ###_".$table." n WHERE n.id < ".$id." AND typeid = ".$info['typeid']." ORDER BY n.id DESC";
$prev 				=	$db->get_one($sql);
$tpl->assign('prev',	$prev);
$tpl->assign('next',	$next);

$tpl->assign('file_title',$file_title);
$tpl->assign('info',$info);
$tpl->assign('new',$new);
$tpl->assign('banner',$banner);
$tpl->assign('here',$here);
?>