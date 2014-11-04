<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$id = base::gp('id',0);
if($id <= 0)exit(base::msg('参数错误'));
$sql    =   "SELECT n.*,t.title as tname FROM ###_news n,###_newstype t WHERE n.typeid = t.id AND n.id = ".$id;
$info   =   $db->get_one($sql);
if(!$info)exit(base::msg('数据已被删除'));
//分类
$sql    =   "SELECT * FROM ###_news WHERE typeid = ".$info['typeid']." ORDER BY sortid,id DESC";
$cage   =   $db->get_all($sql);

$file_title =  $info['title'].'-'.$info['tname'];
$tpl->assign('file_title',$file_title);
$tpl->assign('info',$info);
$tpl->assign('cage',$cage);
?>