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
	if (title  == undefined){title  = '��Ϣ��ʾ��';}
	if (width  == undefined){width  = 'auto';}
	if (height == undefined){height = 'auto';}
	$.dialog.open(url,
    {
		title: title,
		width:width,
		height:height,
		lock:true,
		opacity: 0.1,	// ͸����
		id:1, // ��ֹ�򿪶��
	});
}
</script>
<title>�ޱ����ĵ�</title>
</head>

<body>
<a href="javascript:;" onclick="openDialog('http://www.baidu.com/','��Ϣ��ʾ��',800,400);">�򿪴���</a>

<a href="javascript:;" onclick="openDialog('http://www.baidu.com/','��Ϣ��ʾ��',1000,200);">�򿪴���</a>
</body>
</html>
