<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 处理页面

$code = adminpub::getsafecode();
if (base::s('m_logined')!=$code) {
	exit(base::msg('登录已超时或未登录，请返回登录。','?mod=login'));
}

// 检查访问页面的权限
if (!adminpub::getuservalidate(base::s('m_userid'),$view)) exit(base::alert('对不起，您没有权限进行此操作，如有疑问请联系管理员。'));
?>