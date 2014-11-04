// JS特效
var liuList = new Object;
if (typeof Browser != 'object') {
	var Browser = new Object(); // 判断浏览器的类型
	Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
	Browser.isIE = window.ActiveXObject ? true : false;
	Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
	Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
	Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);
}
liuList.url = location.href.lastIndexOf("?") == -1 ? location.href.substring((location.href.lastIndexOf("/")) + 1) : location.href.substring((location.href.lastIndexOf("/")) + 1, location.href.lastIndexOf("?"));

if (typeof Utils != 'object') {
	var Utils = new Object();
	
	Utils.htmlEncode = function(text)
	{
	  return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	}
	
	Utils.trim = function( text )
	{
	  if (typeof(text) == "string")
	  {
		return text.replace(/^\s*|\s*$/g, "");
	  }
	  else
	  {
		return text;
	  }
	}
	
	Utils.isEmpty = function( val )
	{
	  switch (typeof(val))
	  {
		case 'string':
		  return Utils.trim(val).length == 0 ? true : false;
		  break;
		case 'number':
		  return val == 0;
		  break;
		case 'object':
		  return val == null;
		  break;
		case 'array':
		  return val.length == 0;
		  break;
		default:
		  return true;
	  }
	}
	
	Utils.isNumber = function(val)
	{
	  var reg = /^[\d|\.|,]+$/;
	  return reg.test(val);
	}
	
	Utils.isInt = function(val)
	{
	  if (val == "")
	  {
		return false;
	  }
	  var reg = /\D+/;
	  return !reg.test(val);
	}
	
	Utils.isEmail = function( email )
	{
	  var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
	
	  return reg1.test( email );
	}
	
	Utils.isTel = function ( tel )
	{
	  var reg = /^[\d|\-|\s|\_]+$/; //只允许使用数字-空格等
	
	  return reg.test( tel );
	}
	
	Utils.fixEvent = function(e)
	{
	  var evt = (typeof e == "undefined") ? window.event : e;
	  return evt;
	}
	
	Utils.srcElement = function(e)
	{
	  if (typeof e == "undefined") e = window.event;
	  var src = document.all ? e.srcElement : e.target;
	
	  return src;
	}
	
	Utils.isTime = function(val)
	{
	  var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/;
	
	  return reg.test(val);
	}
	
	Utils.x = function(e)
	{ //当前鼠标X坐标
		return Browser.isIE?event.x + document.documentElement.scrollLeft - 2:e.pageX;
	}
	
	Utils.y = function(e)
	{ //当前鼠标Y坐标
		return Browser.isIE?event.y + document.documentElement.scrollTop - 2:e.pageY;
	}
	
	Utils.request = function(url, item)
	{
		var sValue=url.match(new RegExp("[\?\&]"+item+"=([^\&]*)(\&?)","i"));
		return sValue?sValue[1]:sValue;
	}
	
	Utils.$ = function(name)
	{
		return document.getElementById(name);
	}
}

/**
 * 创建一个可编辑区(obj, act, id, mod)
 */
liuList.edit = function(obj,table,field,key_id,key_id_name,moduleid)
{
  // obj:表单元素(this) table:操作的表 field:操作的字段 key_id 主键值(默认是id的值) key_id_name:主键字段(默认id) moduleid:模型ID(默认0)
  if (typeof(key_id_name) == "undefined") key_id_name = "id";
  if (typeof(value) == "undefined") value = "";
  if (typeof(moduleid) == "undefined") moduleid = 0;
  
  var tag = obj.firstChild.tagName;
  
  if (typeof(tag) != "undefined" && tag.toLowerCase() == "input")
  {
    return;
  }

  /* 保存原始的内容 */
  var org = obj.innerHTML;
  var val = Browser.isIE ? obj.innerText : obj.textContent;

  /* 创建一个输入框 */
  var txt = document.createElement("INPUT");
  txt.value = (val == 'N/A') ? '' : val;
  txt.style.width = (obj.offsetWidth + 12) + "px" ;

  /* 隐藏对象中的内容，并将输入框加入到对象中 */
  obj.innerHTML = "";
  obj.appendChild(txt);
  txt.focus();

  /* 编辑区输入事件处理函数 */
  txt.onkeypress = function(e)
  {
    var evt = Utils.fixEvent(e);
    var obj = Utils.srcElement(e);

    if (evt.keyCode == 13)
    {
      obj.blur();

      return false;
    }

    if (evt.keyCode == 27)
    {
      obj.parentNode.innerHTML = org;
    }
  }

  /* 编辑区失去焦点的处理函数 */
  txt.onblur = function(e)
  {
	if (Utils.trim(txt.value).length > 0)
    {
      res = Ajax.call(liuList.url, "r="+Math.random()+"&a=ajax&mod=liu_updat&table="+table+"&field=" + field+"&value=" + txt.value + "&key_id=" +key_id + "&key_id_name=" + key_id_name + "&moduleid=" + moduleid, null, "GET", "JSON", false);
	  if (res.message)
      {
        alert(res.message);
      }

      obj.innerHTML = (res.error == 0) ? res.content : org;
    }
    else
    {
      obj.innerHTML = org;
    }
	
  }
}

liuList.staToogle = function (ele,table,field,key_id,key_id_name,moduleid) {
	// ele:表单元素(this) table:操作的表 field:操作的字段 key_id 主键值(默认是id的值) key_id_name:主键字段(默认id) moduleid:模型ID(默认0)
	if (typeof(key_id_name) == "undefined") key_id_name = "id";
	if (typeof(moduleid) == "undefined") moduleid = 0;
	res = Ajax.call(liuList.url, "r="+Math.random()+"&a=ajax&mod=liu_stat&table="+table+"&field=" + field + "&key_id=" +key_id + "&key_id_name=" + key_id_name + "&moduleid=" + moduleid, null, "GET", "TEXT", false);
	if (Utils.trim(res)!='') {
		ele.src = res;
	}
}