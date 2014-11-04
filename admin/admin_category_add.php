<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = $moduleid_g = (int)base::g('moduleid');
if ($moduleid<=0) $moduleid = 0;
if (base::p('action')=='add') {
	base::issubmit();
	$typeid = (int)base::p('typeid');
	$title = trim(base::p('title'));
	$sortid = (int)base::p('sortid');
	$moduleid = (int)base::p('moduleid');
	$isshow = (int)base::p('isshow');
	$url = trim(base::p('url'));
	if ($moduleid==0) exit(base::alert('请选择模型！'));
	if ($title=='') exit(base::alert('请填写栏目名称！'));
	$sql = "insert into ###_category(moduleid,title,typeid,sortid,url,isshow)values('$moduleid','$title','$typeid','$sortid','$url','$isshow')";
	$db->query($sql);
	
	exit(base::alert('添加成功，请返回！','?mod=admin_category&moduleid='.$moduleid_g));
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
<script type="text/javascript">
function checkForm(frm) {
	if (frm.moduleid.value==0) {
		alert('请选择模型。');
		return false;
	}
	if (frm.title.value=='') {
		alert('请填写栏目名称。');
		frm.title.focus();
		return false;
	}
	return true;
}

function get_category() {
	m_id = $('#moduleid').val();
	$.get('admincp.php',{r:Math.random(),a:'ajax','mod':'admin_category',moduleid:m_id,parentid:<?php echo (int)base::g('parentid')?>},function(data){$('#ajax_category').html(data);});
}
$(function(){
	get_category();
	$('#moduleid').change(function(){get_category();});
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
          <td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_category_add" class="view"><?php echo adminpub::detailtitle_one($view);?></a></td>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_category" class="view"><?php echo adminpub::detailtitle_one('admin_category');?></a></td>
        </tr>
      </table>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<input name="action" type="hidden" id="action" value="add">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody>
    <tr>
      <th align="left">请选择模型：</th>
      <td><select name="moduleid" id="moduleid">
		  <?php
          $m_all = $db->get_all("SELECT id,title FROM ###_module WHERE status=1 ORDER BY sortid ASC,id DESC");
		  if (!empty($m_all)) {
		  foreach ($m_all as $v) {
		  ?>
          <option value="<?php echo $v['id']?>"<?php echo (int)base::g('moduleid')==$v['id']?' selected':'';?>><?php echo $v['title']?></option>
          <?php }}else{?>
          <option value="0">请添加模型后再添加栏目</option>
          <?php }?>
        </select></td>
    </tr>
    <tr>
	  <th width="107" align="left">栏目名称：</th>
      <td><input type="text" id="title" name="title" size="30" /></td>
    </tr>
    <tr>
      <th align="left">所属栏目：</th>
      <td><span id="ajax_category">加载中...</span></td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1" checked />
        是</td>
    </tr>
    <tr>
      <th align="left">栏目顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="0" size="10" maxlength="5" />
*数字越小越靠前。</td>
    </tr>
    <tr style="display:none;">
      <th align="left">外部链接：</th>
      <td><input name="url" type="text" id="url" size="30" /> 
        *填写后该栏目跳转到该地址。</td>
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