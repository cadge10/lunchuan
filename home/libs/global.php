<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 公用页面

//link
$sql = "SELECT * FROM ###_links WHERE 1 AND isshow = 1 ORDER BY sortid,id DESC";
$link = $db->get_all($sql);
$tpl->assign('link',$link);

//footer
$sql = "SELECT * FROM ###_newstype WHERE typeid = 1 AND isshow = 1 ORDER BY sortid,id DESC";
$footer = $db->get_all($sql);
if($footer){
    foreach($footer as $k => $v){
        $sql = "SELECT * FROM ###_news WHERE typeid = ".$v['id']." ORDER BY sortid,id DESC";
        $footer[$k]['news'] = $db->get_all($sql);
    }
}
$tpl->assign('footer',$footer);
?>