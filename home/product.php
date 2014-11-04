<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '商品中心';

$table = trim(base::g('table','product'));


//市
$sql    =   "SELECT * FROM (SELECT c.name,i.city,count(i.city) tot FROM ###_$table i LEFT JOIN ###_city c ON (c.code = i.city) WHERE 1 GROUP BY i.city) lin ORDER BY tot LIMIT 5";
$city   =   $db->get_all($sql);

//省
$sql    =   "SELECT * FROM (SELECT c.name,i.province,count(i.province) tot FROM ###_$table i LEFT JOIN ###_province c ON (c.code = i.province) WHERE 1 GROUP BY i.province) lin ORDER BY tot LIMIT 7";
$province   =   $db->get_all($sql);
if($province){
    foreach($province as $k => $v){
        $sql    =   "SELECT * FROM (SELECT c.name,i.city,count(i.city) tot FROM ###_$table i LEFT JOIN ###_city c ON (c.code = i.city) WHERE 1 AND i.province = ".$v['province']." GROUP BY i.city) lin ORDER BY tot LIMIT 5";
        $data   =   $db->get_all($sql);
        $province[$k]['city'] = $data;
    }
}

//企业
$sql    =   "SELECT i.company,i.reg_date,c.name city,p.name province,i.id FROM ###_users i LEFT JOIN ###_province p ON (p.code = i.province) LEFT JOIN ###_city c ON (c.code = i.city) WHERE 1 GROUP BY i.company ORDER BY i.reg_date LIMIT 18";
$company   =   $db->get_all($sql);;

//banner
$sql = "SELECT * FROM ###_banner WHERE 1 AND isshow = 1 AND id = 6 LIMIT 1";
$banner = $db->get_one($sql);

//type
$sql = "SELECT * FROM ###_producttype WHERE 1 AND isshow = 1 AND typeid = 0 ORDER BY sortid,id";
$type = $db->get_all($sql);
if($type){
    foreach($type as $k => $v){
        $sql = "SELECT * FROM ###_producttype WHERE 1 AND isshow = 1 AND typeid = ".$v['id']." ORDER BY sortid,id";
        $type[$k]['child'] = $db->get_all($sql);
    }
}

$tpl->assign('file_title',$file_title);
$tpl->assign('banner',$banner);
$tpl->assign('type',$type);
$tpl->assign('city',$city);
$tpl->assign('company',$company);
$tpl->assign('province',$province);

?>