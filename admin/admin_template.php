<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$template_url = "templates";
$default_url = pub::get_config("web_template_url")!=""?pub::get_config("web_template_url"):"default";
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
/**
 * 安装模版
 */
function setupTemplate(tpl) {
	if (confirm("您确定要选择此模板吗？")) {
		$.get("admincp.php",{"r":Math.random(),"a":"ajax","mod":"admin_template_select","default_url":tpl},function(data){
			data = $.trim(data);
			json = StrToJSON(data);
			showTemplateInfo(json);
		})
	}
}
/**
 * 显示模板信息
 */
function showTemplateInfo(res) {

  StyleSelected = res.stylename;

  document.getElementById("screenshot").src = res.screenshot;
  document.getElementById("templateName").innerHTML    = res.name;
  document.getElementById("templateDesc").innerHTML    = res.desc;
  document.getElementById("templateVersion").innerHTML = res.version;
  document.getElementById("templateAuthor").innerHTML  = '<a href="' + res.uri + '" target="_blank">' + res.author + '</a>';
}
function StrToJSON(str) {
	json = eval('('+str+')');
	return json;
}
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>



<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
      <td><strong>当前模板</strong></td>
    </tr>
    <tr>
      <td>
      
    
    <?php
	if (!file_exists($template_url.'/'.$default_url)) {
		$default_url = "default";
	}
	if (!file_exists($template_url.'/'.$default_url)) {
		$template_arr = array();
		if ($handle = opendir($template_url)) {		
			/* 这是正确地遍历目录方法 */
			while (false !== ($file = readdir($handle))) {
				if (($file != '.' && $file != '..') && (file_exists($template_url))) {
					$template_arr[] = $file;
				}
			}	
			closedir($handle);
		}
		if (empty($template_arr)) exit(base::msg("模板目录下至少存在一个模板。"));
		$default_url = $template_arr[0];
	}
	
	$xml_url = $template_url.'/'.$default_url.'/themes.xml';
	if (!file_exists($xml_url)) exit(base::msg("模板“themes.xml”说明文件必须存在。"));
	$xml = simplexml_load_file($xml_url);
	?>
    <table>
      <tbody><tr>
        <td align="center" width="220"><img id="screenshot" src="templates/<?php echo $default_url?>/images/screenshot.png"></td>
        <td valign="top"><strong><span id="templateName"><?php echo $xml->template_name?></span></strong> v<span id="templateVersion"><?php echo $xml->version?></span><br>

          <span id="templateAuthor"><a href="<?php echo $xml->author_url?>" target="_blank"><?php echo $xml->author?></a></span><br>
          <span id="templateDesc"><?php echo $xml->description?></span><br>
          <span><a href="?mod=admin_template_manage&theme=<?php echo $default_url?>" style=" color:#F00; text-decoration:underline;">管理</a></span>
        </td></tr>
    </tbody></table>
    
      
      </td>
    </tr>
    <tr>
      <td><strong>可用模板（点击模板截图即可选择您需要的模板。）</strong></td>
    </tr>
    <tr>
      <td>


    <?php
	$template_arr = array();
	if (!file_exists($template_url)) exit(base::msg("模板目录不存在，请检查。"));
	// 读取模板目录
	if ($handle = opendir($template_url)) {
		
		/* 这是正确地遍历目录方法 */
		while (false !== ($file = readdir($handle))) {
			if (($file != '.' && $file != '..') && (file_exists($template_url))) {
				$template_arr[] = $file;
			}
		}	
		closedir($handle);
	}
	
	foreach($template_arr as $key=>$val) {
		// 读取模板目录下的xml文件
		$xml_url = $template_url.'/'.$val.'/themes.xml';
		if (!file_exists($xml_url)) exit($val."目录下模板“themes.xml”说明文件不存在，不能往下，请添加。");
		$xml = simplexml_load_file($xml_url);
	?>
    <div style=" float:left; margin:0px 5px; vertical-align: top;">
    <table style="width: 220px;">
      <tbody><tr>
        <td><span style="float:right;"><a href="?mod=admin_template_manage&theme=<?php echo $val?>" style=" color:#F00; text-decoration:underline;">管理</a></span><span style="float:left; font-weight:bold;"><a href="<?php echo $xml->template_url?>" target="_blank"><?php echo $xml->template_name?></a></span></td>
      </tr>
      <tr>
        <td><img src="templates/<?php echo $val?>/images/screenshot.png" style="cursor: pointer; float: left; margin: 0pt 2px; display: block;" id="default" onClick="javascript:setupTemplate('<?php echo $val?>')" border="0"></td>

      </tr>

      <tr>
        <td valign="top"><?php echo $xml->description?></td>
      </tr>
    </tbody></table>
    </div>
    <?php
	}
	?>


      </td>
    </tr>
  </tbody> 
</table>


<?php include('bottom.php');?>
</body>
</html>