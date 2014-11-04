<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 图片显示
$pic = $_GET['pic'];
if ($pic == '') die();
$array = explode(",",$pic);
if (!is_array($array)) die();
$count = count($array);
echo "<div style=\"text-align:center; font-size:12px;\">\n";
for ($i = 0; $i < $count; $i++) {
	$url = $array[$i];
	if (substr($url,0,7) == 'http://') {
		echo "<img src=\"{$url}\" />\n";
		echo "<div style=\"text-align:center; padding:5px;\">{$url}<div><br />\n";
	} else {
		echo "<img src=\"uploadfile/upfiles/{$url}\" />";
		echo "<div style=\"text-align:center; padding:10px;\">{$url}<div><br />\n";
	}
}
echo "</div>";
?>