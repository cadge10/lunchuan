<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_careers where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script></head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1">
<input name="action" type="hidden" id="action" value="add">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
      <th align="left">应聘岗位：</th>
      <td><?php echo $one["jobs_title"]?></td>
    </tr>
    <tr>
	  <th width="107" align="left">姓名：</th>
      <td width="552"><?php echo $one["realname"]?></td>
    </tr>
    <tr>
      <th align="left">性别：</th>
      <td><?php echo $one["sex"]?></td>
    </tr>
    <tr>
      <th align="left">出生日期：</th>
      <td><?php echo $one["birthday"]?></td>
    </tr>
    <tr>
      <th align="left">最高学历：</th>
      <td><?php echo $one["xueli"]?></td>
    </tr>
    <tr>
      <th align="left">毕业院校：</th>
      <td><?php echo $one["yuanxiao"]?></td>
    </tr>
    <tr>
      <th align="left">专业：</th>
      <td><?php echo $one["zhuanye"]?></td>
    </tr>
    <tr>
      <th align="left">薪资要求：</th>
      <td><?php echo $one["xinzi"]?></td>
    </tr>
    <tr>
      <th align="left">工作经验：</th>
      <td><?php echo nl2br($one["jingyan"])?></td>
    </tr>
    <tr>
      <th align="left">联系地址：</th>
      <td><?php echo $one["address"]?></td>
    </tr>
    <tr>
      <th align="left">联系电话：</th>
      <td><?php echo $one["tel"]?></td>
    </tr>
    <tr>
      <th align="left">电子邮箱：</th>
      <td><?php echo $one["email"]?></td>
    </tr>
    <tr>
      <th align="left">应聘时间：</th>
      <td><?php echo date("Y-m-d H:i:s",$one["addtime"])?></td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="button" name="Submit" value=" 返回上一页 " onClick="history.back();" class="submit">
</div>
</form>


<?php include('bottom.php');?>
</body>
</html>