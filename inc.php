<?php
session_start();
header("content-type:text/html;charset=utf-8");
// 导入页面
require('includes/common.inc.php');

if (URL_MODE === 0) { // 原生字符串
	define('WEB_PATHINFO',WEB_DIR); // 默认保持不变
} elseif (URL_MODE === 1) { // 伪静态字符串
	// 不支持支持伪静态：WEB_PATHINFO="index.php/"，支持伪静态：WEB_PATHINFO="/"
	if (URL_PATHINFO === 0) {
		define('WEB_PATHINFO',WEB_DIR);
	} else {
		define('WEB_PATHINFO',WEB_DIR."index.php/");
	}
}
?>