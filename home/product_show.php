<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
//最新资讯
$table = trim(base::g('table','product'));

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 2 LIMIT 1";
$banner = $db->get_one($sql);

$id = base::g('id',0);
if($id <= 0)exit(base::msg('参数传递错误'));
$sql    =   "SELECT n.*,t.title tname FROM ###_{$table} n,###_producttype t WHERE n.typeid = t.id AND n.id = ".$id;
$info   =   $db->get_one($sql);
if(!$info)exit(base::msg('数据已删除'));

//更新浏览量
$db->query("UPDATE ###_{$table} SET hits = hits + 1 WHERE id = ".$id);

$file_title = $info['title'].'-'.$info['tname'].'-商品中心';
$here = "<a href='?mod=product'>商品中心</a> > <a href='?mod=product_cate&id=".$info['typeid']."'>".$info['tname']."</a> > <a href=''>".$info['title']."</a>";

$sql 				=	"SELECT n.id,n.title FROM ###_".$table." n WHERE n.id > ".$id." AND typeid = ".$info['typeid']." ORDER BY n.id";
$next 				=	$db->get_one($sql);
$sql 				=	"SELECT n.id,n.title FROM ###_".$table." n WHERE n.id < ".$id." AND typeid = ".$info['typeid']." ORDER BY n.id DESC";
$prev 				=	$db->get_one($sql);
$tpl->assign('prev',	$prev);
$tpl->assign('next',	$next);

//产品
$sql    =   "SELECT i.title,i.id FROM  ###_producttype i  WHERE 1 AND i.isshow = 1 AND typeid = 0 ORDER BY i.sortid";
$type   =   $db->get_all($sql);
if($type){
    foreach($type as $k => $v){
        $sql    =   "SELECT i.title,i.id FROM  ###_producttype i  WHERE 1 AND i.isshow = 1 AND typeid = ".$v['id']." ORDER BY i.sortid";
        $type[$k]['child'] = $db->get_all($sql);
    }
}
$tpl->assign('file_title',$file_title);
$tpl->assign('info',$info);
$tpl->assign('type',$type);
$tpl->assign('banner',$banner);
$tpl->assign('here',$here);
?>