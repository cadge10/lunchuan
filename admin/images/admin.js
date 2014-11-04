//侧栏开关
if(self == top) {
//top.location="main.php";
}
function sideSwitch() {
var mainFrame = window.parent.document.getElementById('mainframeset');
var switcher = document.getElementById('sideswitch');
if (mainFrame.cols == '0,*') {
mainFrame.cols = '200,*';
switcher.innerHTML = '关闭侧栏';
switcher.className = 'opened';
} else {
mainFrame.cols = '0,*';
switcher.innerHTML = '打开侧栏';
switcher.className = 'closed';
}
}
function channelNav(Obj, channel) {
var channelTabs = document.getElementById('topmenu').getElementsByTagName('a');
for (i=0; i<channelTabs.length; i++) {
channelTabs[i].className = '';
}
Obj.className = 'current';
Obj.blur();
var sideDoc = window.parent.leftframe.document;
var sideChannels = sideDoc.getElementsByTagName('div')
for (i=0; i<sideChannels.length; i++) {
sideChannels[i].style.display = '';
}
var sideChannelLinks = sideDoc.getElementsByTagName('a')
for (i=0; i<sideChannelLinks.length; i++) {
sideChannelLinks[i].className = '';
}
var targetChannels = channel.split(',');
sideDoc.getElementById(targetChannels[0]).getElementsByTagName('a')[0].className = 'current';
for (i=0; i<targetChannels.length; i++) {
sideDoc.getElementById('ul_'+targetChannels[i]).style.display = 'block';
sideDoc.getElementById(targetChannels[i]).style.display = 'block';
}
}
function treeView() {
var list = document.getElementsByTagName('div');
for ( i=0; i<list.length; i++ ) {
list[i].getElementsByTagName('h3')[0].onclick = function() {
if (this.parentNode.getElementsByTagName('ul')[0].style.display == '') {
this.parentNode.getElementsByTagName('ul')[0].style.display = 'none';
} else {
this.parentNode.getElementsByTagName('ul')[0].style.display = '';
}
}
}
var linkitem = document.getElementsByTagName('a');
for ( j=0; j<linkitem.length; j++ ) {
linkitem[j].onclick = function() {
for ( k=0; k<linkitem.length; k++ ) {
linkitem[k].className = '';
}
this.className = 'current';
this.blur();
}
}
}

function onover(str) {
str.style.backgroundColor='#EAFCD5';
str.style.color='#FF0000';
}

function onout(str) {	
str.style.backgroundColor='';
str.style.color='';
}

function checkAll(form)
{
for (var i=0;i<form.elements.length;i++)
{
var e = form.elements[i];
if (e.name != 'chkall')
e.checked = form.chkall.checked;
}
}

function isDigit(s) { 
var patrn=/^[0-9]{1,10}$/; 
if (!patrn.exec(s)) return false ;
return true;
}

function open_win(url,name,width,height,scroll)
{
var Left_size = (screen.width) ? (screen.width-width)/2 : 0;
var Top_size = (screen.height) ? (screen.height-height)/2 : 0;
var open_win=window.open(url,name,'width=' + width + ',height=' + height + ',left=' + Left_size + ',top=' + Top_size + ',toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=' + scroll + ',resizable=no' );
}

function CheckSel(Voption,Value) {
	var obj = document.getElementById(Voption);
	for (i=0;i<obj.length;i++) {
		if (obj.options[i].value==Value) {
			obj.options[i].selected=true;
			break;
		}
	}
}

function CheckOption(form,type,id,value) {
	ele = form.elements;
	arr = value.split(",");
	elelen = ele.length;
	arrlen = arr.length;
	for (var i=0;i<elelen;i++) {
		if (ele[i].type != type) continue;
		for (s = 0; s < arrlen;s++) {
			if (ele[i].value == arr[s] && ele[i].id == id) {
				ele[i].checked = true;
			}
		}
	}
}

function veiwPic(that) {
	pic = that.value;
	if (pic == '') {
		alert('没有任何图片，无法预览！');
	} else {
		tmpurl = pic.substr(0,7);
		if (tmpurl == 'http://') {
			window.open(pic,"weiwpic","toolbar=no,scrollbars=yes");
		} else {
			window.open("?mod=admin_pic&pic="+pic,"weiwpic","toolbar=no,scrollbars=yes");
		}
	}
}

function SelectTemplates(fname){ // fname = form1.url;
   var posLeft = 10;
   var posTop = 10;
   window.open("../includes/dialog/select_templates.php?f="+fname, "poptempWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+posLeft+", top="+posTop);
}

String.prototype.trim=function(){
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
function tabit(btn,n){
	var idname = new String(btn.id);
	var s = idname.indexOf("_");
	var e = idname.lastIndexOf("_")+1;
	var tabName = idname.substr(0, s);
	var id = parseInt(idname.substr(e));
	var tabNumber = n;
	for(i=0;i<tabNumber;i++){
			document.getElementById(tabName+"_div_"+i).style.display = "none";
			document.getElementById(tabName+"_btn_"+i).className = "";
		}
		document.getElementById(tabName+"_div_"+id).style.display = "block";
		btn.className = "current";
}

function showSort(sortname,field,sessprefix,sort_arr_name) { // 排序
	$.get('admincp.php',{r:Math.random(),a:'ajax',mod:'set_sort','sort':sortname,'name':sessprefix,'sort_name':sort_arr_name,'field':field},function(data){
		if ($.trim(data)=='success') {

			window.document.location.reload(true);

		}

	});

}