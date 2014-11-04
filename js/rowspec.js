var Browser = new Object(); // 判断浏览器的类型
Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

function rowindex(tr) // 获取行索引
{
  if (Browser.isIE)
  {
    return tr.rowIndex;
  }
  else
  {
    table = tr.parentNode.parentNode;
    for (i = 0; i < table.rows.length; i ++ )
    {
      if (table.rows[i] == tr)
      {
        return i;
      }
    }
  }
}


/**
* 新增一个规格
*/
function addSpec(obj) { //obj是 table的id，一般是this 针对一行两列的
	var src   = obj.parentNode.parentNode;
	var idx   = rowindex(src);
	var tbl   = document.getElementById('attrTable');
	var row   = tbl.insertRow(idx + 1);
	var cell1 = row.insertCell(-1);
	var cell2 = row.insertCell(-1);
	
	cell1.className = 'label_right';
	cell1.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addSpec)(.*)(\[)(\+)/i, "$1removeSpec$3$4-");
	cell2.innerHTML = src.cells[1].innerHTML.replace(/readOnly([^\s|>]*)/i, '');
}

/**
* 删除规格值
*/
function removeSpec(obj) { //obj是 table的id，一般是this
	var row = rowindex(obj.parentNode.parentNode);
	var tbl = document.getElementById('attrTable');
	
	tbl.deleteRow(row);
}


/**
* 新增一行
*/
function addRow(obj,rowTable) { //obj是 table的id，一般是this 针对一行两列的
	var src  = obj.parentNode.parentNode;
	var idx  = rowindex(src);
	var tbl  = document.getElementById(rowTable);
	var row  = tbl.insertRow(idx + 1);
	var cell = row.insertCell(-1);
	cell.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addRow)(.*)(\[)(\+)/i, "$1removeRow$3$4-");
}

/**
* 删除一行
*/
function removeRow(obj,rowTable) { //obj是 table的id，一般是this
	var row = rowindex(obj.parentNode.parentNode);
	var tbl = document.getElementById(rowTable);	
	tbl.deleteRow(row);
}