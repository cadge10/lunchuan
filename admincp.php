<?php
// 检查系统是否安装
if (!file_exists("./config.php")) {
	header('Location:install.php');
	exit();
}
include('inc.php');

$a = base::g('a'); // action
$app_file = 'admin'; // 项目名称，根目录下必须有此目录

$view = base::g('mod','index');

if ($a=='ajax') { // 调用Ajax
	if (!file_exists(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php')) exit('ajax include no exists!');
	include(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php');
	exit();
}
// 调用网页配置信息
$web_config_info = adminpub::get_web_config_info();

if ($view!='login') {
	// 这里控制登录条件
	if (!file_exists(__ROOT__.'/admin/chklogin.php')) exit('system error!');
	include(__ROOT__.'/admin/chklogin.php');
}

$tpl_ext = 'php'; // 操作文件的扩展名
$main_page = __ROOT__.'/'.$app_file.'/'.$view.'.'.$tpl_ext;

$app_dir = WEB_DIR.$app_file.'/'; // 项目路径

// 以模板页为主，没有控制页，只要有模板页，也能正常显示
if (file_exists($main_page)) {
	include($main_page);
} else {
	exit('"<strong>'.$main_page.'</strong>" no exists!');
}
?>