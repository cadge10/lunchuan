<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '供求信息';

$table = trim(base::g('table','information'));

//最新资讯
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND typeid in ($str) ";
$sql = "SELECT * FROM ###_news WHERE 1 AND isshow = 1 $sqlt ORDER BY sortid,id DESC LIMIT 12";
$new = $db->get_all($sql);

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 6 LIMIT 1";
$banner = $db->get_one($sql);

$id = base::g('id',0);
if($id <= 0)exit(base::msg('参数传递错误'));
$sql    =   "SELECT n.*,t.title tname,c.name,u.phone,u.tel,u.email FROM ###_$table n ".
            "LEFT JOIN ###_informationtype t ON (t.id = n.cid) ".
            "LEFT JOIN ###_users u ON (u.id = n.userid) ".
            "LEFT JOIN ###_city c ON (c.code = n.city) WHERE n.id = ".$id;
$info   =   $db->get_one($sql);
if(!$info)exit(base::msg('数据已删除'));

$file_title = $info['mingcheng']."-".$file_title;

$here  = "<a href='?mod=information'>供求信息</a> > <a href=''>".$info['mingcheng']."</a> ";

$tpl->assign('file_title',$file_title);
$tpl->assign('here',$here);
$tpl->assign('info',$info);
$tpl->assign('new',$new);
$tpl->assign('banner',$banner);
?>