function openDialog(url,title,width,height) {
	if (url    == undefined){url    = '';}
	if (title  == undefined){title  = '信息提示框';}
	if (width  == undefined){width  = 'auto';}
	if (height == undefined){height = 'auto';}
	$.dialog(
	{
		lock: true,
		max: false,
		fixed: true,
		min: false,
		title: title,
		width: width,
		height: height,
		id: 'oDia',
		content: 'url:'+url
	});
}