<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p("action")=="add") {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$title = trim(base::p("title"));
	$xinzi = trim(base::p("xinzi"));
	$xueli = trim(base::p("xueli"));
	$renshu = trim(base::p("renshu"));
	$content = trim(base::p("content"));
	$youxiao = trim(base::p("youxiao"));
	$address = trim(base::p("address"));
	$starttime2 = trim(base::p("starttime"));
	$starttime = @strtotime($starttime2);
	$sortid = (int)base::p("sortid");
	$isshow = (int)base::p("isshow");
	// 检索
	if ($title=='') exit(base::alert("请填写职位名称。"));
	if ($xinzi=='') exit(base::alert("请填写薪资要求。"));
	if ($renshu=='') exit(base::alert("请填写招聘人数。"));
	if ($address=='') exit(base::alert("请填写工作地点。"));
	if ($youxiao=='') exit(base::alert("请填写有效时间。"));
	if ($starttime2=='') exit(base::alert("请选择生效时间。"));
	// 入库
	$sql = "update ###_jobs set title='$title',xinzi='$xinzi',xueli='$xueli',renshu='$renshu',content='$content',youxiao='$youxiao',starttime='$starttime',sortid='$sortid',isshow='$isshow',address='$address' where id='$id'";
	
	$db->query($sql);
	exit(base::alert("修改成功，请返回。","?mod=admin_jobs"));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_jobs where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert("请填写职位名称。");
		frm.title.focus();
		return false;
	}
	if (frm.xinzi.value=='') {
		alert("请填写薪资要求。");
		frm.xinzi.focus();
		return false;
	}
	if (frm.renshu.value=='') {
		alert("请填写招聘人数。");
		frm.renshu.focus();
		return false;
	}
	if (frm.address.value=='') {
		alert("请填写工作地点。");
		frm.address.focus();
		return false;
	}
	if (frm.youxiao.value=='') {
		alert("请填写有效时间。");
		frm.youxiao.focus();
		return false;
	}
	if (frm.starttime.value=='') {
		alert("请选择生效时间。");
		frm.starttime.focus();
		return false;
	}
	return true;
}
</script>
<link href="js/calendar/calendar.css" rel="stylesheet" type="text/css">
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
	  <th width="107" align="left">职位名称：</th>
      <td width="552"><input type="text" id="title" name="title" size="30" value="<?php echo $one["title"]?>" /></td>
    </tr>
    <tr>
      <th align="left">排列顺序：</th>
      <td><input name="sortid" type="text" id="sortid" value="<?php echo $one["sortid"]?>" size="10" maxlength="5" />
        *数字越小越靠前。</td>
    </tr>
    <tr>
      <th align="left">薪资待遇：</th>
      <td><input type="text" id="xinzi" name="xinzi" size="30" value="<?php echo $one["xinzi"]?>" /> 
        * 如：3000以上或面议。</td>
    </tr>
    <tr>
      <th align="left">学历要求：</th>
      <td><select name="xueli" class="input" id="xueli">
            <option value="学历不限">学历不限</option>
            <option value="博士以上">博士以上</option>
            <option value="博士">博士</option>
            <option value="硕士">硕士</option>
            <option value="大学本科">大学本科</option>
            <option value="大专(职高)">大专(职高)</option>
            <option value="中专">中专</option>
            <option value="职高/技校">职高/技校</option>
            <option value="高中">高中</option>
            <option value="初中">初中</option>
        </select><script type="text/javascript">CheckSel("xueli","<?php echo $one["xueli"]?>")</script></td>
    </tr>
    <tr>
      <th align="left">招聘人数：</th>
      <td><input type="text" id="renshu" name="renshu" size="30" value="<?php echo $one["renshu"]?>" /> 
        *单位：人</td>
    </tr>
    <tr>
      <th align="left">工作地点：</th>
      <td><input type="text" id="address" name="address" size="30" value="<?php echo $one["address"]?>" /> 
        * 如：浙江杭州</td>
    </tr>
    <tr>
      <th align="left">有效时间：</th>
      <td><input name="youxiao" type="text" id="youxiao" value="<?php echo $one["youxiao"]?>" size="30" /> 
        * 
        单位：天。</td>
    </tr>
    <tr>
      <th align="left">生效时间：</th>
      <td><input type="text" id="starttime" name="starttime" size="30" value="<?php echo date("Y-m-d",$one["starttime"]);?>" onClick="return showCalendar('starttime', '%Y-%m-%d', false, false, 'starttime');" /></td>
    </tr>
    <tr>
      <th align="left">职位描述：</th>
      <td><textarea name="content" id="content" cols="70" rows="8"><?php echo $one["content"]?></textarea></td>
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