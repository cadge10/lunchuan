<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$module = new module();

if (base::p('action') == 'add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p('title'));
	$name = trim(base::p('name'));
	$listfields = trim(base::p('listfields','*'));
	$issearch = (int)trim(base::p('issearch'));
	$description = trim(base::p('description'));
	$emptytable = (int)trim(base::p('emptytable'));
	$status = (int)trim(base::p('status'));
	$sortid = (int)trim(base::p('sortid'));
	$isdel = (int)trim(base::p('isdel'));
	$isadd = (int)trim(base::p('isadd'));
	$relation_table = trim(base::p('relation_table'));
	$relation_url = trim(base::p('relation_url'));
	$relation_name = trim(base::p('relation_name'));
	$issystem = 0;
	if ($title == '' || $name == '' || $listfields == '') exit(base::msg('有必要的项目没有填写，请返回填写。'));
	
	// 入库 module
	$sql = "UPDATE ###_module SET
				title='$title',description='$description',issystem='$issystem',issearch='$issearch',
				listfields='$listfields',status='$status',sortid='$sortid',isdel='$isdel',isadd='$isadd',
				relation_table='$relation_table',relation_url='$relation_url',relation_name='$relation_name'
			WHERE id='$id'";
	if ($db->query($sql)) {
		$module_id = $db->insert_id();
		if ($emptytable == 1) {
			$type = 'emptytable';
		} else {
			$type = 'pubtable';
		}
		$module->create_module($module_id,$name,$type);
		exit(base::alert('修改成功，请返回。','?mod=admin_module'));
	} else {
		exit(base::msg('信息修改失败，请返回检查数据是否合法。'));
	}
	
}
$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_module where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="admin/images/validate.js"></script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_add" class="view"><?php echo adminpub::detailtitle_one('admin_module_add');?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module" class="view"><?php echo adminpub::detailtitle_one('admin_module');?></a></td>
        </tr>
      </table>
  </tr>
</table>


<form action="" method="post" name="myform" id="myform">
<input name="action" type="hidden" id="action" value="add">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="120" align="left">模型名称：</th>
      <td><input name="title" type="text" id="title" size="30" maxlength="50" validate="required:true, minlength:2, maxlength:30" title="模型名称必须为2-30个字" value="<?php echo $one['title']?>" /><span> *</span></td>
    </tr>
    <tr>
      <th align="left">模型表名：</th>
      <td><input name="name" type="text" id="name" size="30" maxlength="50" value="<?php echo $one['name']?>" readonly /><span> *</span></td>
    </tr>
    <tr>
      <th align="left">列表页调用字段：</th>
      <td><input name="listfields" type="text" id="listfields" value="<?php echo $one['listfields']?>" size="50" />
        例：id,title,typeid</td>
    </tr>
    <tr style="display:none;">
      <th align="left">前台搜索模型：</th>
      <td><input type="radio" name="issearch" id="issearch"  value="1"<?php if($one['issearch']==1){echo ' checked';}?> > 是<input type="radio" name="issearch" id="issearch" value="0"<?php if($one['issearch']==0){echo ' checked';}?> > 否</td>
    </tr>
    <tr>
      <th align="left">模型简介：</th>
      <td><textarea id="description" name="description" rows="4" cols="55"><?php echo $one['description']?></textarea></td>
    </tr>
    <tr>
      <th align="left">关联数据表：</th>
      <td><input name="relation_table" type="text" id="relation_table" size="50" value="<?php echo $one['relation_table']?>" /> 
        *不关联请为空，多个逗号分隔</td>
    </tr>
    <tr>
      <th align="left">关联数据地址：</th>
      <td><input name="relation_url" type="text" id="relation_url" size="50" value="<?php echo $one['relation_url']?>" />
*不关联请为空，多个逗号分隔</td>
    </tr>
    <tr>
      <th align="left">关联数据别名：</th>
      <td><input name="relation_name" type="text" id="relation_name" size="50" value="<?php echo $one['relation_name']?>" />
*不关联请为空，多个逗号分隔</td>
    </tr>
    <tr>
      <th align="left">是否启用：</th>
      <td><input name="status" type="radio" id="status"  value="1"<?php if($one['status']==1){echo ' checked';}?> > 是<input type="radio" name="status" id="status" value="0"<?php if($one['status']==0){echo ' checked';}?> > 否</td>
    </tr>
    <tr>
      <th align="left">是否允许删除数据：</th>
      <td><input name="isdel" type="radio" id="isdel"  value="1"<?php if($one['isdel']==1){echo ' checked';}?> > 是<input type="radio" name="isdel" id="isdel" value="0"<?php if($one['isdel']==0){echo ' checked';}?> > 否</td>
    </tr>
    <tr>
      <th align="left">是否允许添加数据：</th>
      <td><input name="isadd" type="radio" id="isadd"  value="1"<?php if($one['isadd']==1){echo ' checked';}?> > 是<input type="radio" name="isadd" id="isadd" value="0"<?php if($one['isadd']==0){echo ' checked';}?> > 否</td>
    </tr>
    <tr>
      <th align="left">排序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="9" validate="required:true, digits:true"><span> *数字越小越靠前。</span></td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>


<?php include('bottom.php');?>
</body>
</html>