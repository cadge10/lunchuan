<?php
include("../../inc.php");

$code = adminpub::getsafecode();
if (base::s('m_logined')!=$code) {
	exit(base::msg('登录已超时或未登录，请返回登录。',WEB_DIR.'admincp.php?mod=login'));
}

$cfg_txttype = "htm|html|tpl|txt";
$uploadfile = @$_FILES["uploadfile"]['tmp_name'];
$uploadfile_type = @$_FILES["uploadfile"]['type'];
$uploadfile_name = @$_FILES["uploadfile"]['name'];
$filename = isset($_POST["filename"])?trim($_POST["filename"]):"";
$f = isset($_POST["f"])?trim($_POST["f"]):"";

$cfg_basedir = __ROOT__;
$activepath = isset($_POST["activepath"])?trim($_POST["activepath"]):"";

if(empty($uploadfile))
{
    $uploadfile = "";
}
if(!is_uploaded_file($uploadfile))
{
    ShowMsg("你没有选择上传的文件!","-1");
    exit();
}
if(!preg_match("#^text#", $uploadfile_type))
{
    ShowMsg("你上传的不是文本类型附件!","-1");
    exit();
}
if(!preg_match("#\.(".$cfg_txttype.")#i", $uploadfile_name))
{
    ShowMsg("你所上传的模板文件类型不能被识别，只允许htm、html、tpl、txt扩展名！","-1");
    exit();
}
if($filename != "")
{
    $filename = trim(preg_replace("#[ \r\n\t\*\%\\\/\?><\|\":]{1,}#", '', $filename));
}
else
{
    $uploadfile_name = trim(preg_replace("#[ \r\n\t\*\%\\\/\?><\|\":]{1,}#", '', $uploadfile_name));
    $filename = $uploadfile_name;
    if($filename=='' || !preg_match("#\.(".$cfg_txttype.")#i", $filename))
    {
        ShowMsg("你所上传的文件存在问题，请检查文件类型是否适合！","-1");
        exit();
    }
}
$fullfilename = $cfg_basedir.$activepath."/".$filename;
move_uploaded_file($uploadfile,$fullfilename) or die("上传文件到 $fullfilename 失败！");
@unlink($uploadfile);
ShowMsg("成功上传文件！","select_templates.php?comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".time());
exit();


/**
 *  短消息函数,可以在某个动作处理后友好的提示信息
 *
 * @param     string  $msg      消息提示信息
 * @param     string  $gourl    跳转地址
 * @param     int     $onlymsg  仅显示信息
 * @param     int     $limittime  限制时间
 * @return    void
 */
function ShowMsg($msg, $gourl, $onlymsg=0, $limittime=0)
{
    if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

    $htmlhead  = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<center>\r\n<script>\r\n";
    $htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    $litime = ($limittime==0 ? 1000 : $limittime);
    $func = '';

    if($gourl=='-1')
    {
        if($limittime==0) $litime = 5000;
        $gourl = "javascript:history.go(-1);";
    }

    if($gourl=='' || $onlymsg==1)
    {
        $msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
    }
    else
    {
        //当网址为:close::objname 时, 关闭父框架的id=objname元素
        if(preg_match('/close::/',$gourl))
        {
            $tgobj = trim(preg_replace('/close::/', '', $gourl));
            $gourl = 'javascript:;';
            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
        }
        
        $func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
        $rmsg = $func;
        $rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url(img/wbg.gif)';'><b>提示信息！</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
        $rmsg .= "document.write(\"";
        
        if($onlymsg==0)
        {
            if( $gourl != 'javascript:;' && $gourl != '')
            {
                $rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
                $rmsg .= "<br/></div>\");\r\n";
                $rmsg .= "setTimeout('JumpUrl()',$litime);";
            }
            else
            {
                $rmsg .= "<br/></div>\");\r\n";
            }
        }
        else
        {
            $rmsg .= "<br/><br/></div>\");\r\n";
        }
        $msg  = $htmlhead.$rmsg.$htmlfoot;
    }
    echo $msg;
}
?>