<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$table = "_config"; // 去掉前缀的表名，要保证和文件名相同
if (base::p("action")=="add") {
	base::issubmit();
	$sortid = (int)base::p("sortid");
	$title = trim(base::p("title"));
	$groupname = trim(base::p("groupname"));
	$field = trim(base::p("field"));
	$width = (int)base::p("width");
	$value = trim(base::p("value_i"));
	$typeid = (int)base::p("typeid");
	$items = trim(base::p("items"));
	$description = trim(base::p("description"));
	$hidden = (int)base::p("hidden");
	
	if ($field == "") exit(base::alert("字段名称不能为空。"));
	if ($title == "") exit(base::alert("项目名称不能为空。"));
	
	// 验证字段名或项目名称是否存在，只要有一个存在都提示错误
	$one = $db->get_one("select id from ###{$table} where field='$field' or title='$title' limit 1");
	if (!empty($one)) exit(base::alert("配置表中字段名称或项目名称不能重复，请检查。"));
	
	if ($typeid == 3 && $items == "") exit(base::alert("项目名称不能为空。"));
	
	$sql = "insert into `###{$table}`(`sortid`,`title`,`field`,`width`,`value`,`typeid`,`items`,`description`,`hidden`,`groupname`) values('$sortid','$title','$field','$width','$value','$typeid','$items','$description','$hidden','$groupname')";
	$db->query($sql);
	exit(base::alert('添加成功，请返回！','?mod=admin'.$table));
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script></head>
<script type="text/javascript" src="js/jquery.js"></script></head>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.groupname.value=="") {
		alert("请填写分组名称。");
		frm.groupname.focus();
		return false;
	}
	if (frm.field.value=="") {
		alert("字段名称不能为空。");
		frm.field.focus();
		return false;
	}
	if (frm.title.value=="") {
		alert("项目名称不能为空。");
		frm.title.focus();
		return false;
	}
	if (frm.typeid.value==3 && frm.items.value=="") {
		alert("默认数据不能为空。");
		frm.items.focus();
		return false;
	}
	return true;
}

function changeData(val) {
	if (val==1 || val==2) {
		document.getElementById("input_width").style.display="";
		document.getElementById("input_items").style.display="none";
		document.getElementById("input_value_description").style.display="none";
	} else if (val==3) {
		document.getElementById("input_width").style.display="none";
		document.getElementById("input_items").style.display="";
		document.getElementById("input_value_description").style.display="";
	} else if (val==4) {
		document.getElementById("input_width").style.display="";
		document.getElementById("input_items").style.display="none";
		document.getElementById("input_value_description").style.display="none";
	}
}
function selectGroup() {
	$('#ajax_group').empty();
	str = '<input name="groupname" type="text" id="groupname" size="30" maxlength="50" />';
	$('#ajax_group').html(str);
	$('#ajax_group_set').remove();
}
</script>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<input name="action" type="hidden" id="action" value="add">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
      <th align="left">选择分组：</th>
      <td><span id="ajax_group"><select name="groupname" id="groupname">
        <?php
		$all = $db->get_all("SELECT groupname FROM ###_config GROUP BY groupname");
		foreach ($all as $v) {
        ?>
        <option value="<?php echo $v[0]?>"><?php echo $v[0]?></option>
        <?php
		}
		?>
      </select></span> 
        <a href="javascript:;" onClick="selectGroup()" id="ajax_group_set">手动添加</a> * 对配置进行分组。</td>
    </tr>
    <tr>
	  <th width="107" align="left">字段名称：</th>
      <td><input name="field" type="text" id="field" size="30" maxlength="50" /> 
        * 调用时使用的字段，如：web_title。</td>
    </tr>
    <tr>
      <th align="left">项目名称：</th>
      <td><input name="title" type="text" id="title" size="50" maxlength="50" /> 
        * 在字段表单前面显示。</td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="5" /> 
        * 数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">表单类型：</th>
      <td><select name="typeid" id="typeid" onChange="changeData(this.options[this.selectedIndex].value)">
        <option value="1">文本字段</option>
        <option value="2">文本区域</option>
        <option value="3">单选按钮</option>
        <option value="4">单张图片</option>
      </select> 
        不同类型显示的也不同。</td>
    </tr>
    <tr id="input_width">
      <th align="left">表单宽度：</th>
      <td><input name="width" type="text" id="width" size="10" maxlength="3" value="200" /> 
        文本框或文本区域的宽度（单位：px，文本字段和文本区域使用）。</td>
    </tr>
    <tr id="input_items" style="display:none;">
      <th align="left">默认数据：</th>
      <td><input name="items" type="text" id="items" size="50" /> 
        * 多个以半角逗号“|”分割,格式：名#####值|名#####值。</td>
    </tr>
    <tr>
      <th align="left">默认内容：</th>
      <td><input type="text" id="value_i" name="value_i" size="50" /> 
        * 表单默认值<span id="input_value_description" style="display:none;">，默认值须在默认数据“值”中</span>。</td>
    </tr>
    <tr>
      <th align="left">字段说明：</th>
      <td><input name="description" type="text" id="description" size="50" maxlength="255" /> 
        字段说明。</td>
    </tr>
    <tr>
      <th align="left">隐藏字段：</th>
      <td><input name="hidden" type="checkbox" id="hidden" value="1"></td>
    </tr>
    </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>



<table class="helptable" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td>备注：为了保持数据正确性，此栏目只能添加不能修改或删除，如需修改或删除，请直接从数据库里操作。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>