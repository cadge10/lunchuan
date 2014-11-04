<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$role = adminpub::showadminrole();

if (base::p('action')=='add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p('title'));
	$content = trim(base::p('content'));
	$role = base::p('role');
	$module_role = base::p('module_role');
	if ($role) {
		$rolestr = implode(',',$role);
	} else {
		$rolestr = '';
	}
	
	if ($module_role) {
		$module_role_str = serialize($module_role);
	} else {
		$module_role_str = '';
	}
	if ($title=='') exit(base::alert('请填写角色名称！'));
	$sql = "update ###_role set title='$title',content='$content',role='$rolestr',module_role='$module_role_str' where id='$id'";
	$db->query($sql);
	exit(base::alert('角色修改成功，请返回！','?mod=admin_admin_role'));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_role where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
$module_role = trim($one['module_role']);

if ($module_role != '') {
	$module_role_data = @unserialize($module_role);
} else {
	$module_role_data = array();
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert('请填写角色名称！');
		frm.title.focus();
		return false;
	}
	return true;
}
function set_parent_checked(frm,key) {
	var ele = document.form1.elements;
	var cou = 0;
	var cou2 = 0;
	len = $(".role_child_"+key).length;
	if (frm.checked) {		
		for (i=0;i<len;i++) {
			if ($("#role_child_"+key+"_"+(i+1)).attr("checked")==true) {
				cou++;
			}
		}
	} else {
		for (i=0;i<len;i++) {
			if ($("#role_child_"+key+"_"+(i+1)).attr("checked")==false) {
				cou2++;
			}
		}
		cou = len-cou2;
	}
	if (cou>0) {
		document.getElementById("role_"+key).checked = true;
	} else {
		document.getElementById("role_"+key).checked = false;
	}
}
function set_child_checked(frm,key) {
	var ele = document.form1.elements;
	if (!document.getElementById("role_"+key).checked) {
		for (i = 0; i < ele.length; i++) {
			if (ele[i].getAttribute("rel") == "role_child_"+key) {
				ele[i].checked = false;
			}
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
			if (ele[i].value == arr[s] && ele[i].name == id) {
				ele[i].checked = true;
			}
		}
	}
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">角色名称：
	    <input name="action" type="hidden" id="action" value="add">
	    <input name="id" type="hidden" id="id" value="<?php echo $one['id']?>"></th>
      <td><input type="text" id="title" name="title" size="30" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">角色介绍：</th>
      <td><input type="text" id="content" name="content" size="30" value="<?php echo $one['content']?>" /></td>
    </tr>
    <tr>
      <th align="left">分配权限：</th>
      <td><?php echo adminpub::showadminrole();?><script type="text/javascript">CheckOption(document.form1,'checkbox','role[]','<?php echo $one['role']?>');</script></td>
    </tr>
<?php
      $sql = "SELECT id,title,`name` FROM ###_module WHERE status=1 ORDER BY sortid ASC,id DESC";
	  $all = @$db->get_all($sql);
	  if(!empty($all)) {
?>
    <tr>
      <th align="left">模型权限：</th>
      <td>
      <?php

	  foreach ($all as $k=>$v) {
		  $m_data = @$module_role_data[$v['name']];
	  ?>
      <div style="font-weight:bold;">
      <input type="checkbox" name="module_role[<?php echo $v['name'];?>][parent]" id="role_999999<?php echo $v['id']?>" class="role_999999<?php echo $v['id']?>" value="<?php echo $v['id']?>" onClick="set_child_checked(this,999999<?php echo $v['id']?>)"<?php echo $v['id']==@$m_data['parent']?' checked':'';?> /><?php echo $v['title']?>
      </div>
      <div style="padding-left:20px;">
      <input type="checkbox" name="module_role[<?php echo $v['name'];?>][list]" id="role_child_999999<?php echo $v['id']?>_1" rel="role_child_999999<?php echo $v['id']?>" class="role_child_999999<?php echo $v['id']?>" value="list" onClick="set_parent_checked(this,999999<?php echo $v['id']?>)"<?php echo @$m_data['list']=='list'?' checked':'';?> />查看数据
      <input type="checkbox" name="module_role[<?php echo $v['name'];?>][add]" id="role_child_999999<?php echo $v['id']?>_2" rel="role_child_999999<?php echo $v['id']?>" class="role_child_999999<?php echo $v['id']?>" value="add" onClick="set_parent_checked(this,999999<?php echo $v['id']?>)"<?php echo @$m_data['add']=='add'?' checked':'';?> />添加数据
      <input type="checkbox" name="module_role[<?php echo $v['name'];?>][edit]" id="role_child_999999<?php echo $v['id']?>_3" rel="role_child_999999<?php echo $v['id']?>" class="role_child_999999<?php echo $v['id']?>" value="edit" onClick="set_parent_checked(this,999999<?php echo $v['id']?>)"<?php echo @$m_data['edit']=='edit'?' checked':'';?> />修改数据
      <input type="checkbox" name="module_role[<?php echo $v['name'];?>][del]" id="role_child_999999<?php echo $v['id']?>_4" rel="role_child_999999<?php echo $v['id']?>" class="role_child_999999<?php echo $v['id']?>" value="del" onClick="set_parent_checked(this,999999<?php echo $v['id']?>)"<?php echo @$m_data['del']=='del'?' checked':'';?> />删除数据
      </div>
      <?php }?>
      </td>
    </tr>
<?php }?>
    <tr>
      <th align="left">全部选择：</th>
      <td><input name="chkall" type="checkbox" id="chkall" value="checkbox" onClick="checkAll(this.form);" />
  <label for="chkall">全选</label></td>
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
    <td>注释：如果选择二级权限，一级必须选择，否则无效。</td>
  </tr>
</table>
<?php include('bottom.php');?>
</body>
</html>