<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action')=='add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p('title'));
	$attr_group = trim(base::p('attr_group'));
	$sortid = (int)base::p('sortid');
	if ($title=='') exit(base::alert('请填写栏目名称！'));
	
	$old_groups = product::get_attr_groups($id);
	
	$sql = "update ###_productptype set title='$title',sortid='$sortid',attr_group='$attr_group' where id='$id'";
	$re = $db->query($sql);
	
	if ($re) {
        /* 对比原来的分组 */
        $new_groups = explode("\n", str_replace("\r", '', $attr_group));  // 新的分组

        foreach ($old_groups AS $key=>$val)
        {
            $found = array_search($val, $new_groups);

            if ($found === NULL || $found === false)
            {
                /* 老的分组没有在新的分组中找到 */
                product::update_attribute_group($id, $key, 0);
            }
            else
            {
                /* 老的分组出现在新的分组中了 */
                if ($key != $found)
                {
                    product::update_attribute_group($id, $key, $found); // 但是分组的key变了,需要更新属性的分组
                }
            }
        }
	}
	exit(base::alert('修改成功，请返回！','?mod=admin_product_ptype'));
}
$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_productptype where id='$id'");
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
		alert('请填写类型名称。');
		frm.title.focus();
		return false;
	}
	return true;
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
<input name="action" type="hidden" id="action" value="add">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">类型名称：</th>
      <td><input name="title" type="text" id="title" size="30" maxlength="50" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">属性分组：</th>
      <td><textarea name="attr_group" id="attr_group" cols="45" rows="5"><?php echo $one['attr_group']?></textarea><br />每行一个商品属性组。排序也将按照自然顺序排序。
</td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="5" />
*数字越小越靠前。</td>
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