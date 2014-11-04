<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/artDialog/jquery.artDialog.js?skin=blue"></script>
<script type="text/javascript" src="js/artDialog/plugins/iframeTools.js"></script>
<script type="text/javascript">

function openDialog(url,title,width,height) {
	if (url    == undefined){url    = '';}
	if (title  == undefined){title  = '信息提示框';}
	if (width  == undefined){width  = 'auto';}
	if (height == undefined){height = 'auto';}
	$.dialog.open(url,
    {
		title: title,
		width:width,
		height:height,
		lock:true,
		opacity: 0.1,	// 透明度
		id:1, // 防止打开多个
	});
}
</script>
<title>无标题文档</title>
</head>

<body>
<a href="javascript:;" onclick="openDialog('http://www.baidu.com/','信息提示框',800,400);">打开窗口</a>

<a href="javascript:;" onclick="openDialog('http://www.baidu.com/','信息提示框',1000,200);">打开窗口</a>
</body>
</html>
