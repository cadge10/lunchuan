<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
if (base::g('mode') == 'bak') {
	base::issubmit();
	$title = trim(base::p('title'));
	$type = (int)base::p("type")==1?1:2;
	if ($title == '') die(base::alert('请填写保存的数据库名！'));
	$link=mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD);
	mysql_select_db(DB_NAME,$link);
	mysql_query("set names 'utf8'");
	
	$mysql="SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\r\n";
	$q1=mysql_query("show tables");
	while($t=mysql_fetch_array($q1))
	{
		 $table=$t[0];
		 if ($type==1) // 只备份本站的表结构及数据
		 	if (substr($table,0,strlen(DB_PREFIX)) != DB_PREFIX) continue;
		 //echo "DROP TABLE IF EXISTS ".$table."<br><br>";
		 $mysql.="DROP TABLE IF EXISTS `".$table."`;\r\n";
		 $q2=mysql_query("show create table ".$table);
		 $sql=mysql_fetch_array($q2);
		 $mysql.=$sql['Create Table'].";\r\n\r\n";
	
		 //echo $sql['Create Table'];
		 $q3=mysql_query("select * from ".$table);
		 while($data=mysql_fetch_assoc($q3))
		  {
				 $keys=array_keys($data);
				 $keys=array_map('addslashes',$keys);
				 $keys=join('`,`',$keys);
				 $keys="`".$keys."`";
	
				 $vals=array_values($data);
				 $vals=array_map('addslashes',$vals);
				 $vals=join("','",$vals);
				 $vals="'".$vals."'";
	
				 $mysql.="insert into `$table`($keys) values($vals);\r\n";
		  }
		 $mysql.="\r\n";
	}
	// 检测备份目录是否存在，不存在则创建
	$path = "data/bakup/";
	if (!file_exists($path)) {
		@mkdir($path);
	}
	// 写入文件
	$bool = file_put_contents($path.$title,$mysql);
	if ($bool) {
		die(base::alert($title.' 备份成功！','?mod=admin_database&action=list'));
	}
}

if (base::g('mode') == 'restore') {
	base::issubmit();
	$file = trim($_POST['file']);
	if (!file_exists($file)) {
		die(base::alert('该备份文件不存在，请重新选择！'));
	}
	$sqlfile=fopen($file,'rb');
	$str=fread($sqlfile,filesize($file));
	$str=str_replace("\r","\n",$str);
	$sqlarr=explode(";\n",trim($str));
	$queryarr = array();
	foreach($sqlarr as $key => $values)
	{
		foreach(explode("\n",trim($values)) as $rows)
		@$queryarr[$key].= $rows[0]=='#' || $rows[0].$rows[1] == '--' ? '' : $rows;
	}
	$link=mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD);
	mysql_select_db(DB_NAME,$link);
	mysql_query("set names 'utf8'");
	foreach($queryarr as $values)
	{
		if(!mysql_query($values,$link))
		{
			exit();
		}
	}
	die(base::alert('数据库还原成功，请返回！','?mod=admin_database&action=list'));
}

if (base::g('mode') == 'optimize') {
	base::issubmit();
	$conn = mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD) or exit('Connection err!');
	mysql_select_db(DB_NAME,$conn) or exit('Select database err!');
	mysql_query("set names 'utf8'");
	
	$database = $_POST['database'];
	if(!$database) exit("<script>alert('请选择您要优化的表！');history.back();</script>");
	$str = implode(',',$database);
	$result = mysql_query("optimize table $str",$conn);
	
	die(base::alert('优化表数据成功，请返回！','?mod=admin_database&action=optimize'));
}

if (base::g('mode') == 'truncate') {
	base::issubmit();
	$conn = mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD) or exit('Connection err!');
	mysql_select_db(DB_NAME,$conn) or exit('Select database err!');
	mysql_query("set names 'utf8'");
	
	$database = $_POST['database'];
	if(!$database) exit("<script>alert('请选择您要清空的表！');history.back();</script>");
	$count = count($database);
	for ($i = 0; $i < $count; $i++) {
		$result = mysql_query("truncate table {$database[$i]}",$conn);
	}
	die(base::alert('清空表数据成功，请返回！','?mod=admin_database&action=truncate'));
}

$action = isset($_GET['action'])?$_GET['action']:'list';
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
$(function(){
	$('.darkrow').hover(function(){$(this).addClass('darkrow_out');},function(){$(this).removeClass('darkrow_out');});
});

