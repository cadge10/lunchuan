<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 检测管理员是否被注册
$pic = trim(base::g('pic'));
if ($pic=='') exit("err");
$url = "uploadfile/upfiles/".$pic;

if (!file_exists($url)) exit("err");;

if(is_file($url)){
	if (@unlink($url)) {
		@unlink("uploadfile/upfiles/thumb_".$pic);
		exit("success");
	} else {
		exit("err");
	}
} else {
	exit("err");
}
exit("err");
?>