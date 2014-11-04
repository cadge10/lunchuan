<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '首页';

//banner
$sql    =   "SELECT url,pic,title FROM ###_banner WHERE 1 AND isshow = 1 AND id IN (15,16,17,18,19) ORDER BY sortid,id DESC LIMIT 5";
$banner    =   $db->get_all($sql);

//最新资讯
$type = pub::get_child_newstype(20);
$str  = implode(',',$type);
$sqlt = " AND n.typeid in ($str) ";
$sql    =   "SELECT n.id,n.title,n.addtime,n.content FROM ###_news n WHERE 1 AND n.isshow = 1{$sqlt} ORDER BY n.sortid,n.addtime DESC LIMIT 3";
$news   =   $db->get_all($sql);

//供应信息
$sql    =   "SELECT n.*,c.name,u.company,u.tel FROM ###_information n LEFT JOIN ###_city c ON (c.code = n.city) LEFT JOIN ###_users u ON (u.id = n.userid) WHERE 1 AND n.ttype = 1 ORDER BY n.addtime DESC LIMIT 8";
$sell   =   $db->get_all($sql);

//求购信息
$sql    =   "SELECT n.*,c.name,u.company,u.tel FROM ###_information n LEFT JOIN ###_city c ON (c.code = n.city) LEFT JOIN ###_users u ON (u.id = n.userid) WHERE 1 AND n.ttype = 2 ORDER BY n.addtime DESC LIMIT 8";
$get    =   $db->get_all($sql);

//广告位
$sql    =   "SELECT url,pic FROM ###_banner WHERE 1 AND isshow = 1 AND id IN (9,10,11) ORDER BY sortid,id DESC LIMIT 3";
$banner_ad    =   $db->get_all($sql);

//热销产品
$sql    =   "SELECT pic,title,price,id FROM ###_product WHERE 1 AND isshow = 1 ORDER BY hits DESC,id DESC LIMIT 6";
$product_hot    =   $db->get_all($sql);

//商品
$sql    =   "SELECT * FROM (SELECT i.title,i.id,i.pic,i.typeid tot FROM ###_product i LEFT JOIN ###_producttype t ON (t.id = i.typeid)  WHERE 1 GROUP BY i.typeid) lin ORDER BY tot LIMIT 8";
$product   =   $db->get_all($sql);

//招聘
$type = pub::get_child_newstype(21);
$str  = implode(',',$type);
$sqlt = " AND n.typeid in ($str) ";
$sql    =   "SELECT n.id,n.title,n.addtime FROM ###_news n WHERE 1 AND n.isshow = 1{$sqlt} ORDER BY n.sortid,n.addtime DESC LIMIT 5";
$jobs   =   $db->get_all($sql);

//商品分类
$sql    =   "SELECT * FROM (SELECT t.title,i.typeid id,count(i.typeid) tot FROM ###_product i LEFT JOIN ###_producttype t ON (t.id = i.typeid)  WHERE 1 GROUP BY i.typeid) lin ORDER BY tot LIMIT 4";
$type   =   $db->get_all($sql);

//大家正在关注
$sql    =   "SELECT id,title,addtime FROM ###_news WHERE isshow = 1 ORDER BY hits DESC LIMIT 5";
$hits   =   $db->get_all($sql);

$tpl->assign('file_title',$file_title);
$tpl->assign('news',$news);
$tpl->assign('sell',$sell);
$tpl->assign('get',$get);
$tpl->assign('banner_ad',$banner_ad);
$tpl->assign('banner',$banner);
$tpl->assign('product_hot',$product_hot);
$tpl->assign('product',$product);
$tpl->assign('type',$type);
$tpl->assign('jobs',$jobs);
$tpl->assign('hits',$hits);
?>