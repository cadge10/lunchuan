<?php
// 检查系统是否安装
if (!file_exists("./config.php")) {
	header('Location:install.php');
	exit();
}

include('inc.php');

// 标签调用
$insert_tag_url = __ROOT__.'/home/libs/insert_tag.php';
if (file_exists($insert_tag_url)) {
	include($insert_tag_url);
}

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

// 模板目录
$template_dir = pub::get_config("web_template_url")!=""?pub::get_config("web_template_url"):"default";
$tpl_ext = 'html'; // 操作文件的扩展名

// 实例化模板类
$tpl = new template();
$tpl->compile_dir = "data/compile";
$tpl->template_dir = "templates";

// 获取跳转地址
if (trim(base::g("return_url") != '')) {
	$return_url = base::code(trim(base::g("return_url")),"DE");
} else {
	$return_url = '';
}
// 程序通用包含文件
$g_page = __ROOT__.'/home/libs/global.php';
if (file_exists($g_page)) include($g_page);

// 程序页
$code_page = __ROOT__.'/'.$app_file.'/'.$view.'.php';
if (file_exists($code_page)) include($code_page);

// 模板页面设定
if (!isset($template_page)) {
	$template_page = $template_dir.'/'.$view.'.'.$tpl_ext;
}

$main_page = __ROOT__.'/'.$tpl->template_dir.'/'.$template_page;

// 以模板页为主，没有控制页，只要有模板页，也能正常显示
if (!file_exists($main_page)) exit('template "<strong>'.$template_page.'</strong>" no exists!');

// 网站配置2
$web_config = pub::get_config();
$tpl->assign('web_config',$web_config);

// 返回地址，经过加密后解密的
$tpl->assign('return_url',$return_url);

// 设置WEB_PATHINFO，路由设置
$tpl->assign('web_pathinfo',WEB_PATHINFO);
// 设置模板路径
$tpl->assign('template_dir',WEB_DIR.$tpl->template_dir.'/');

// 设置主题模板路径，可以直接用在图片或样式上
$tpl->assign('theme_dir',WEB_DIR.$tpl->template_dir.'/'.$template_dir.'/');

// 设置模板存放的目录名
$tpl->assign('template_dir_name',$template_dir);
// 设置网页路径
$tpl->assign('web_dir',WEB_DIR);
// 设置网页mod值
$tpl->assign('web_view',$view);

// 输出模板内容
if (!isset($cache_id)) $cache_id = '';
$tpl->display($template_page,$cache_id);
?>