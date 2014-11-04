<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$typeid = (int)base::g('typeid');
if ($typeid<=0) exit(base::alert('请正确访问此页面。'));
if (base::p('action')=='add') {
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('错误的参数传递！'));
	$title = trim(base::p('title'));
	$typeid = (int)base::p('typeid');
	$attrtype = (int)base::p('attrtype');
	$attrinputtype = (int)base::p('attrinputtype');	
	$attrvalue = trim(base::p('attrvalue'));
	$sortid = (int)base::p('sortid');
	$attr_group = (int)base::p('attr_group');
	
	if ($attrinputtype==2 && $attrvalue=='') exit(base::alert('请填写可选值列表的值。'));

	$sql = "update ###_productattribute set title='$title',typeid='$typeid',attrtype='$attrtype',attrinputtype='$attrinputtype',attrvalue='$attrvalue',sortid='$sortid',attr_group='$attr_group' where id='$id'";
	$db->query($sql);
	
	exit(base::alert('修改成功，请返回。','?mod=admin_product_attribute&typeid='.$typeid));
}
$id = (int)base::g('id');
if ($id<=0) exit(base::alert('错误的参数传递！'));
$one = $db->get_one("select * from ###_productattribute where id='$id'");
if (empty($one)) exit('没有找到你要的数据。');
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function checkForm(str) {
	if (str.title.value.trim()=='') {
		alert('请填写属性的名称！');
		str.title.focus();
		return false;
	}
	if (str.typeid.value.trim()==0) {
		alert('请选择所属产品类型！');
		str.typeid.focus();
		return false;
	}
	return true;
}

/**
 * 改变商品类型的处理函数
 */
function onChangeGoodsType(catId,groupId) {
	$.get('admincp.php',{r:Math.random(),a:'ajax',mod:'changgoodstype',id:catId,attr_group:groupId},function(data){
		data = $.trim(data);
		if (data!='') {
			$('#attr_group').empty();
			$('#attr_group').append(data);
			$('#attrGroups').css('display','');
		} else {
			$('#attr_group').append('<option value="0">默认</option>');
			$('#attrGroups').css('display','none');
		}
	});
}

$(function(){
	onChangeGoodsType(<?php echo $typeid;?>,<?php echo $one['attr_group']?>);
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <td class="active"><a href="?mod=admin_product_attribute_add&typeid=<?php echo $typeid;?>" class="view">添加属性</a></td>
          <td><a href="?mod=admin_product_attribute&typeid=<?php echo $typeid;?>" class="view">修改属性</a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<input name="action" type="hidden" id="action" value="add">
<input name="id" type="hidden" id="id" value="<?php echo $id;?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">属性名称：</th>
      <td><input type="text" id="title" name="title" size="30" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">所属产品类型：</th>
      <td><select name="typeid" id="typeid" onChange="onChangeGoodsType(this.value,0);">
        <option value="0">请选择...</option>
        <?php
        $re = $db->query("select id,title from ###_productptype order by sortid asc,id asc",false);
		while ($rs = $db->fetch_array($re)) {
		?>
        <option value="<?php echo $rs[0]?>"><?php echo $rs[1]?></option>
        <? }?>
        </select>
        <script type="text/javascript">CheckSel('typeid','<?php echo $one['typeid']?>')</script></td>
    </tr>
    <tr id="attrGroups" style="display:none;">
      <th align="left">属性分组：</th>
      <td><select name="attr_group" id="attr_group">
        <option value="0">默认</option>
      </select></td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="5" />
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">属性是否可选：</th>
      <td><input name="attrtype" type="radio" id="attrtype" value="1">
        唯一属性
          <input type="radio" name="attrtype" id="attrtype" value="2">
          单选属性
          <input type="radio" name="attrtype" id="attrtype" value="3">
        复选属性<script type="text/javascript">CheckOption(document.form1,'radio','attrtype','<?php echo $one['attrtype']?>')</script></td>
    </tr>
    <tr>
      <th align="left">该属性值的录入方式：</th>
      <td><input name="attrinputtype" type="radio" id="attrinputtype" value="1" onClick="document.getElementById('attrvalue').disabled=true;">
        手工录入
        <input type="radio" name="attrinputtype" id="attrinputtype" value="2" onClick="document.getElementById('attrvalue').disabled=false;">
        从下面的列表中选择（一行代表一个可选值）
        <input type="radio" name="attrinputtype" id="attrinputtype" value="3" onClick="document.getElementById('attrvalue').disabled=true;">
        多行文本框<script type="text/javascript">CheckOption(document.form1,'radio','attrinputtype','<?php echo $one['attrinputtype']?>')</script></td>
    </tr>
    <tr>
      <th align="left">可选值列表：</th>
      <td><textarea name="attrvalue" cols="60" rows="5" id="attrvalue"<?php if ($one['attrinputtype']!=2){echo ' disabled';}?>><?php echo $one['attrvalue']?></textarea></td>
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