<?php
//error_reporting(E_ALL || ~E_NOTICE);
header("content-type:text/html;charset=utf-8");
$error = '';
$next_enable = '';
if (file_exists('./install/install.lock')) {
	$error = "您已经安装过该系统，如需重新安装，请删除install/install.lock文件后，再重新访问该页面。";
	$next_enable = ' disabled';
}
$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
if ($step < 1) $step = 1;

if ($step == 1) {
    //运行环境监测
    $checkarr = array('name'=>'PHP版本','access'=>'5.2.0');
    if(phpversion()>='5.2.0') {
        $checkarr['currently'] = '<span class="font_3">√ '.phpversion().'</span>';
    } else {
        $next_enable = ' disabled';
        $checkarr['currently'] = '<span class="font_1">× '.phpversion().'</span>';
    }
    $accessevns[] = $checkarr;
    //GD库
    $checkarr = array('name'=>'GD库版本','access'=>'需开启');
    if(function_exists('gd_info')) {
        $checkarr['currently'] = '<span class="font_3">√ 已开启</span>';
    } else {
        $next_enable = ' disabled';
        $checkarr['currently'] = '<span class="font_1">× 未开启</span>';
    }
    $accessevns[] = $checkarr;
    //附件上传
    $checkarr = array('name'=>'附件上传','access'=>'需开启');
    if(ini_get('file_uploads')) {
        $checkarr['currently'] = '<span class="font_3">√ 以开启</span>';
    } else {
        $next_enable = ' disabled';
        $checkarr['currently'] = '<span class="font_1">× 未开启</span>';
    }
	$accessevns[] = $checkarr;
	//Mysql 版本
    $checkarr = array('name'=>'MYSQL','access'=>'需开启');
    if(function_exists('mysql_connect')) {
        $checkarr['currently'] = '<span class="font_3">√ 以开启</span>';
    } else {
        $next_enable = ' disabled';
        $checkarr['currently'] = '<span class="font_1">× 未开启</span>';
    }
	$accessevns[] = $checkarr;

    //文件目录属性监测
    include './install/accessfiles.php';
    foreach($accessfiles as $key => $access) {
        $checkfile = $access['name'];
        if(!file_exists($checkfile)) {
            $next_enable = ' disabled';
            $access['currently'] = '<span class="font_1">× 不存在</span>';
        } elseif(!is_readable($checkfile) && $access['access'] == '可读') {
            $next_enable = ' disabled';
            $access['currently'] = '<span class="font_1">× 不可读</span>';
        } elseif(!is__writable($checkfile) && $access['access'] == '可写') {
            $next_enable = ' disabled';
            $access['currently'] = '<span class="font_1">× 不可写</span>';
        } else {
            if(is_readable($checkfile) && $access['access'] == 'read') {
                $access['currently'] = '<span class="font_3">√ 可读</span>';
            }
            if(is__writable($checkfile)) {
                $access['currently'] = '';
				$access['currently'] .= $access['currently'] ? ',可写' : '<span class="font_3">√ 可写</span>';
            }
        }
        $accessfiles[$key] = $access;
    }
} elseif ($step == 2) {

} else if ($step == 3) {
	$system_exists = false;
	if(!isset($_POST['system_exists_confirm'])) {
		$dbhost = trim($_POST['dbhost']);
		$dbport = trim($_POST['dbport']);
		$dbuser = trim($_POST['dbuser']);
		$dbpw = trim($_POST['dbpw']);
		$dbname = trim($_POST['dbname']);
		$dbpre = trim($_POST['dbpre']);
		$dbengine = trim($_POST['dbengine']);
		$cookiepre = trim($_POST['cookiepre']);
		$webdir = trim($_POST['webdir']);
		
		$error = '';
	
		if ($dbhost=='') $error .= '<li>未填写数据库服务器地址.</li>';
		if ($dbuser=='') $error .= '<li>未填写数据库用户名.</li>';
		if ($dbname=='') $error .= '<li>未填写数据库名.</li>';
		if ($dbpre=='') $error .= '<li>未填写数据表前缀.</li>';
		if ($dbengine=='') $error .= '<li>未填写数据库引擎，必须是mysql或mysqli，并且该扩展必须存在.</li>';
		if ($cookiepre=='') $error .= '<li>未输入Cookie前缀.</li>';
		if ($webdir=='') $error .= '<li>网站根目录不能为空.</li>';
		if(strlen($cookiepre) < 3 && $cookiepre!='') $error .= '<li>Cookie前缀不能小于3个字符.</li>';
		if(strstr($dbpre, '.')) $error .= "<li>您指定的数据表前缀包含点字符，请返回修改.</li>";
		$curr_php_version = PHP_VERSION;
		if($curr_php_version < '5.2.0') $error .= "<li>您的PHP版本低于5.2.0, 无法安装使用该系统</li>";
		
		if (!$conn = @mysql_connect($dbhost.':'.$dbport,$dbuser,$dbpw)) {
			$error .= '<li>数据库连接错误！错误代码：'.mysql_errno().' 错误描述：'.mysql_error().'.</li>';
		} else {
			if (!@mysql_select_db($dbname,$conn))  {
				$result = @mysql_query("CREATE DATABASE IF NOT EXISTS `".$dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;",$conn);
				if (!$result) $error .= '<li>数据库不存在，且无法自动创建，请正确填写数据库名.</li>';
			}
		}
		
		if ($error != '') {
			$next_enable = ' disabled';
		}
		
		// 配置信息
		$filecontent = '<?php';
		$filecontent .= "
// 配置信息，一般不需要手动修改
define('APP_SAFECODE','$cookiepre');
define('DB_HOST','$dbhost');
define('DB_PORT','$dbport');
define('DB_NAME','$dbname');
define('DB_USER','$dbuser');
define('DB_PASSWORD','$dbpw');
define('DB_PREFIX','$dbpre');
define('DB_ENGINE_NAME','$dbengine');
define('WEB_DIR','$webdir');
// 路由配置
define('URL_ROUTER_ON',true);// 开启路由
define('URL_MODE',1); // 定义路由类型，选择值：0，原生字符串 1，伪静态字符串
define('URL_PATHINFO',1); // 说明：0 /，1 index.php/
define('URL_SEPAPARATOR','-'); // 伪静态时，字符串分隔符
define('URL_EXT','.html'); // 伪静态时结尾的扩展名
";
		$filecontent .= '?>';
		if($fp = @fopen('./config.php', 'w')) {
			@fwrite($fp, trim($filecontent));
			@fclose($fp);
		} else {
			echo '写入配置文件失败,请检查文件和目录权限.';
			exit();
		}
		$system_exists = false;
		if($result = @mysql_query("SELECT COUNT(*) FROM {$dbpre}config",$conn)) {
			$system_exists = true;
		}
		if($error) $step = 2;
	}
} elseif($step == '4') {
	include('inc.php');
    $username = trim(base::p('username'));
    $password = trim(base::p('password'));
    $repassword = trim(base::p('repassword'));
	if ($username == '' || strlen($username) < 2) $error .= '<li>用户名不能为空，且大于2位.</li>';
	if ($password=='') $error .= '<li>密码不能为空.</li>';
	if ($password!=$repassword) $error .= '<li>密码与确认密码必须相同.</li>';
	
	$file = 'install/install.sql';
	if($fp = fopen($file, 'rb'))  {
        $sql = fread($fp, filesize($file));
        fclose($fp);
    } else {
        $error = '无法读取安装数据库文件。';
    }
	
	if ($error != '') {
		$step = 3;
		$system_exists = false;
	} else {
		$mdpass = base::md5($password);
		$str= str_replace('###pre###cms_',DB_PREFIX,$sql); // 替换数据库表前缀
		$str=str_replace("\r","\n",$str);
		$sqlarr=explode(";\n",trim($str));
		$queryarr = array();
		foreach($sqlarr as $key => $values)
		{
			foreach(explode("\n",trim($values)) as $rows)
			@$queryarr[$key].= $rows[0]=='#' || $rows[0].$rows[1] == '--' ? '' : $rows;
		}
		$link=mysql_connect(DB_HOST.':'.DB_PORT,DB_USER,DB_PASSWORD);
		mysql_select_db(DB_NAME,$link);
		mysql_query("set names 'utf8'",$link);
		foreach($queryarr as $values)
		{
			if(!@mysql_query($values,$link))
			{
				exit('未知错误！');
			}
		}
		// 添加管理员账户
		$sql = "INSERT INTO `###_admin` (`id`, `username`, `password`, `roleid`, `sys`, `addtime`, `ip`, `lasttime`, `isshow`) VALUES (1, '".$username."', '".$mdpass."', '0', '1', '".$time."', '".$_SERVER['REMOTE_ADDR']."', '".$time."', '1')";
		$re = @$db->query($sql,false);
		// 锁定安装
		$f = @file_put_contents('./install/install.lock','Install time:'.$nowtime);
		
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>鼎易通用网站系统 - 安装程序</title>
<link href="./install/install.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
<form method="post" action="">
<h1 id="subject">
    <span id="copyright">Copyright &copy; 2005-<?php echo date("Y");?> <a href="http://www.zjr1.com/" target="_blank">zjr1.com</a></span>
    <span id="title">鼎易网站管理系统 - 安装程序</span>
    <div class="clear"></div>
</h1>
<?php if($step == 1) { ?>
<div id="step">第一步:检测运行环境以及目录文件权限</div>
<?php if($error) {?><div id="error"><?php echo $error?></div><?php } ?>

运行环境：
<table>
    <tr id="tbth">
        <td width="60%">项目</td>
        <td width="20%" align="center">基本所需</td>
        <td width="20%" align="center">当前状态</td>
    </tr>
    <?php foreach($accessevns as $val) { ?>
    <tr><td><?php echo $val['name']?></td><td align="center"><?php echo $val['access']?></td><td align="center"><?php echo $val['currently']?></td></tr>
    <?php } ?>
</table>
文件目录权限：
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr> 
  <td height="25"><font color="#FF0000">如果您的服务器使用 
      Windows 操作系统，可跳过这一步。</font></td>
</tr>
<tr> 
  <td height="25"> 将下面目录权限设为0777, 除了红色目录外，是目录全部要把权限应用于子目录与文件。 
    </td>
</tr>
<table>
    <tr id="tbth">
        <td width="60%">目录文件名称</td>
        <td width="20%" align="center">所需状态</td>
        <td width="20%" align="center">当前状态</td>
    </tr>
    <?php foreach($accessfiles as $accessfile) { ?>
    <tr><td><?php echo $accessfile['name']?></td><td align="center"><?php echo $accessfile['access']?></td><td align="center"><?php echo $accessfile['currently']?></td></tr>
    <?php } ?>
</table>
<div id="comment">如果您无法确认以上的配置信息，请与您的服务商联系。</div>
<input type="hidden" name="step" value="2" />

<?php } elseif($step == 2) { ?>
<div id="step">第二步:配置数据库和基本信息</div>
<?php if($error) {?><div id="error"><?php echo $error?></div><?php } ?>
<table>
    <tr id="tbth"><td width="150">设置项</td><td width="240">值</td><td width="*">说明</td></tr>
    <tr><td>服务器地址:</td><td><input type="text" name="dbhost" class="t_input" value="localhost" /></td><td>一般是 localhost(当前正在安装Modoer的服务器)</td></tr>
    <tr>
      <td>数据库端口:</td>
      <td><input type="text" name="dbport" class="t_input" value="3306" id="dbport" /></td>
      <td>一般是3306，如果不是，请更改</td>
    </tr>
    <tr><td>数据库名:</td><td><input type="text" name="dbname" class="t_input" value="mysoft" /></td>
    <td>填写数据表安装所在数据库(数据库不存在自动创建)</td></tr>
    <tr><td>数据库用户名:</td><td><input type="text" name="dbuser" class="t_input" value="root" /></td><td>可以连接数据库的帐号</td></tr>
    <tr><td>数据库用户密码:</td><td><input type="password" name="dbpw" class="t_input" /></td><td></td></tr>
    <tr><td>数据表前缀:</td><td><input type="text" name="dbpre" class="t_input" value="cms_" /></td>
    <td>同一数据库安装多个本系统时，请更改</td></tr>
    <tr>
      <td>数据库引擎:</td>
      <td><?php
      if (function_exists('mysqli_init')) {
		  $engine = 'mysqli';
	  } else {
		  $engine = 'mysql';
	  }
	  ?><input type="text" name="dbengine" class="t_input" value="<?php echo $engine;?>" id="dbengine" /></td>
      <td><?php if ($engine == 'mysqli'){?><span style="color:#F00;">支持mysqli </span><?php }?>选择一种数据库引擎，mysql或mysqli</td>
    </tr>
    <tr><td>Cookie前缀:</td><td><input type="text" name="cookiepre" class="t_input" value="<?php echo rand_str(10)?>" /></td><td>任意3-10个字符, 不能和任何其他系统重复</td></tr>
    <tr>
      <td>网站根目录：</td>
      <td><input name="webdir" type="text" class="t_input" id="webdir" value="/" /></td>
      <td>如果放在根目录下不需修改，否则格式为“/子目录/”</td>
    </tr>
</table>
<div id="comment">如果您无法确认以上的配置信息，请与您的服务商联系。</div>
<input type="hidden" name="step" value="3" />
<?php } elseif($step == 3) { ?>
<?php if($system_exists) { ?>
<div id="error">数据库中已经安装过该系统，继续安装会清空原有数据.<br />继续安装会清空全部原有数据，您确定要继续吗？</div>
<input type="hidden" name="system_exists_confirm" value="true" />
<input type="hidden" name="step" value="3" />
<?php } else { ?>
<div id="step">第三步:设置管理员账号</div>
<div id="msg" style="color:#00F;">成功链接数据库。<br />
您的服务器可以安装和使用该系统，请设置管理员帐号。</div>
<?php if($error) { ?><div id="error"><?php echo $error?></div><?php } ?>
<table>
    <tr id="tbth"><td width="150">设置项</td><td width="240">值</td><td width="*">说明</td></tr>
    <tr><td>创始人:</td><td><input type="text" name="username" class="t_input" value="admin" /></td><td>限2-15个字符</td></tr>
    <tr><td>管理员密码:</td><td><input type="password" name="password" class="t_input" /></td><td>不宜过短</td></tr>
    <tr><td>确认密码:</td><td><input type="password" name="repassword" class="t_input" id="repassword" /></td><td></td></tr>
</table>
<div id="comment">请认真确认以上信息，下一步将建立数据表，完成安装。</div>
<input type="hidden" name="step" value="4" />
<?php } ?>
<?php } elseif($step == 4) { ?>
<div id="step">第4步:创建数据表</div>
<div id="msg">安装程序已经顺利执行完毕，请尽快删除 <span class="font_1">install.php</span> 和 <span class="font_1">install</span> 目录，以免被他人恶意利用。<br />
  感谢您使用鼎易魔方建站系统。</div>
<div id="control">管理员帐号: <?php echo $username?><br />管理员密码: <?php echo $password?><br /><br /><a href="admincp.php?mod=login">后台管理</a><br /><a href="./">前台首页</a></div>
<?php } ?>
<?php if(is_numeric($step)) { ?>
<div id="next">
    <?php if($step >= 1 && $step <=3) { ?><button type="button" name="name" onclick="history.go(-1);">上一步</button>&nbsp;<?php } ?>
    <?php if($step >=1 && $step < 4) { ?><button type="submit" name="name"<?php echo $next_enable?>>下一步</button><?php } ?>
</div>
<?php } ?>
</form>
</div>
<?php
//判断文件是否可写
function is__writable($path) {
    if ($path{strlen($path)-1}=='/')
        return is__writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
}
function rand_str($length){
	$low_ascii_bound=50;
	$upper_ascii_bound=122;
	$notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
	$i = 0;
	$password1 = '';
	while($i<$length)
	{
		mt_srand((double)microtime()*1000000);
		$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
		if(!in_array($randnum,$notuse))
		{
			$password1=$password1.chr($randnum);
			$i++;
		}
	}
	return $password1;
}
?>
</body>
</html>