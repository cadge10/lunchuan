<?php
// 检查系统是否安装
if (!file_exists("./config.php")) {
	header('Location:install.php');
	exit();
}

include('inc.php');

// 检查网站是否关闭
if (pub::get_config('web_close')=='1') exit(pub::get_config('web_close_description'));

base::router(); // 路由设置

$a = base::g('a'); // action
$app_file = 'home'; // 项目名称，根目录下必须有此目录

$view = base::g('mod','index');

if ($a == 'action') {
	if (!file_exists(__ROOT__.'/action.php')) exit('action include no exists!');
	include(__ROOT__.'/action.php');
	exit();
}

if ($a=='ajax') { // 调用Ajax
	if (!file_exists(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php')) exit('ajax include no exists!');
	include(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php');
	exit();
}
// 调用网页配置信息
$web_config_info = adminpub::get_web_config_info();

$tpl_ext = 'php'; // 操作文件的扩展名
$main_page = __ROOT__.'/'.$app_file.'/'.$view.'.'.$tpl_ext;

$app_dir = WEB_DIR.$app_file.'/'; // 项目路径
$web_pathinfo = WEB_PATHINFO; // 网页地址栏路径，一般为/app/index.php/或/app/

// 以模板页为主，没有控制页，只要有模板页，也能正常显示
if (file_exists($main_page)) {
	include($main_page);
} else {
	exit('"<strong>'.$main_page.'</strong>" no exists!');
}
?>