<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p("action")=="add") {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p("title"));
	$sortid = (int)trim(base::p("sortid"));
	$typeid = (int)trim(base::p("typeid"));
	$url = trim(base::p("url"));
	$pic = trim(base::p("pic"));
	$isshow = (int)base::p("isshow");
	// 检索
	if ($title=='') exit(base::alert("链接名称不能为空。"));
	if ($url=='') exit(base::alert("链接地址不能为空。"));
	// 入库
	$sql = "update ###_links set title='$title',sortid='$sortid',url='$url',pic='$pic',isshow='$isshow',typeid='$typeid' where id='$id'";
	$db->query($sql);
	exit(base::alert("修改成功，请返回。","?mod=admin_links"));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_links where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert("链接名称不能为空。");
		frm.title.focus();
		return false;
	}
	if (frm.typeid.value==0) {
		alert("请选择链接类别。");
		frm.typeid.focus();
		return false;
	}
	if (frm.sortid.value=='') {
		alert("链接顺序不能为空，如不排序，可默认为0。");
		frm.sortid.focus();
		return false;
	}
	if (frm.url.value=='') {
		alert("链接地址不能为空。");
		frm.url.focus();
		return false;
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


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this)">
<input name="action" type="hidden" id="action" value="add">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">链接名称：</th>
      <td><input type="text" id="title" name="title" value="<?php echo $one['title']?>" size="30" /></td>
    </tr>
    <tr>
      <th align="left">链接类别：</th>
      <td><select name="typeid" id="typeid">
        <option value="0">请选择类别……</option>
        <?php
        $type_data = $db->get_all("select id,title from ###_linkstype order by sortid asc");
		foreach ($type_data as $data) {
		?>
        <option value="<?php echo $data[0]?>"<?php if($one['typeid']==$data[0]){echo ' selected';}?>><?php echo $data[1]?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="5" />
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">链接网址：</th>
      <td><input type="text" id="url" name="url" size="50" value="<?php echo $one['url']?>" /></td>
    </tr>
    <tr>
      <th align="left">链接图片：</th>
      <td><div style="float:left;"><input name="pic" type="text" class="input" id="pic" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="50" value="<?php echo $one["pic"]?>">
		</div>
        <div style="float:left; padding-left:7px;"><iframe src="includes/upload.php?name=pic" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部图片，必须以http://开头。</div></td>
    </tr>
    <tr>
      <th align="left">是否显示：</th>
      <td><input name="isshow" type="radio" id="radio" value="1"<?php if ($one['isshow']==1){echo ' checked';}?>>
        显示
          <input type="radio" name="isshow" id="radio2" value="0"<?php if ($one['isshow']==0){echo ' checked';}?>>
        不显示</td>
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