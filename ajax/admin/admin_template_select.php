<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 设置模板

$default_url = trim(base::g('default_url'));

$sql = "UPDATE  `###_config` SET  `value` =  '$default_url',`hidden`=1 WHERE  `field` ='web_template_url'";
$db->query($sql);

$xml_url = 'templates/'.$default_url.'/themes.xml';
$xml = simplexml_load_file($xml_url);
// 返回json格式的数据
$json = '{"name":"'.$xml->template_name.'","desc":"'.$xml->description.'","version":"'.$xml->version.'","author":"'.$xml->author.'","uri":"'.$xml->author_url.'","screenshot":"templates/'.$default_url.'/images/screenshot.png"}';
exit($json);
?>