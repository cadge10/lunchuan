<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = (int)base::g('moduleid');
if ($moduleid <= 0) exit(base::msg('请正确访问此页面。'));

$field_pattern = array( 
	''=> '不使用规则',
	'email' => '电子邮件地址',
	'url' => '网址',
	'date' => '日期',
	'number'=> '有效的数值',
	'digits'=>  '数字',
	'zipcode'=> '邮编',
	'chinese'=> '中文字符',
	'cn_username'=> '中文英文和数字和下划线',
	'tel'=> '电话号码',
	'english'=> '英文',
	'en_num'=> '英文和数字和下划线',
);

if (base::p('action') == 'add') {
	base::issubmit();
	$type = trim(base::p('type'));
	$title = trim(base::p('title'));
	$name = trim(base::p('name'));
	$required = (int)trim(base::p('required'));
	$pattern = trim(base::p('pattern'));
	$minlength = (int)trim(base::p('minlength'));
	$maxlength = (int)trim(base::p('maxlength'));
	$sortid = (int)trim(base::p('sortid'));
	$status = (int)trim(base::p('status'));
	$defaultmsg = '';
	$errormsg = trim(base::p('errormsg'));
	if ($title == '' || $name == '' || $type == '') exit(base::msg('有必要的项目没有填写，请返回填写。'));
	
	// 获取数据库表字段
	$all = getFields('field');
	foreach ($all as $k=>$v) {
		$t = @$k;
		if (strtolower(trim($t)) == $title) exit(base::msg('该字段已经存在，请返回重新填写。'));
	}
	//*/
	
	$count = (int)@$db->get_count("SELECT COUNT(1) FROM `###_field` WHERE `title`='$title' AND moduleid='$moduleid' LIMIT 1");
	if ($count > 0) exit(base::msg('该字段已经存在，请返回重新填写。'));
	
	$addfieldsql =module::get_tablesql($_POST,'add');
	
	$setup = '';
	if($_POST['setup']) $setup=module::array2string($_POST['setup']);
	
	// 入库 module
	$sql = "INSERT INTO ###_field (
				moduleid,type,title,`name`,required,minlength,maxlength,pattern,defaultmsg,errormsg,setup,sortid,status
			) VALUES (
				'$moduleid','$type','$title','$name','$required','$minlength','$maxlength','$pattern','$defaultmsg','$errormsg','$setup','$sortid','$status'
			)";
	if ($db->query($sql)) {
		if(is_array($addfieldsql)){
			foreach($addfieldsql as $sql){
				$db->query($sql,false);
			}
		}else{ 
			$db->query($addfieldsql,false);
		}
		exit(base::alert('添加成功，请返回。','?mod=admin_module_field&moduleid='.$moduleid));
	} else {
		exit(base::msg('信息添加失败，请返回检查数据是否合法。'));
	}
	
}

function getFields($tableName) {
	$result =   $GLOBALS['db']->get_all('SHOW COLUMNS FROM ###_'.$tableName);
	$info   =   array();
	if($result) {
		foreach ($result as $key => $val) {
			$info[$val['Field']] = array(
				'name'    => $val['Field'],
				'type'    => $val['Type'],
				'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
				'default' => $val['Default'],
				'primary' => (strtolower($val['Key']) == 'pri'),
				'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
			);
		}
	}
	return $info;
}
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
<script type="text/javascript">
function field_setting(type)
{
	if ($.trim(type)== '') {
		$('#field_setup').html('');
		return ;
	}
    var data =  null;
    var url =  "admincp.php?a=ajax&mod=field_type&moduleid=<?php echo $moduleid;?>&type="+type;
    $.ajax({
         type: "POST",
         url: url,
         data: data,
		 beforeSend:function(){
			//$('#field_setup').html('<img src="admin/images/msg_loading.gif">');
		 },
         success: function(msg){
			$('#field_setup').html(msg);
         },
		 complete:function(){
		 },
		 error:function(){
		 }
    });
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <td><a href="?mod=admin_module_add" class="view"><?php echo adminpub::detailtitle_one('admin_module_add');?></a></td>
          <td><a href="?mod=admin_module" class="view"><?php echo adminpub::detailtitle_one('admin_module');?></a></td>
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_field_add&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one($view);?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_field&moduleid=<?php echo $moduleid?>" class="view"><?php echo adminpub::detailtitle_one('admin_module_field');?></a></td>
        </tr>
      </table>
  </tr>
</table>


<form action="" method="post" name="form1" id="myform">
<input name="action" type="hidden" id="action" value="add">
<input name="moduleid" type="hidden" id="moduleid" value="<?php echo $moduleid?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
      <th width="160" align="left">字段类型：</th>
      <td><select id="type" name="type" class="required" minlength="1" onChange="javascript:field_setting(this.value);">
		  <option value='' >请选择字段类型</option>
		  <option value="title">标题</option>
		  <option value="typeid">栏目</option>
		  <option value="text" >单行文本</option>
		  <option value="textarea" >多行文本</option>
		  <option value="editor" >编辑器</option>
		  <option value="select" >下拉列表</option>
		  <option value="radio" >单选按钮</option>
		  <option value="checkbox" >复选框</option>
		  <option value="image" >单张图片</option>
		  <option value="images" >多张图片</option>
		  <option value="file" >单文件上传</option>
		  <option value="files" >多文件上传</option>
		  <option value="number" >数字</option>
		  <option value="datetime" >日期和时间</option>
          <option value="relationid" >关联ID</option>
		  </select></td>
    </tr>
    <tr>
	  <th width="107" align="left">字段名：</th>
      <td><input type="text" id="title" name="title" size="30" validate="required:true, english:true,remote: 'admincp.php?a=ajax&mod=field_exists&table=field&field=title&moduleid=<?php echo $moduleid;?>' ,minlength:2, maxlength:20" /></td>
    </tr>
    <tr>
      <th align="left">字段别名：</th>
      <td><input type="text" id="name" name="name" size="30" class="required" /></td>
    </tr>
    <tr>
      <th align="left">字段相关设置：</th>
      <td><div id="field_setup"></div></td>
    </tr>
    <tr>
      <th align="left">是否必填：</th>
      <td><input type="radio" id="required" name="required" value="1">是  <input type="radio" name="required" value="0" checked> 否</td>
    </tr>
    <tr>
      <th align="left">是否启用：</th>
      <td><input name="status" type="radio" id="status" value="1" checked>是  <input type="radio" name="status" value="0"> 否</td>
    </tr>
    <tr>
      <th align="left">排序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="9" validate="required:true, digits:true"><span> *数字越小越靠前。</span></td>
    </tr>
    <tr>
      <th align="left">验证规则：</th>
      <td><select id="pattern" name="pattern">
      <?php
	  foreach ($field_pattern as $k=>$v) {
      ?>
      <option value="<?php echo $k;?>"><?php echo $v;?></option>
      <?php }?>
      </select></td>
    </tr>
    <tr>
      <th align="left">限制字符串长度范围：</th>
      <td>最小 <input type="text" id="minlength" name="minlength" size="2" /> 最大 <input type="text" id="maxlength" name="maxlength" size="2" />个字符</td>
    </tr>
    <tr>
      <th align="left">验证失败错误信息：</th>
      <td><input type="text" id="errormsg" name="errormsg" size="30" /></td>
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