function checkForm(str) {
	if (str.title.value == '') {
		alert('数据库名不能为空！');
		str.title.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1>数据库管理</h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <td<?php if ($action=='list'){echo " class=\"active\"";}?>><a href="?mod=admin_database&action=list" class="view">数据库列表</a></td>
          <td<?php if ($action=='bak'){echo " class=\"active\"";}?>><a href="?mod=admin_database&action=bak" class="view">备份数据库</a></td>
          <td<?php if ($action=='restore'){echo " class=\"active\"";}?> style="display:none;"><a href="?mod=admin_database&action=restore" class="view">还原数据库</a></td>
          <td<?php if ($action=='optimize'){echo " class=\"active\"";}?>><a href="?mod=admin_database&action=optimize" class="view">优化表数据</a></td>
          <td<?php if ($action=='truncate'){echo " class=\"active\"";}?> style="display:none;"><a href="?mod=admin_database&action=truncate" class="view">清空表数据</a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<?php if ($action=='bak') {?>
<form action="?mod=admin_database&mode=bak" method="post" name="form1" id="form1">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
      <th align="left">备份类型：</th>
      <td><input name="type" type="radio" id="radio" value="1" checked>只备份前缀为“<?php echo DB_PREFIX;?>”的表及数据
        <input type="radio" name="type" id="radio2" value="2">备份全部</td>
    </tr>
    <tr>
	  <th width="150" align="left"><b>数据库保存文件名：</b></th>
      <td><input name="title" type="text" class="styleobrder" value="bak_<?php echo date("YmdHis");?>.sql" id="title" size="30" maxlength="50" />        
         * 保存在根目录下的bakup目录下。</td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>
<?php }?>

<?php if ($action=='restore') {?>
<form action="?mod=admin_database&mode=restore" method="post" name="form1" id="form1" onSubmit="return confirm('您确定要还原吗？该操作不可恢复！')">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="150" align="left"><b>请选择要还原的数据库：</b></th>
      <td><select name="file" class="input" id="file">
		<?php
		// 检测备份目录是否存在，不存在则创建
		$path = "data/bakup/";
		if (!file_exists($path)) {
			@mkdir($path);
		}
		if ($dh = opendir($path)) {
			while (($file = readdir($dh)) !== false) {
				if ($file == '.' || $file == '..') continue;
		?>
	    <option value="<?php echo $path.$file?>"><?php echo $file?></option>
		<?php
			}
		}
		?>
	    </select>
	   *注意，该操作会删除原来的数据！</td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>
<?php }?>

<?php if ($action=='optimize') {?>
<form action="?mod=admin_database&mode=optimize" method="post" name="form1" id="form1">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="150" align="left"><b>请选择需要优化的表：</b></th>
      <td>
		<?php
        $conn = mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD) or exit('Connection err!');
        mysql_select_db(DB_NAME,$conn) or exit('Select database err!');
        $result = mysql_query("show tables",$conn);
        echo "<input name=\"mode\" type=\"hidden\" id=\"mode\" value=\"optimize\" />\n<select name=\"database[]\" id=\"database[]\" multiple=\"multiple\" size=\"15\" style=\"width:260px;\">\n";
		$cou = 0;
        while($rs = mysql_fetch_row($result)) {
            echo "<option value=\"{$rs[0]}\" selected=\"selected\">{$rs[0]}</option>\n";
			$cou++;
        }
        echo "</select>\n";
		echo "共 {$cou} 个表可以进行优化。";
        ?>
      </td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>
<?php }?>

<?php if ($action=='truncate') {?>
<form action="?mod=admin_database&mode=truncate" method="post" name="form1" id="form1" onSubmit="return confirm('您确定要清空表数据吗？该操作不可恢复！')">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="150" align="left"><b>请选择需要清空的表：</b></th>
      <td>
		<?php
        $conn = mysql_connect(DB_HOST.":".DB_PORT,DB_USER,DB_PASSWORD) or exit('Connection err!');
        mysql_select_db(DB_NAME,$conn) or exit('Select database err!');
        $result = mysql_query("show tables",$conn);
        echo "<input name=\"mode\" type=\"hidden\" id=\"mode\" value=\"optimize\" />\n<select name=\"database[]\" id=\"database[]\" multiple=\"multiple\" size=\"15\" style=\"width:260px;\">\n";
		$cou = 0;
        while($rs = mysql_fetch_row($result)) {
            if ($rs[0]==DB_PREFIX.'admin' || $rs[0]==DB_PREFIX.'role' || $rs[0]==DB_PREFIX.'config' || $rs[0]==DB_PREFIX.'admincolumn') continue;
			echo "<option value=\"{$rs[0]}\">{$rs[0]}</option>\n";
			$cou++;
        }
        echo "</select>\n";
		echo "共 {$cou} 个表可以进行清空。";
        ?>
      </td>
    </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>
<?php }?>

<?php if ($action=='list') {
	// 删除
	$chk = base::p('chk');
	if ($chk) {
		$count = count($chk);
		for($i = 0; $i < $count; $i++) {
			$file = $chk[$i];
			if (file_exists($file)) {
				unlink($file);
			}
		}
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return confirm('您确定要删除吗？')">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <th width=95 height=22 align="center"><b>选中</b></th>
        <th width="1064" >备份数据库文件</th>
        <th width="234"><span class="title">下载备份文件</span></th>
      </tr>
	<?php
	// 检测备份目录是否存在，不存在则创建
	$path = "data/bakup/";
	if (!file_exists($path)) {
		@mkdir($path);
	}
	$st = 0;
	if ($dh = opendir($path)) {
		while (($file = readdir($dh)) !== false) {
			if ($file == '.' || $file == '..') continue;
	?>
      <tr class="darkrow"> 
        <td align="center"><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $path.$file?>"></td>
        <td><?php echo $file?></td>
        <td align="center"><a href="?mod=down&path=<?php echo urlencode($path)?>&file=<?php echo urlencode($file)?>">点击下载</a></td>
      </tr>
      <?php
	  		$st++;
	  }
	  if ($st>0) {
	  ?>
      <tr>
        <td colspan="3">&nbsp;<input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
          <input name="submit" type="submit" value="删 除" class="submit">
        </td>
      </tr>
      <?php }}
	  if ($st<1) {
	  ?>
      <tr>
        <td colspan="3" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
      <?php }?>
    </tbody> 
  </table>
</form>
<?php }?>
<?php require('bottom.php');?>
</body>
</html>