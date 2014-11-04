<?php
include("../../inc.php");

$code = adminpub::getsafecode();
if (base::s('m_logined')!=$code) {
	exit(base::msg('登录已超时或未登录，请返回登录。',WEB_DIR.'admincp.php?mod=login'));
}

$activepath = isset($_GET['activepath'])?trim($_GET['activepath']):'';
$f = isset($_GET['f'])?trim($_GET['f']):'form1.template_url_show';

$cfg_basedir = __ROOT__;
$cfg_templets_dir = '/templates';

$cfg_txttype = 'htm|html|tpl|txt';
$activepath = str_replace('.', '', $activepath);
$activepath = preg_replace("#\/{1,}#", '/', $activepath);
$templetdir  = $cfg_templets_dir;
if(strlen($activepath) < strlen($templetdir))
{
    $activepath = $templetdir;
}
$inpath = $cfg_basedir.$activepath;
$activeurl = '..'.$activepath;

if(empty($comeback))
{
    $comeback = '';
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>模板管理器</title>
<style>
* {font-size: 12px;line-height: 1.5;}
body {font-size: 12px;line-height: 1.5;}
select,textarea{vertical-align:middle;background: url(input.png) repeat-x scroll 0px 0px;}
a:link { font-size: 12px; color: #000000; text-decoration: underline }
a:visited{ font-size: 12px; color: #000000; text-decoration: underline }
a:hover {font-size: 12px;color: red}
div,form,h1,h2,h3,h4,h5,h6{	margin: 0; padding:0;}
.m1{border-left: 1px solid #DFDFDB; border-top: 1px solid #DFDFDB; border-bottom: 1px solid #808080}
.m2{border-left: 1px solid #DFDFDB; border-bottom: 1px solid #808080; border-top: 1px solid #DFDFDB;border-right: 1px solid #DFDFDB;}
.m3{border-left: 1px solid #DFDFDB; border-top: 1px solid #DFDFDB;border-right: 1px solid #DFDFDB;}
.article{FONT-SIZE: 10pt; LINE-HEIGHT: 160%；table-layout:fixed;word-break:break-all}
.bn{color:#FFFFFF;font-size:0.1pt;line-height:50%}
.contents{font-size:1pt;color:#F7F6F8}
.nb{border: 1px solid #000000;height:18px}
.coolbg {border-right: 2px solid #ACACAC; border-bottom: 2px solid #ACACAC; background-color: #E6E6E6}
.ctfield{ padding: 3px; line-height: 150%}
.nndiv{ width: 175px; height:20px; margin: 0px;padding: 0px;word-break: break-all;overflow: hidden; }
.alltxt {
	border-width:1px;
	border-style:solid;
	border-color:#707070 #CECECE #CECECE #707070;
	padding:2px 4px;
	height:18px;
	line-height:18px;
	vertical-align:middle;
}

.linerow {border-bottom: 1px solid #CBD8AC;}
</style>
</head>
<body background='img/allbg.gif' leftmargin='0' topmargin='0'>
<SCRIPT language='JavaScript'>
function nullLink()
{
	return;
}
function ReturnValue(reimg)
{
	window.opener.document.<?php echo $f?>.value=reimg;
	if(document.all) window.opener=true;
  window.close();
}
</SCRIPT>
<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#CBD8AC' align="center">
<tr bgcolor='#FFFFFF'>
<td colspan='3'>
<!-- 开始文件列表  -->
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
<tr bgcolor="#CCCCCC">
<td width="55%" align="center" background="img/wbg.gif" class='linerow'><strong>点击名称选择文件</strong></td>
<td width="15%" align="center" bgcolor='#EEF4EA' class='linerow'><strong>文件大小</strong></td>
<td width="30%" align="center" background="img/wbg.gif" class='linerow'><strong>最后修改时间</strong></td>
</tr>
<?php
$dh = dir($inpath);
$ty1="";
$ty2="";
while($file = $dh->read()) {
    //-----计算文件大小和创建时间
    if($file!="." && $file!=".." && !is_dir("$inpath/$file")){
        $filesize = filesize("$inpath/$file");
        $filesize = $filesize / 1024;
        if($filesize != "")
        if($filesize < 0.1)
        {
           @list($ty1,$ty2) = split("\.", $filesize);
           $filesize=$ty1.".".substr($ty2, 0, 2);
        } else {
           @list($ty1,$ty2) = split("\.", $filesize);
           $filesize=$ty1.".".substr($ty2, 0, 1);
        }
        $filetime = filemtime("$inpath/$file");
        $filetime = date("Y-m-d H:i:s", $filetime);
    }

     //------判断文件类型并作处理
     if($file == ".") continue;
     else if($file == "..")
     {
        if($activepath == "") continue;
        $tmp = preg_replace("#[\/][^\/]*$#", "", $activepath);
        $line = "\n<tr>
        <td class='linerow'> <a href='select_templates.php?f=$f&activepath=".urlencode($tmp)."'><img src=img/dir2.gif border=0 width=16 height=16 align=absmiddle>上级目录</a></td>
        <td colspan='2' class='linerow'> 当前目录:$activepath</td>
        </tr>\r\n";
        echo $line;
    }
    else if(is_dir("$inpath/$file"))
    {
        if(preg_match("#^_(.*)$#i", $file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
        if(preg_match("#^\.(.*)$#i", $file)) continue;
        $line = "\n<tr>
       <td bgcolor='#F9FBF0' class='linerow'>
        <a href=select_templates.php?f=$f&activepath=".urlencode("$activepath/$file")."><img src=img/dir.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>-</td>
       <td bgcolor='#F9FBF0' class='linerow'>-</td>
       </tr>";
        echo "$line";
    } else if(preg_match("#\.(htm|html)#i", $file))
    {

        if($file==$comeback) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."\/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/htm.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    } else if(preg_match("#\.(css)#i", $file))
    {
        if($file==$comeback) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/css.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    } else if(preg_match("#\.(js)#i", $file))
    {
        if( $file == $comeback ) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."\/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/js.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    } else if(preg_match("#\.(jpg)#i", $file))
    {
        if($file==$comeback) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."\/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/jpg.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    } else if(preg_match("#\.(gif|png)#i", $file))
    {

        if($file==$comeback) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."\/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/gif.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    }
    else if(preg_match("#\.(txt)#i", $file))
    {

        if($file==$comeback) $lstyle = " style='color:red' ";
        else  $lstyle = "";

        $reurl = "$activeurl/$file";

        $reurl = preg_replace("#\.\.#", "", $reurl);
        $reurl = preg_replace("#".$templetdir."\/#", "", $reurl);

        $line = "\n<tr>
       <td class='linerow' bgcolor='#F9FBF0'>
         <a href=\"javascript:ReturnValue('$reurl');\" $lstyle><img src=img/txt.gif border=0 width=16 height=16 align=absmiddle>$file</a>
       </td>
       <td class='linerow'>$filesize KB</td>
       <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
       </tr>";
        echo "$line";
    }
}//End Loop
$dh->close();
?>
<!-- 文件列表完 -->
<tr>
<td colspan='3' bgcolor='#E8F1DE'>

<table width='100%'>
<form action='select_templates_post.php' method='POST' enctype="multipart/form-data" name='myform'>
<input type='hidden' name='activepath' value='<?php echo $activepath?>'>
<input type='hidden' name='f' value='<?php echo $f?>'>
<input type='hidden' name='job' value='upload'>
<tr>
<td background="img/tbg.gif" bgcolor="#99CC00">
  &nbsp;上　传： <input type='file' name='uploadfile' style='width:320px'>
  改名：<input type='text' name='filename' value='' style='width:100px'>
  <input type='submit' name='sb1' value='确定'>
</td>
</tr>
</form>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

</body>
</html>